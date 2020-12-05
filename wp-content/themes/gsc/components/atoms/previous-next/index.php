<?php

// Creates previous/next html, JQuery function in main.js

$defaults = [
  "content" => [
    "previous" => true, // true for previous, false for next
    "object" => '', // object for previous/next
    "text" => ''
  ],
  "style" => [
    "svg" => '',
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
