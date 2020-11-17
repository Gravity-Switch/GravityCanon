window.gscTabInit = function (tabContainer) {
  let tablist = tabContainer.querySelector('[role="tablist"]');
  let tabs;
  let panels;

  let generateArrays = function() {
    tabs = tabContainer.querySelectorAll('[role="tab"]');
    panels = tabContainer.querySelectorAll('[role="tabpanel"]');
  }
  generateArrays();
  if (tabs.length > 0 && panels.length > 0 ) {

    // For easy reference
    let keys = {
      end: 35,
      home: 36,
      left: 37,
      up: 38,
      right: 39,
      down: 40,
      delete: 46,
      enter: 13,
      space: 32,
    };

    // Add or subtract depending on key pressed
    let direction = {
      37: -1,
      38: -1,
      39: 1,
      40: 1,
    };

    // When a tab is clicked, activateTab is fired to activate it
    let clickEventListener = function(event) {
      let tab = event.target;
      activateTab(tab, true);
    }

    // Handle keydown on tabs
    let keydownEventListener = function(event) {
      let key = event.keyCode;

      switch (key) {
        case keys.end:
          event.preventDefault();
          // Activate last tab
          focusLastTab();
          break;
        case keys.home:
          event.preventDefault();
          // Activate first tab
          focusFirstTab();
          break;

        // Up and down are in keydown
        // because we need to prevent page scroll >:)
        case keys.up:
        case keys.down:
          determineOrientation(event);
          break;
      }
    }

    // Handle keyup on tabs
    let keyupEventListener = function(event) {
      let key = event.keyCode;

      switch (key) {
        case keys.left:
        case keys.right:
          determineOrientation(event);
          break;
        case keys.delete:
          //determineDeletable(event);
          break;
        case keys.enter:
        case keys.space:
          activateTab(event.target);
          break;
      }
    }

    // When a tablistÃ¢â‚¬â„¢s aria-orientation is set to vertical,
    // only up and down arrow should function.
    // In all other cases only left and right arrow function.
    let determineOrientation = function(event) {
      let key = event.keyCode;
      let vertical = tablist.getAttribute("aria-orientation") == "vertical";
      let proceed = false;

      if (vertical) {
        if (key === keys.up || key === keys.down) {
          event.preventDefault();
          proceed = true;
        }
      } else {
        if (key === keys.left || key === keys.right) {
          proceed = true;
        }
      }

      if (proceed) {
        switchTabOnArrowPress(event);
      }
    }

    // Either focus the next, previous, first, or last tab
    // depending on key pressed
    let switchTabOnArrowPress = function(event) {
      let pressed = event.keyCode;

      if (direction[pressed]) {
        let target = event.target;
        if (target.index !== undefined) {
          if (tabs[target.index + direction[pressed]]) {
            tabs[target.index + direction[pressed]].focus();
          } else if (pressed === keys.left || pressed === keys.up) {
            focusLastTab();
          } else if (pressed === keys.right || pressed == keys.down) {
            focusFirstTab();
          }
        }
      }
    }

    // Activates any given tab panel
    let activateTab = function(tab, setFocus) {
      setFocus = (setFocus === 'undefined') ? true : setFocus;
      // Deactivate all other tabs
      deactivateTabs();

      // Remove tabindex attribute
      tab.removeAttribute("tabindex");

      // Set the tab as selected
      tab.setAttribute("aria-selected", "true");

      // Add active class to selected tab
      tab.classList.add("is-active");

      // Get the value of aria-controls (which is an ID)
      let controls = tab.getAttribute("aria-controls");

      // Remove hidden attribute from tab panel to make it visible
      if (document.getElementById(controls)) {
        document.getElementById(controls).removeAttribute("aria-hidden");
      }

      // Set focus when required
      if (setFocus) {
        tab.focus();
      }
    }

    // Deactivate all tabs and tab panels
    let deactivateTabs = function() {
      for (t = 0; t < tabs.length; t++) {
        tabs[t].setAttribute("tabindex", "-1");
        tabs[t].setAttribute("aria-selected", "false");
        tabs[t].classList.remove("is-active");
      }

      for (p = 0; p < panels.length; p++) {
        panels[p].setAttribute("aria-hidden", "true");
      }
    }

    // Make a guess
    let focusFirstTab = function() {
      tabs[0].focus();
    }

    // Make a guess
    let focusLastTab = function() {
      tabs[tabs.length - 1].focus();
    }

    // Determine whether there should be a delay
    // when user navigates with the arrow keys
    let determineDelay = function() {
      let hasDelay = tablist.hasAttribute("data-delay");
      let delay = 0;

      if (hasDelay) {
        let delayValue = tablist.getAttribute("data-delay");
        if (delayValue) {
          delay = delayValue;
        } else {
          // If no value is specified, default to 300ms
          delay = 300;
        }
      }

      return delay;
    }

    let addListeners = function (index) {
      tabs[index].addEventListener("click", clickEventListener);
      tabs[index].addEventListener("keydown", keydownEventListener);
      tabs[index].addEventListener("keyup", keyupEventListener);

      // Build an array with all tabs (<button>s) in it
      tabs[index].index = index;
    }
    // Bind listeners
    for (let x = 0; x < tabs.length; ++x) {
      addListeners(x);
    }
    // Select first tab by default
    document.addEventListener("DOMContentLoaded", function (event) {
      activateTab(tabs[0], false);
    });
  }




    let firstTime = true;

    function updateWindowState() {
      let loadParams = new URLSearchParams(window.location.search);

      for (let entry of loadParams) {
        let object = entry[0];
        let setting = entry[1];
        if (object.substr(0,2) == "t_") {
          let selection = '#tabs-' + object.replace("t_","") + '__tab-link-' + setting;
          $(selection).click();
        }

      };

    }

    $(document).ready(function () {
      $('body').on("click", '.tabs__list button', function(event) {
        $target = $(event.target);
        let searchParams = new URLSearchParams(window.location.search);
        let term = $target.attr('id');
        let cut = term.search('__tab');
        term = "t_"+term.slice(5, cut);
        if ($target.closest('li').prevAll('li').length == 0) {
          if (!firstTime) {
            searchParams.delete(term);
          }
        }
        else {
          let buttonLocation = $target.closest('li').prevAll('li').length + 1;
          if ((searchParams).has(term)) {
            searchParams.set(term, buttonLocation);
          } else {
            searchParams.append(term, buttonLocation);
          }
        }
        searchString = '?' + searchParams;
        //window.history.pushState({}, null, searchString);
        window.history.replaceState({}, null, searchString+window.location.hash);
      });

      setTimeout(function() {
        new updateWindowState();
        // console.log('pushed new window state');
        firstTime = false;
      }, 200);

    });

}


  let tabContainers = document.querySelectorAll('.tabs');

  for (let i = 0; i < tabContainers.length; ++i) {
    gscTabInit(tabContainers[i]);
  }
