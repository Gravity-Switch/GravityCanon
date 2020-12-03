<?php
$defaults = [
  "content" => [
		"list_items" => []
	],
  "style" => [
		"ordered" => false,
		"dividers" => false,
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];

gsc_define("list", $defaults, function($data) {

	$list_class = "list " . $data["style"]["class"];
	$item_class = "list__item";

	if ($data["style"]["dividers"]) {
		$list_class = "list--dividers " . $list_class;
		$item_class = "list__item--dividers " . $item_class;
	}

	$items = $data["content"]["list_items"];

	$items_str = "";
	if (!empty($items)) {
    foreach ($items as $item) {
      $items_str .= "<li class='{$item_class}'>$item</li>";
    }
	}

	$list_type = $data["style"]["ordered"] ? "ol" : "ul";

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

  return "<$list_type $id_attr class='{$list_class}' $misc_attrs>$items_str</$list_type>";
});
gsc_meta("list", [ATOM]);
gsc_test("list", "", function() {

	echo gsc("list", [
    "content" => [
			"list_items" => [
				"Active Listening",
				"Giving full attention to what other people are saying",
				"Taking time to understand the points being made",
				"Asking questions as appropriate",
				"Not interrupting at inappropriate times."
			]
		]
	]);

	echo gsc("list", [
    "content" => [
			"list_items" => [
				"By using this Website, you agree to the Terms of Use.",
				"Vermont Student Assistance Corporation (“VSAC”) maintains this website on the Internet",
				"They govern the use of our website and form alegally binding agreement between you and VSAC"
			]
		],
		"style" => [
			"ordered" => true
		]
	]);

	echo gsc("list", [
    "content" => [
			"list_items" => [
				"Islands & Farms",
				"Stowe-Smugglers Notch",
				"Northeast Kingdom",
				"Burlington Region",
				"Waterbury-Montpelier Region",
				"Middlebury-Vergennes Region",
				"Rutland-Killington Region",
				"Woodstock-Quechee Region"
			]
		],
		"style" => [
			"dividers" => true,
      "class" => "custom-class",
      "attrs" => [
        "custom-attr" => "attr"
      ]
		]
	]);

});
