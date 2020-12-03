<?php
// If you legend text and a legend ID the entire content gets wrapped in a fieldset
//  and a legend is added to the markup. If you don't have legend text you can still
//  provide a legend id to refer to an element that isn't in this atom
$defaults = [
  "content" => [
		"legend_text" => false,
		"legend_id" => false,
		"options" => [],
		"error" => false
	],
	"style" => [
		"container" => "div",
		"item_container" => "div",
		"id" => "",
		"class" => "",
		"name" => ""
	]
];
gsc_define("radios", $defaults, function($data) {

	$classes = "";
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

	$radios = "";
	if (!empty($data['content']['options'])) {
    foreach ($data['content']['options'] as $radio) {
			echo gsc("radio", [
        "content" => [
          "value" => $radio["value"],
          "label" => $radio["label"],
        ],
        "style" => [
          "checked" => $radio["checked"],
          "disabled" => $radio["disabled"],
          "id" => $radio["id"]
        ]
      ]);
    }
	}

	$error_html = "";
	if (!empty($data["content"]["error"])) {
    $error_html .= "<p class='form__mssg'>{$data["content"]["error"]}</p>";
	}

	$ul = "<{$data['style']['container']} $class_attr role='group' aria-labelledby='{$data['content']['legend_id']}' role='group'>
					$radios
					$error_html
				</{$data['style']['container']}>";

	if ($data['content']['legend_id'] && $data['content']['legend_text']) {
		$content = "
			<fieldset>
				<legend id='{$data['content']['legend_id']}'>{$data['content']['legend_text']}</legend>
				$ul
			</fieldset>";
	}
	else {
		$content = $ul;
	}

	return $content;
});
gsc_meta("radios", [ATOM]);
gsc_test("radios", "", function() {
	echo gsc("radios", [
    "content" => [
			"legend_text" => "This is an optional label",
			"legend_id" => "example-legend-id-1",
			"options" => [
				[
					"value" => "the-value",
					"label" => "Option 1",
					"id" => "radio-1",
				],
				[
					"value" => "the-value",
					"label" => "Option 2",
					"id" => "radio-2",
				],
				[
					"value" => "the-value",
					"label" => "Option 3",
					"id" => "radio-3",
					"disabled" => true
				],
				[
					"value" => "the-value",
					"label" => "Option 4",
					"id" => "radio-4",
					"checked" => true
				],
				[
					"value" => "the-value",
					"label" => "Option 5",
					"id" => "radio-5",
				],
			]
		],
		"style" => [
			"class" => "potato-box",
			"name" => "group-of-radios-1"
		]
	]);

	echo gsc("radios", [
    "content" => [
			"options" => [
				[
					"value" => "the-value",
					"label" => "Option 10",
					"id" => "radio-10",
				],
				[
					"value" => "the-value",
					"label" => "Option 12",
					"id" => "radio-12",
				]
			],
			"error" => "You must choose at least one"
		],
		"style" => [
			"class" => "potato-box",
			"name" => "group-of-radios-2",
      "attrs" => [
        "custom-attr" => "attr"
      ]
		]
	]);
});
