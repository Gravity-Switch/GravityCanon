<?php

$defaults = [
  "content" => [
    "main" => '',
    "url" => '', // get a basic link in the heading if url is filled
    "target" => '_self'
  ],
  "style" => [
    "container" => 'span',
    "size" => 'md', // size of subtitle, sm or md
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];

gsc_define("subtitle", $defaults, function($data) {

  $container = $data["style"]["container"];
  $main_content = $data["content"]["main"];


  $id_attr = "";
  if (!empty($data["style"]["id"])) {
    $id_attr = "id= '{$data["style"]["id"]}'";
  }

  $class = $data["style"]["class"];

  $class_attr = "class= '";
  if (!empty($class)) {
    $class_attr .= $class;
  }

  $size_attr = $data["style"]["size"];
  $class_attr .= " title--sub-$size_attr '";


  if (!empty($data["content"]["url"])) {
    $main_content = "<a href='{$data["content"]["url"]}' target='{$data["content"]["target"]}'>$main_content</a>";
  }

  $misc_attrs = "";
  if (!empty($data["style"]["attrs"])) {
    foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
      $misc_attrs .= "$attr_name='$attr_value' ";
    }
  }

  return "<$container $id_attr $class_attr $misc_attrs>$main_content</$container>";
});
gsc_meta("subtitle", [ATOM]);
gsc_test("subtitle", "", function() {
  echo gsc("subtitle", [
    "content" => [
      "main" => "Actual Subtitle Content!"
    ]
  ]);
  echo gsc("subtitle", [
    "content" => [
      "main" => "Small Subtitle Content"
    ],
    "style" => [
      "size" => "sm"
    ]
  ]);
  echo gsc("subtitle", [
    "content" => [
      "main" => "Subtitle Content with Color"
    ],
    "style" => [
      "class" => "color-teal",
      "attrs" => [
        "custom-attr" => "attr"
      ]
    ]
  ]);
});

 ?>
