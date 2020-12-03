<?php
// If you legend text and a legend ID the entire content gets wrapped in a fieldset
//  and a legend is added to the markup. If you don't have legend text you can still
//  provide a legend id to refer to an element that isn't in this atom
$defaults = [
  "content" => [
		"value" => "",
    "label" => ""
	],
	"style" => [
    "name" => "",
		"container" => "div",
		"id" => "",
		"class" => "",
    "checked" => false,
    "disabled" => false,
    "attrs" => []
	]
];
gsc_define("checkbox", $defaults, function($data) {
  $checkbox_checked = (!empty($data["style"]['checked']) && $data["style"]['checked']) ? "checked='checked'" : "";
  $checkbox_disabled = (!empty($data["style"]['disabled']) && $data["style"]['disabled']) ? "disabled='disabled'" : "";
  $checkbox_disabled_class = (!empty($data["style"]['disabled']) && $data["style"]['disabled']) ? "form__element--disabled" : "";
  $checkbox_id = isset($data["style"]['id']) ? $data["style"]['id'] : "";
  $checkbox_name = isset($data["style"]['name']) ? $data["style"]['name'] : "";
  $checkbox_value = isset($data["content"]['value']) ? $data["content"]['value'] : "";
  $checkbox_text = isset($data["content"]['text']) ? $data["content"]['label'] : "";
  $checkbox_class = isset($data["style"]['class']) ? $data["style"]['class'] : "";
  $checkbox_misc_attrs = "";
  if (!empty($data["style"]["attrs"])) {
    foreach ($data["style"]["attrs"] as $checkbox_attr_name=>$checkbox_attr_value) {
      $checkbox_misc_attrs .= " $checkbox_attr_name='$checkbox_attr_value' ";
    }
  }
  $content = "
    <{$data['style']['container']} class='form__element element--checkbox {$checkbox_disabled_class} '  >
      <input class='form__input input--checkbox {$checkbox_class}' type='checkbox' {$checkbox_disabled} {$checkbox_checked} {$checkbox_misc_attrs} id='$checkbox_id' name='$checkbox_name' value='$checkbox_value' />
      <label class='form__label label--checkbox' for='$checkbox_id'>
        $checkbox_text
        <svg xmlns='http://www.w3.org/2000/svg' width='24.595' height='24.297' viewbox='0 0 24.595 24.297' aria-hidden='true' focusable='false' class='form__ico ico ico--checkmark'>
          <title>Checkmark</title>
          <g transform='translate(-206.705 -4334.706)'><path class='ico__path' d='M230.255,4335.75l-15.092,21.559a2.2,2.2,0,0,1-3.569.059l-3.839-5.118' /></g>
        </svg>
      </label>
    </{$data['style']['container']}>";

	return $content;
});
gsc_meta("checkbox", [ATOM]);
gsc_test("checkbox", "basic checkbox", function() {
  echo gsc("checkbox", [
    "content" => [
  		"value" => "test",
      "label" => "test"
  	],
  ]);
});
gsc_test("checkbox", "basic checkbox (custom class and attrs)", function() {
  echo gsc("checkbox", [
    "content" => [
      "value" => "test",
      "label" => "test"
    ],
    "style" => [
      "class" => "custom-class",
      "attrs" => [
        "custom-attr" => "attr"
      ]
    ]
  ]);
});
