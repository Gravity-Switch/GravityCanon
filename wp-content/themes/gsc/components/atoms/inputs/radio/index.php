<?php

$defaults = [
  "content" => [
    "value" => "the-value",
    "label" => "Option 1",
  ],
  "style" => [
    "checked" => "",
    "disabled" => "",
    "item_container" => "div",
    "id" => "radio-1",
    "class" => "",
    "name" => ""
  ]
];

gsc_define("radio", $defaults, function($data) {
  $radio_checked = (!empty($data["style"]['checked']) && $data["style"]['checked']) ? "checked='checked'" : "";
  $radio_disabled = (!empty($data["style"]["disabled"]) && $data["style"]["disabled"]) ? "disabled='disabled'" : "";
  $radio_disabled_class = (!empty($data["disabled"]) && $data["style"]["disabled"]) ? "form_element--disabled" : "";

  $radio = "";
  $radio .= "
  <{$data['style']['item_container']} class='form__element element--radio {$radio_disabled_class}'>
    <input class='form__input input--radio {$data["style"]["class"]}' type='radio' {$radio_disabled} {$radio_checked} id='{$data['style']['id']}' name='{$data['style']['name']}' value='{$data['value']}' />

    <label class='form__label label--radio' for='{$data["style"]["id"]}'>
      {$data['label']}
    </label>
    </{$data['style']['item_container']}>
  ";

  return $radio;
});

gsc_meta("radio", [ATOM]);
gsc_test("radio", "", function() {
  echo gsc("radio", [
    "content" => [
      "value" => 'the-value',
      "label" => 'Option 1',
    ],
    "style" => [
      "id" => 'radio-1'
    ]
  ]);
});
gsc_test("radio", "Custom Class", function() {
  echo gsc("radio", [
    "content" => [
      "value" => "the-value",
      "label" => "Option 1"
    ],
    "style" => [
      "id" => "radio-2",
      "class" => "custom-class"
    ]
  ]);
});
