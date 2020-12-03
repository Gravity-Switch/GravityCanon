<?php

$defaults = [
  "content" => [
    "menu_items" => [

    ]
  ],
  "style" => [
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];

function strip_query_and_anchor ($str) {
  return strtok(strtok($str, '?'), '#');
}

function get_current_url () {
  if (get_permalink()) {
    return str_replace(home_url(), "", get_permalink());
  }
  else {
    return strip_query_and_anchor($_SERVER["REQUEST_URI"]);
  }
}

function buildMenu($menu_items, $is_sub = FALSE) {

  // if sub add nesting values
  if ($is_sub == TRUE) {
    $menu = "<ul class='list--nested'>";
  } else {
    $menu = "<ul class='list list--dividers'>";
  }
  foreach($menu_items as $item) {

    $link_class = "list__link";
    if ( (isset($item["active"]) && $item["active"]) ||
          get_current_url() == strip_query_and_anchor($item['url']) ) {
      $link_class .= " list__link--current-page";
    }

    $link_target = "_self";
    if (isset($item["target"])) {
      $link_target = $item["target"];
    }

    $item_link_html = gsc("link", [
      "content" => [
        "url" => $item["url"],
        "title" => $item["title"],
        "target" => $link_target,
      ],
      "style" => [
        "class" => $link_class,
        "wrapper" => FALSE,
      ],
    ]);
    $has_children = !empty($item["children"]);
    $current_list_class = $has_children ? "list__item--current-list" : "";
    $menu .= "<li class='list__item list__item--dividers $current_list_class'>$item_link_html";

    if ($has_children) {
      $menu .= buildMenu($item["children"], true);
    }

    $menu .= "</li>";

  }

  $menu .= "</ul>";

  return $menu;

}

gsc_define("sidebar", $defaults, function($data) {

    $class = $data["style"]["class"];

    $id="";
    if (!empty($data["style"]["id"])) {
      $id = "id='{$data["style"]["id"]}'";
    }

    $misc_attrs = "";
    if (!empty($data["style"]["attrs"])) {
      foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
        $misc_attrs .= "$attr_name='$attr_value' ";
      }
    }


    // Sidebar menu controls html
    $html = '';
    $html .= "<nav class='menu menu--sidebar {$class}' {$id} {$misc_attrs} role='navigation' aria-label='Page title navigation'>";
    $html .= "<div class='menu__controls'>";
    $close = gsc("btn", [
      "content" => [
        "type" => 'icon',
        "text" => 'Submenu'
      ],
      "style" => [
        "svg" => '<svg xmlns="http://www.w3.org/2000/svg" width="17.5" height="17.5" viewBox="0 0 17.5 17.5" aria-hidden="true">
              <title>List</title>
              <g transform="translate(-255.005 -4827)">
                <g transform="translate(255.755 4827.75)">
                  <path class="ico__path" d="M263.255,4830.75h10.667" transform="translate(-257.922 -4828.617)"></path>
                  <path class="ico__path" d="M263.255,4839.75h10.667" transform="translate(-257.922 -4831.217)"></path>
                  <path class="ico__path" d="M263.255,4848.75h10.667" transform="translate(-257.922 -4833.817)"></path>
                  <path class="ico__path" d="M255.755,4828.283a.534.534,0,0,1,.533-.533h2.133a.534.534,0,0,1,.533.533v2.134a.534.534,0,0,1-.533.533h-2.133a.534.534,0,0,1-.533-.533Z" transform="translate(-255.755 -4827.75)"></path>
                  <path class="ico__path" d="M255.755,4837.283a.533.533,0,0,1,.533-.533h2.133a.533.533,0,0,1,.533.533v2.133a.534.534,0,0,1-.533.534h-2.133a.534.534,0,0,1-.533-.534Z" transform="translate(-255.755 -4830.35)"></path>
                  <path class="ico__path" d="M255.755,4846.283a.534.534,0,0,1,.533-.533h2.133a.534.534,0,0,1,.533.533v2.134a.534.534,0,0,1-.533.533h-2.133a.534.534,0,0,1-.533-.533Z" transform="translate(-255.755 -4832.95)"></path>
                </g>
              </g>
            </svg>',
        "class" => 'js-btn-toggle',
        "attrs" => [
          "aria-expanded" => false,
          "aria-controls" => 'sidebar-menu'
        ]
      ]
    ]);
    $html .= $close;
    $html .= "</div>";
    $html .= "<div class='menu__overlay js-overlay'></div>";

    $html .= "<div class='menu__main js-menu' id='sidebar-menu'>";
    $html .= "<div class='menu__inner'>";
    $html .= "<div class='menu__top'>";
    $html .= "<div class='menu__close'>";

    // close button
    $html .= gsc("btn-close", [
      "content" => [
        "class" => 'js-close'
      ]
    ]);

    $html .= "</div>";
    $html .= "<!-- /.menu__close -->";
    $html .= "</div>";
    $html .= "<!-- /.menu__top -->";

    // Menu List
    $html .= "<div class='menu__list'>";

    // Menu List functionality + logic
    $menu_items = $data["content"]["menu_items"];

    $html .= buildMenu($menu_items);

    // Closing Tags
    $html .= "</div>";
    $html .= "<!-- /.menu__list -->";
    $html .= "</div>";
    $html .= "<!-- /.menu__inner -->";
    $html .= "</div>";
    $html .= "<!-- /.menu__main -->";
    $html .= "</nav>";

    return $html;
});
gsc_meta("sidebar", [MOLECULE]);
gsc_test("sidebar", "", function() {
  echo gsc("sidebar", [
    "content" => [
      "menu_items" => [
        [
          "url" => "https://example.com",
          "title" => "Jobs for the Next Decade",
        ],
        [
          "url" => "https://example.com",
          "title" => "See If A Job Fits",
          "children" => [
            [
              "url" => "https://example.com",
              "title" => "Data Dashboard",
            ],
            [
              "url" => "https://example.com",
              "title" => "Today’s Student Research",
            ],
            [
              "url" => "https://example.com",
              "title" => "Jobs Test",
            ],
            [
              "url" => "https://example.com",
              "title" => "Applying for A Job",
              "children" => [
                [
                  "url" => "https://example.com",
                  "title" => "Data Dashboard",
                ],
                [
                  "url" => "https://example.com",
                  "title" => "Today’s Student Research",
                ],
                [
                  "url" => "https://example.com",
                  "title" => "Jobs Test",
                ],
              ],
            ],
          ],
        ],
        [
          "url" => "/component-test/",
          "title" => "Component Test",
        ],
        [
          "url" => "/component-test/?only=sidebar",
          "title" => "Component Test - Sidebar",
        ],        [
          "url" => "/component-test/#somethinghere",
          "title" => "Component Test - Anchor",
        ],
        [
          "url" => "https://example.com",
          "title" => "Discover Your Interests &amp; Strengths",
        ],
        [
          "url" => "https://example.com",
          "title" => "Get Help Applying for A Job",
          "target" => "_blank",
        ],
      ],
    ],
  ]);

  echo "<br /><br />";

  echo gsc("sidebar", [
    "content" => [
      "menu_items" => [
        [
          "url" => "https://example.com",
          "title" => "Jobs for the Next Decade",
        ],
        [
          "url" => "https://example.com",
          "title" => "See If A Job Fits",
          "children" => [
            [
              "url" => "https://example.com",
              "title" => "Data Dashboard",
            ],
            [
              "url" => "https://example.com",
              "title" => "Today’s Student Research",
              "active" => TRUE,
            ],
            [
              "url" => "https://example.com",
              "title" => "Jobs Test",
            ],
          ]
        ]
      ]
    ],
    "style" => [
      "class" => "custom-class",
      "attrs" => [
        "custom-attr" => "attr"
      ]
    ]
  ]);
});

 ?>
