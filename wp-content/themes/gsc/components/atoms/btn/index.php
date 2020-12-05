<?php /*
<!-- Link styled as button -->
<a href="#" class="btn">Contact Us</a>

<!-- Button element with base .btn styling -->
<button type="button" class="btn">Contact Us</button>
 */

 $defaults = [
   "content" => [
     "button" => true, // if true: button element with button styling; if false: secondary link styled as button
     "active" => false, // for toggle buttons active/inactive styling
     "type" => '', // secondary, toggle, modal, icon; blank for default
     "main" => '',
     "text" => '',
     "url" => '',
     "target" => '_self',
     "title" => '' // alias for "main" so you can feed in ACF link fields directly
   ],
   "style" => [
     "svg" => '', // used for modal button
     "class" => '',
     "id" => '',
     "attrs" => []
   ]
 ];

gsc_define("btn", $defaults, function ($data) {

  $button = $data["content"]["button"];
  $type = $data["content"]["type"];

  // class closing quote needs to be added after type modifications
  $class_attr = "btn ";
  if (!empty($data["style"]["class"])) {
    $class_attr .= " {$data["style"]["class"]} ";
  }

  $id_attr = "";
  if (!empty($data["style"]["id"])) {
    $id_attr = "id='{$data["style"]["id"]}'";
  }

  $misc_attrs = "";
  if (!empty($data["style"]["attrs"])) {
    foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
      $misc_attrs .= " $attr_name='$attr_value' ";
    }
  }

  if ($type == "modal") {
    $class_attr .= " btn--modal ";
  }

  if ($type == "secondary") {
    $class_attr .= " btn--secondary ";
  }

  if ($type == "toggle") {
    $active = $data["content"]["active"];
    $class_attr .= " btn--toggle " . $active;
  }

  if ($type == "icon") {
    $class_attr .= " btn--toggle btn--leading-icon ";
  }

  //wrap classes
  $class_attr = "class='{$class_attr}'";

  // add endquote to class def

  $text = $data["content"]["text"];

  if ($type == "icon") {
    $svg = $data["style"]["svg"];

    // only the first and last tags are dependent on button vs link status
    if ($button == true) {
      $icon_html = "";
      $icon_html .= "<button type='button' {$class_attr} {$id_attr} {$misc_attrs} >";
      $end_html = "</button>";
    } else {
      $icon_html = "";
      $icon_html .= "<a href='#'  {$class_attr} {$id_attr} {$misc_attrs} >";
      $end_html = "</a>";
    }
      $icon_html .= "<span class='btn__ico'>";
      $icon_html .= "{$svg}";
      $icon_html .= "</span>";
      $icon_html .= "<span class='btn__txt'>{$text}</span>";
      $icon_html .= "{$end_html}";

      return $icon_html;
  }

  // must return modal button first
  if ($type == "modal") {
    $svg = $data["style"]["svg"];
    $modal_html = "";

    if ($button == true) {
      $container = "<button type='button' {$class_attr} {$id_attr} {$misc_attrs} >";
      $close = "</button>";
    } else {
      $container = "<a href='{$data["content"]["url"]}' {$class_attr} {$id_attr} {$misc_attrs} >";
      $close = "</a>";
    }

    $modal_html .= $container;
    $modal_html .= "<span class='btn__txt'>{$text}</span>";
    $modal_html .= "<span class='btn__ico'>";
    $modal_html .= "{$svg}";
    $modal_html .= "</span>";
    $modal_html .= $close;

    return $modal_html;
  }

  if ($button == true) {
    $container = "<button type='button' {$id_attr} {$misc_attrs} {$class_attr}  >";
    $close = "</button>";
  } else {
    $container = "<a href='{$data["content"]["url"]}' {$id_attr} {$misc_attrs} {$class_attr} >";
    $close = "</a>";
  }

  return $container  . $text . $close;

});
gsc_meta("btn", [ATOM]);
gsc_test("btn", "primary", function() {
  echo gsc("btn", []);
});
gsc_test("btn", "primary (link)", function() {
  echo gsc("btn", [
    "content" => [
      "button" => false,
      "url" => "https://www.gravityswitch.com"
    ]
  ]);
});

gsc_test("btn", "primary (custom class and attr)", function() {
  echo gsc("btn", [
    "content" => [
      "button" => false,
      "url" => "https://wwww.gravityswitch.com"
    ],
    "style" => [
      "class" => "custom-class",
      "attrs" => [
        "custom-attr" => "attr"
      ]
    ]
  ]);
});

gsc_test("btn", "secondary", function() {
  echo gsc("btn", [
    "content" => [
        "type" => 'secondary',
        "text" => 'Secondary Button'
    ]
  ]);
});
gsc_test("btn", "secondary (link)", function() {
  echo gsc("btn", [
    "content" => [
        "button" => false,
        "type" => 'secondary',
        "text" => 'Secondary Button'
    ]
  ]);
});

gsc_test("btn", "secondary (custom class and attr)", function() {
  echo gsc("btn", [
    "content" => [
      "button" => false,
      "type" => 'secondary',
      "text" => 'Secondary Button'
    ],
    "style" => [
      "class" => "custom-class",
      "attrs" => [
        "custom-attr" => "attr"
      ]
    ]
  ]);
});

gsc_test("btn", "toggles", function() {
  echo gsc("btn", [
    "content" => [
      "type" => 'toggle',
      "text" => 'Toggle Button'
    ]
  ]);
});

gsc_test("btn", "toggles (custom class and attr)", function() {
  echo gsc("btn", [
    "content" => [
      "type" => 'toggle',
      "text" => 'Toggle Button'
    ],
    "style" => [
      "class" => 'custom-class',
      "attrs" => [
        "custom-attr" => 'attr'
      ]
    ]
  ]);
});
gsc_test("btn", "modal", function() {
  echo gsc("btn", [
    "content" => [
      "type" => 'modal',
      "text" => 'Modal Button'
    ]
  ]);
});
gsc_test("btn", "modal (link)", function() {
  echo gsc("btn", [
    "content" => [
      "button" => false,
      "type" => 'modal',
      "text" => 'Modal Link Button',
      "url" => "https://www.gravityswitch.com"
    ]
  ]);
});
gsc_test("btn", "modal (custom class and attr)", function() {
  echo gsc("btn", [
    "content" => [
      "button" => false,
      "type" => 'modal',
      "text" => 'Modal Link Button',
      "url" => "https://www.gravityswitch.com"
    ],
    "style" => [
      "class" => "custom-class",
      "attrs" => [
        "custom-attr" => "attr"
      ]
    ]
  ]);
});
gsc_test("btn", "icon", function() {
  echo gsc("btn", [
    "content" => [
      "type" => 'icon',
      "text" => 'Icon Leading Button'
    ],
      "style" => [
        "svg" => '<svg xmlns="http://www.w3.org/2000/svg" width="17.5" height="17.5" viewbox="0 0 17.5 17.5" aria-hidden="true">
          <title>List</title>
          <g transform="translate(-255.005 -4827)">
            <g transform="translate(255.755 4827.75)">
              <path class="ico__path" d="M263.255,4830.75h10.667" transform="translate(-257.922 -4828.617)" />
              <path class="ico__path" d="M263.255,4839.75h10.667" transform="translate(-257.922 -4831.217)" />
              <path class="ico__path" d="M263.255,4848.75h10.667" transform="translate(-257.922 -4833.817)" />
              <path
                class="ico__path"
                d="M255.755,4828.283a.534.534,0,0,1,.533-.533h2.133a.534.534,0,0,1,.533.533v2.134a.534.534,0,0,1-.533.533h-2.133a.534.534,0,0,1-.533-.533Z"
                transform="translate(-255.755 -4827.75)"
              />
              <path
                class="ico__path"
                d="M255.755,4837.283a.533.533,0,0,1,.533-.533h2.133a.533.533,0,0,1,.533.533v2.133a.534.534,0,0,1-.533.534h-2.133a.534.534,0,0,1-.533-.534Z"
                transform="translate(-255.755 -4830.35)"
              />
              <path
                class="ico__path"
                d="M255.755,4846.283a.534.534,0,0,1,.533-.533h2.133a.534.534,0,0,1,.533.533v2.134a.534.534,0,0,1-.533.533h-2.133a.534.534,0,0,1-.533-.533Z"
                transform="translate(-255.755 -4832.95)"
              />
            </g>
          </g>
        </svg>'
      ]
  ]);
});
gsc_test("btn", "icon (link)", function() {
  echo gsc("btn", [
    "content" => [
      "button" => false,
      "type" => 'icon',
      "text" => 'Icon Leading Button',
      "url" => "https://www.gravityswitch.com"
    ],
      "style" => [
        "svg" => '<svg xmlns="http://www.w3.org/2000/svg" width="17.5" height="17.5" viewbox="0 0 17.5 17.5" aria-hidden="true">
          <title>List</title>
          <g transform="translate(-255.005 -4827)">
            <g transform="translate(255.755 4827.75)">
              <path class="ico__path" d="M263.255,4830.75h10.667" transform="translate(-257.922 -4828.617)" />
              <path class="ico__path" d="M263.255,4839.75h10.667" transform="translate(-257.922 -4831.217)" />
              <path class="ico__path" d="M263.255,4848.75h10.667" transform="translate(-257.922 -4833.817)" />
              <path
                class="ico__path"
                d="M255.755,4828.283a.534.534,0,0,1,.533-.533h2.133a.534.534,0,0,1,.533.533v2.134a.534.534,0,0,1-.533.533h-2.133a.534.534,0,0,1-.533-.533Z"
                transform="translate(-255.755 -4827.75)"
              />
              <path
                class="ico__path"
                d="M255.755,4837.283a.533.533,0,0,1,.533-.533h2.133a.533.533,0,0,1,.533.533v2.133a.534.534,0,0,1-.533.534h-2.133a.534.534,0,0,1-.533-.534Z"
                transform="translate(-255.755 -4830.35)"
              />
              <path
                class="ico__path"
                d="M255.755,4846.283a.534.534,0,0,1,.533-.533h2.133a.534.534,0,0,1,.533.533v2.134a.534.534,0,0,1-.533.533h-2.133a.534.534,0,0,1-.533-.533Z"
                transform="translate(-255.755 -4832.95)"
              />
            </g>
          </g>
        </svg>'
      ]
  ]);
});
gsc_test("btn", "icon (custom class and attr)", function() {
  echo gsc("btn", [
    "content" => [
      "button" => false,
      "type" => 'icon',
      "text" => 'Icon Leading Button',
      "url" => "https://www.gravityswitch.com"
    ],
    "style" => [
      "svg" => '<svg xmlns="http://www.w3.org/2000/svg" width="17.5" height="17.5" viewbox="0 0 17.5 17.5" aria-hidden="true">
        <title>List</title>
        <g transform="translate(-255.005 -4827)">
          <g transform="translate(255.755 4827.75)">
            <path class="ico__path" d="M263.255,4830.75h10.667" transform="translate(-257.922 -4828.617)" />
            <path class="ico__path" d="M263.255,4839.75h10.667" transform="translate(-257.922 -4831.217)" />
            <path class="ico__path" d="M263.255,4848.75h10.667" transform="translate(-257.922 -4833.817)" />
            <path
              class="ico__path"
              d="M255.755,4828.283a.534.534,0,0,1,.533-.533h2.133a.534.534,0,0,1,.533.533v2.134a.534.534,0,0,1-.533.533h-2.133a.534.534,0,0,1-.533-.533Z"
              transform="translate(-255.755 -4827.75)"
            />
            <path
              class="ico__path"
              d="M255.755,4837.283a.533.533,0,0,1,.533-.533h2.133a.533.533,0,0,1,.533.533v2.133a.534.534,0,0,1-.533.534h-2.133a.534.534,0,0,1-.533-.534Z"
              transform="translate(-255.755 -4830.35)"
            />
            <path
              class="ico__path"
              d="M255.755,4846.283a.534.534,0,0,1,.533-.533h2.133a.534.534,0,0,1,.533.533v2.134a.534.534,0,0,1-.533.533h-2.133a.534.534,0,0,1-.533-.533Z"
              transform="translate(-255.755 -4832.95)"
            />
          </g>
        </g>
      </svg>',
      "class" => "custom-class",
      "attrs" => [
        "custom-attr" => "attr"
      ]
    ]
  ]);
});
