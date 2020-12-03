<?php

// Creates previous/next html, JQuery function in main.js

$defaults = [
  "content" => [
    "previous" => true, // true for previous, false for next
    "object" => 'Career', // object for previous/next
    "text" => 'Previous Career You Looked At'
  ],
  "style" => [
    "svg" => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="48" viewBox="0 0 32 48">
				  <g transform="translate(-20.833 -6.25)">
					    <path id="Path_258fdsa895" data-name="Path 2585" d="M46.547,19.393H43.119V15.964h3.429Zm0,9.143H43.119V25.107h3.429Zm0,9.143H43.119V34.25h3.429Zm0,9.142H43.119V43.393h3.429Zm-8-27.429H35.119V15.964h3.429Zm0,9.143H35.119V25.107h3.429Zm0,9.143H35.119V34.25h3.429Zm0,12.571H35.119V43.393h3.429Zm-8-30.857H27.119V15.964h3.429Zm0,9.143H27.119V25.107h3.429Zm0,9.143H27.119V34.25h3.429Zm0,9.142H27.119V43.393h3.429Zm20,3.429V11.964H48.833V8.536H47.119V6.25H26.547V8.536H24.833v3.429H23.119V50.25H20.833v4h32v-4Z" fill="currentColor"/>
					  </g>
					</svg>',
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];

gsc_define("previous-next", $defaults, function($data) {

  $id_attr = "";
  if (!empty($data["style"]["id"])) {
    $id_attr = "id='{$data["style"]["id"]}'";
  }

  $misc_attrs = "";
  if (!empty($data["style"]["attrs"])) {
    foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
      $misc_attrs .= "$attr_name='$attr_value' ";
    }
  }

  // JQuery script will check for presence of the object within the a class
  $html = "<a href='#' class='{$data["content"]["object"]} banner__link banner__link--prev {$data["style"]["class"]}' {$misc_attrs}>";
  $html .= "<span class='banner__icon'>";
  $html .= "{$data["style"]["svg"]}";
  $html .= "</span>";
  $html .= "<span class='banner__label'> Return </span>";
  $html .= $data["content"]["text"];
  $html .= "</a>";

  return $html;
});
gsc_meta("previous-next", [ATOM]);
gsc_test("previous-next", "", function() {
  echo gsc("previous-next", [

  ]);
});

gsc_test("previous-next", "Custom class and attrs", function() {
  echo gsc("previous-next", [
      "style" => [
        "class" => "custom-class",
        "attrs" => [
          "custom-attr" => "attr"
        ]
      ]
  ]);
});
 ?>
