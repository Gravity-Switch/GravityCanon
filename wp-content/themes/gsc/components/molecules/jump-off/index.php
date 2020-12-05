<?php

$defaults = [
  "content" => [
    "title-container" => 'h2',
    "title" => '',
    "link-text" => 'Contact Us',
    "url" => '#',
    "link-button" => TRUE // changes button styling as link or button
  ],
  "style" => [
    "svg" => '',
    "class" => 'card--orange',
    "id" => '',
    "attrs" => []
  ]
];

gsc_define("jump-off", $defaults, function($data) {
  $id_attr = "";
  if (!empty($data["style"]["id"])) {
    $id_attr = "id='{$data["style"]["id"]}'";
  }

  $class_attr = "class='card card--alt card--jumpoff ";
  $class = $data["style"]["class"];
  if (!empty($class)) {
    $class_attr .= "{$class}";
  }
  $class_attr .= "'";

  $misc_attrs = "";
  if (!empty($data["style"]["attrs"])){
      foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
        $misc_attrs .= "$attr_name='$attr_value' ";
      }
  }

  $title_container = $data["content"]["title-container"];
  $title = $data["content"]["title"];

  $html = '';
  $html .= "<div {$class_attr} {$id_attr} {$misc_attrs}>";
  $html .= "<div class='card__main'>";

  $icon = $data["style"]["svg"];

  $html .= "{$icon}";

  $html .= "<div class='card__header'>";
  $html .= "<{$title_container} class='card__title'> {$title} </{$title_container}>";
  $html .= "</div>";

  $link = $data["content"]["link-text"];
  $url = $data["content"]["url"];

  $button = $data["content"]["link-button"];

  $action = '';
  if ($button == TRUE) {
    $action .= "<a href='{$url}' class='btn'>{$link}</a>";
  } else {
    $action .= "<a href='{$url}' class='link__content'>{$link}</a>";
  }

  $html .= "<div class='card__actions'>";
  $html .= "{$action}";

  $html .= "</div>";

  $html .= "</div>";
  $html .= "</div>";

  return $html;
});
gsc_meta("jump-off", [MOLECULE]);
gsc_test("jump-off", "default jumpoff", function() {
  echo gsc("jump-off", []);
});
gsc_test("jump-off", "teal jumpoff", function() {
  echo gsc("jump-off", [
    "style" => [
      "class" => 'card--teal'
    ]
  ]);
});
gsc_test("jump-off", "darker teal jumpoff", function() {
  echo gsc("jump-off", [
    "style" => [
      "class" => 'card--teal-darker',
      "attrs" => [
        "custom-attr" => "attr"
      ]
    ]
  ]);
});
