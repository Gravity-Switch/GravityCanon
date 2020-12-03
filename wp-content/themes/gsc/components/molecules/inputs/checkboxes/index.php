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
    "required" => false,
		"container" => "div",
		"item_container" => "div",
		"id" => "",
		"class" => ""
	]
];
gsc_define("checkboxes", $defaults, function($data) {

	$classes = "";
  if (!empty($data["style"]["class"])) {
    $classes .= " " . $data["style"]["class"];
	}
	if (!empty($data["content"]["error"])) {
    $classes .= " error";
	}
  if (!empty($data['style']['required'])) {
    $classes .= " form__element--required";
  }
	$class_attr = "class='$classes'";
  $misc_attrs = "";
  if (!empty($data["style"]["attrs"])) {
    foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
      $misc_attrs .= " $attr_name='$attr_value' ";
    }
  }

	$checkboxes = "";
	if (!empty($data['content']['options'])) {
    foreach ($data['content']['options'] as $checkbox) {
			$checkboxes .= gsc("checkbox", [
        "content" => [
          "value" => $checkbox["value"],
          "label" => $checkbox["label"],
        ],
        "style" => [
          "id" => $checkbox["id"],
          "name" => $checkbox["name"],
          "checked" => $checkbox["checked"],
  				"disabled" => $checkbox["disabled"],
          "container" => $data["style"]["item_container"]
        ]
      ]);
    }
	}

	$error_html = "";
	if (!empty($data["content"]["error"])) {
    $error_html .= "<p class='form__mssg'>{$data["content"]["error"]}</p>";
	}

	$ul = "<{$data['style']['container']} $class_attr $misc_attrs role='group' aria-labelledby='{$data['content']['legend_id']}' role='group'>
					$checkboxes
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
gsc_meta("checkboxes", [MOLECULE]);
gsc_test("checkboxes", "", function() {
	echo gsc("checkboxes", [
    "content" => [
			"legend_text" => "This is an optional label",
			"legend_id" => "example-legend-id-1",
			"options" => [
				[
					"value" => "the-value",
					"label" => "Option 1",
					"id" => "checkbox-1",
					"name" => "somecheckbox"
				],
				[
					"value" => "the-value",
					"label" => "Option 2",
					"id" => "checkbox-2",
					"name" => "somecheckbox"
				],
				[
					"value" => "the-value",
					"label" => "Option 3",
					"id" => "checkbox-3",
					"name" => "somecheckbox",
					"disabled" => true
				],
				[
					"value" => "the-value",
					"label" => "Option 4",
					"id" => "checkbox-4",
					"name" => "somecheckbox",
					"checked" => true
				],
				[
					"value" => "the-value",
					"label" => "Option 5",
					"id" => "checkbox-5",
					"name" => "somecheckbox"
				],
			]
		],
		"style" => [
			"class" => "potato-box",
		]
	]);

	echo gsc("checkboxes", [
    "content" => [
			"options" => [
				[
					"value" => "the-value",
					"label" => "Option 1",
					"id" => "checkbox-1",
					"name" => "somecheckbox"
				],
				[
					"value" => "the-value",
					"label" => "Option 2",
					"id" => "checkbox-2",
					"name" => "somecheckbox"
				]
			],
			"error" => "You must choose at least one"
		],
		"style" => [
			"class" => "potato-box",
			"container" => "ul",
			"item_container" => "li",
      "attrs" => [
        "custom-attr" => "attr"
      ]
		]
	]);
});
