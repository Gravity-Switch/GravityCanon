<?php
$defaults = [
  "content" => [
		"label" => "",
		"value" => "",
		"disabled" => false,
		"required" => false,
		"error" => false
	],
	"style" => [
		"id" => "",
		"class" => "",
		"name" => "",
		"attrs" => []
	]
];
gsc_define("textarea", $defaults, function($data) {

	// if no name is specified, just use the id
	$name = $data['style']['name'];
	if (empty($name)) {
		$name = $data['style']['id'];
	}

	$disabled = $data['content']['disabled'] ? "disabled='disabled'" : "";
	$required = $data['content']['required'] ? "required='required' aria-required='true'" : "";

	$classes = "form__element";
  if (!empty($data["style"]["class"])) {
    $classes .= " " . $data["style"]["class"];
	}
	if (!empty($data["content"]["error"])) {
    $classes .= " error";
	}
  if ($data['content']['required']) {
    $classes .= " form__element--required";
  }
	$class_attr = "class='$classes'";

	$error_html = "";
	if (!empty($data["content"]["error"])) {
    $error_html .= "<p class='form__mssg'>{$data["content"]["error"]}</p>";
	}

  $misc_attrs = "";
  if (!empty($data["style"]["attrs"])) {
    foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
      $misc_attrs .= "$attr_name='$attr_value' ";
    }
  }

	$textarea = "
	<div $class_attr>
		<label class='form__label' for='{$data['style']['id']}'>{$data['content']['label']}</label>
		<textarea type='text' class='form__input input--textarea' name='{$name}' id='{$data['style']['id']}' {$disabled} {$required} $misc_attrs>{$data['content']['value']}</textarea>
		$error_html
	</div>";

	return $textarea;
});
gsc_meta("textarea", [ATOM]);
gsc_test("textarea", "", function() {
	echo gsc("textarea", []);

	echo gsc("textarea", [
		"content" => [
			"label" => "Second test label",
			"value" => "This is here when you load the page",
			"disabled" => true,
			"required" => true
		],
		"style" => [
			"id" => "demo-textarea-id-asdf",
			"class" => "extra-test-class"
		]
	]);

	echo gsc("textarea", [
		"content" => [
			"label" => "Third test label",
			"value" => "This is here when you load the page",
			"required" => true,
			"error" => "Textarea eror message here!"
		],
		"style" => [
			"id" => "demo-textarea-id-asdf",
			"class" => "extra-test-class",
      "attrs" => [
        "test-attrs" => "attr"
      ]
		]
	]);
});
