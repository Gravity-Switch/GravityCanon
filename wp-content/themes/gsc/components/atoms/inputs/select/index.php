<?php
$defaults = [
  "content" => [
		"label" => "State",
		"options" => [],
		"error"
	],
	"style" => [
    "disabled" => false,
    "required" => false,
    "multiple" => false,
		"id" => "select-box-1",
		"class" => "",
		"name" => "state"
	]
];
gsc_define("select", $defaults, function($data) {

	$disabled = $data['style']['disabled'] ? "disabled='disabled'" : "";
	$required = $data['style']['required'] ? "required='required' aria-required='true'" : "";

	$disabled_attr = $data['style']['disabled'] ? "disabled='disabled'" : "";
	$required_attr = $data['style']['required'] ? "required='required'" : "";
  $multiple_attr =  $data['style']['multiple'] ? "required='multiple'" : "";

	$classes = "form__element element--selectbox";
  if (!empty($data["style"]["class"])) {
    $classes .= " " . $data["style"]["class"];
	}
	if (!empty($data["content"]["error"])) {
    $classes .= " error";
	}
	if ($data['content']['disabled']) {
		$classes .= " form__element--disabled";
	}
	if ($data['content']['required']) {
    $classes .= " form__element--required";
	}
	$class_attr = "class='$classes'";

	$options = "";
	if (!empty($data['content']['options'])) {
    foreach ($data['content']['options'] as $option) {
			$option_selected = $option['selected'] ? "selected='selected'" : "";
			$option_disabled = $option['disabled'] ? "disabled='disabled'" : "";
      $options .= "<option value='{$option["value"]}' {$option_selected} {$option_disabled}>{$option["text"]}</option>";
    }
	}

	$error_html = "";
	if (!empty($data["content"]["error"])) {
    $error_html .= "<p class='form__mssg'>{$data["content"]["error"]}</p>";
	}

	$select = "
	<div $class_attr>
		<label class='form__label label--selectbox' for='{$data['style']['id']}'>{$data['content']['label']}</label>
		<select name='{$data['style']['name']}' class='form__input input--selectbox' id='{$data['style']['id']}' $disabled_attr $required_attr>
			$options
		</select>
		$error_html
	</div>";

	return $select;
});
gsc_meta("select", [ATOM]);
gsc_test("select", "", function() {
	echo gsc("select", [
		"content" => [
			"options" => [
				[
					"value" => "",
					"text" => "- Select -",
					"selected" => false,
					"disabled" => false
				],
				[
					"value" => "value1",
					"text" => "Option 1",
					"selected" => false,
					"disabled" => false
				],
				[
					"value" => "value2",
					"text" => "Option 2",
					"selected" => true,
					"disabled" => false
				],
				[
					"value" => "value2",
					"text" => "Option 3",
					"selected" => false,
					"disabled" => true
				]
			]
		]
	]);

	echo gsc("select", [
		"content" => [
			"options" => [
				[
					"value" => "",
					"text" => "- Select -",
					"selected" => false,
					"disabled" => false
				],
				[
					"value" => "value1",
					"text" => "Option 1",
					"selected" => false,
					"disabled" => false
				],
				[
					"value" => "value2",
					"text" => "Option 2",
					"selected" => true,
					"disabled" => false
				],
				[
					"value" => "value2",
					"text" => "Option 3",
					"selected" => false,
					"disabled" => true
				]
			]
		],
    "style" => [
      "disabled" => true,
    ]
	]);

	echo gsc("select", [
		"content" => [
			"error" => "You must chooese an option",
			"options" => [
				[
					"value" => "",
					"text" => "- Select -",
					"selected" => false,
					"disabled" => false
				],
				[
					"value" => "value1",
					"text" => "Option 1",
					"selected" => false,
					"disabled" => false
				],
				[
					"value" => "value2",
					"text" => "Option 2",
					"selected" => true,
					"disabled" => false
				],
				[
					"value" => "value2",
					"text" => "Option 3",
					"selected" => false,
					"disabled" => true
				]
			]
		],
    "style" => [
      "required" => true,
      "class" => "custom-class"
    ]
	]);
});
