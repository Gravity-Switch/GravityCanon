<?php

$defaults = [
  "content" => [
    "title-container" => 'h2',
    "title" => 'The 62 Fastest Growing Careers in VT Right Now',
    "link-text" => 'Contact Us',
    "url" => '#',
    "link-button" => TRUE // changes button styling as link or button
  ],
  "style" => [
    "svg" => '<svg xmlns="http://www.w3.org/2000/svg" width="49.5" height="49.5" viewBox="0 0 49.5 49.5" aria-hidden="true" class="card__ico">
            <title>Explore job</title>
            <g transform="translate(-635 -455.01)">
              <g transform="translate(635.75 455.76)">
                <path class="ico__path" d="M652.284,467.828a4.534,4.534,0,1,0-4.534-4.534A4.533,4.533,0,0,0,652.284,467.828Z" transform="translate(-621.795 -452.715)"></path>
                <path class="ico__path" d="M650,464.01a7.557,7.557,0,0,1,7.556,7.556" transform="translate(-619.263 -446.215)"></path>
                <path class="ico__path" d="M637.25,463.316v-4.534a3.123,3.123,0,0,1,3.213-3.023h38.552a3.123,3.123,0,0,1,3.213,3.023v24.18a3.123,3.123,0,0,1-3.213,3.022H662.951" transform="translate(-634.227 -455.76)"></path>
                <path class="ico__path" d="M652.25,470.76v6.045" transform="translate(-617.05 -438.487)"></path>
                <path class="ico__path" d="M650.75,473.76h7.556" transform="translate(-618.395 -434.828)"></path>
                <path class="ico__path" d="M635.75,485.111a13.6,13.6,0,0,1,27.2,0" transform="translate(-635.75 -437.111)"></path>
                <path class="ico__path" d="M646.687,478.384a8.312,8.312,0,1,0-8.312-8.312A8.312,8.312,0,0,0,646.687,478.384Z" transform="translate(-633.086 -448.549)"></path>
              </g>
            </g>
          </svg>',
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
      foreach ($data["style"]["attrs"] as $attr->name=>$attr_value) {
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
      "class" => 'card--teal-darker'
    ]
  ]);
});
