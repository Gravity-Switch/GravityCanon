(function () {
  let switchView = function (container, onToggle, offToggle) {
     //container.classList.remove("view--"+offToggle.dataset.toggle);
     //container.classList.add("view--"+onToggle.dataset.toggle);
     container.dataset.gridlist = onToggle.dataset.toggle;

     onToggle.classList.add("active");
     onToggle.setAttribute("aria-pressed", "true");

     offToggle.classList.remove("active");
     offToggle.setAttribute("aria-pressed", "false");

  };
  // grid list containers are identified by attribute data-gridlist, which takes no value.
  // functionality is clamped to this element

  let gridListContainers = document.querySelectorAll("[data-gridlist]");
  if (gridListContainers.length > 0) {
    for (let i = 0; i < gridListContainers.length; i++) {
      let container = gridListContainers[i];
      let toggleGrid = container.querySelector("[data-toggle='grid']");
      let toggleList = container.querySelector("[data-toggle='list']");

      toggleGrid.addEventListener("click", function(event) { switchView(container, toggleGrid, toggleList); });
      toggleList.addEventListener("click", function(event) { switchView(container, toggleList, toggleGrid); });

      //switchView(container, toggleGrid, toggleList);
      let handleMobile = function () {
        if(window.innerWidth < 768) {
          switchView(container, toggleGrid, toggleList);
        }
      };
      handleMobile();
      window.addEventListener("resize", handleMobile);
    }
  }
})();
