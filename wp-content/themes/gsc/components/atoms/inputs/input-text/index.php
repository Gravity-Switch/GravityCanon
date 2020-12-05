<?php
$defaults = [
  "content" => [
		"label" => "",
		"value" => "",
		"error" => false
	],
	"style" => [
    "disabled" => false,
    "required" => false,
		"id" => "",
		"class" => "",
		"name" => "",
		"attrs" => [],
    "input-class" => ""
	]
];
gsc_define("input-text", $defaults, function($data) {

	// if no name is specified, just use the id
	$name = $data['style']['name'];
	if (empty($name)) {
		$name = $data['style']['id'];
	}

	$disabled = $data['style']['disabled'] ? "disabled='disabled'" : "";
	$required = $data['style']['required'] ? "required='required' aria-required='true'" : "";

	$classes = "form__element element--text";
  if (!empty($data["style"]["class"])) {
    $classes .= " " . $data["style"]["class"];
	}
	if (!empty($data["content"]["error"])) {
    $classes .= " error";
	}

  $input_classes = "form__input input--text {$data["style"]["input-class"]} ";

  if ($data['style']['required']) {
    $classes .= " form__element--required";
  }
	$class_attr = "class='$classes'";

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

	$error_html = "";
	if (!empty($data["content"]["error"])) {
    $error_html .= "<p class='form__mssg'>{$data["content"]["error"]}</p>";
	}

	$input = "
	<div $class_attr $misc_attrs>
		<label class='form__label' for='{$data['style']['id']}'>{$data['content']['label']}</label>
		<input type='text' class='{$input_classes}' name='{$data['style']['name']}' id='{$data['style']['id']}' {$disabled} {$required} value='{$data['content']['value']}' />
		$error_html
	</div>";

	return $input;
});
gsc_meta("input-text", [ATOM]);
gsc_test("input-text", "", function() {
	echo gsc("input-text", []);

	echo gsc("input-text", [
		"content" => [
			"label" => "Second test label",
			"value" => "This is here when you load the page",
		],
		"style" => [
      "disabled" => true,
      "required" => true,
			"id" => "demo-input-id-asdf",
			"class" => "extra-test-class",
      "attrs" => [
        "custom-attr" => "attr"
      ]
		]
	]);

	echo gsc("input-text", [
		"content" => [
			"label" => "Third test label",
			"value" => "Some text",
			"error" => "Not entered correctly"
		],
    "style" => [
      "required" => true
    ]
	]);
});
