<?php

$defaults = [
  "content" => [
    "num_results" => 0,
    "singular_obj" => 'Result',
    "plural_obj" => 'Results'
  ],
  "style" => [
    "container" => 'p',
    "number_styling" => 'b',
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];

gsc_define("filter_result", $defaults, function ($data) {
  $container = $data["style"]["container"];
  $num_style = $data["style"]["number_styling"];

  $singular = $data["content"]["singular_obj"];
  $plural = $data["content"]["plural_obj"];

  $num = $data["content"]["num_results"];

  $id_attr = "";
  if (!empty($data["style"]["id"])) {
    $id_attr = "id='{$data["style"]["id"]}'";
  }

  $class_attr = "class= '";
  $class = $data["style"]["class"];
  if (!empty($class)) {
    $class_attr .= "{$class}";
  }
  $class_attr .= " results'";

  $misc_attrs = "";
  if (!empty($data["style"]["attrs"])) {
    foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
      $misc_attrs .= "$attr_name='$attr_value' ";
    }
  }

  if ($num > 1) {
    return "<$container $id_attr $class_attr $misc_attrs><$num_style>$num</$num_style> $plural</$container>";
  } elseif ($num == 1) {
    return "<$container $id_attr $class_attr $misc_attrs><$num_style>$num</$num_style> $singular</$container>";
  } else {
    return "<$container $id_attr $class_attr $misc_attrs><$num_style>No </$num_style> $plural</$container>";
  }
});
gsc_meta("filter_result", [ATOM]);
gsc_test("filter_result", "", function() {
  echo gsc("filter_result", [
    "content" => [
      "num_results" => 62,
    ]
  ]);
  echo gsc("filter_result", [
    "content" => [
      "num_results" => 0,
      "singular_obj" => 'employee',
      "plural_obj" => 'employees'
    ],
    "style" => [
      "number_styling" => 'i'
    ]
  ]);
  echo gsc("filter_result", [
    "content" => [
      "num_results" => 1,
      "singular_obj" => 'employee',
      "plural_obj" => 'employees'
    ]
  ]);
  echo gsc("filter_result", [
    "content" => [
      "num_results" => 1,
      "singular_obj" => "employee",
      "plural_obj" => "employees"
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
