<?php
$defaults = [
  "content" => [
		"src" => get_template_directory_uri()."/images/temp/img-stndrd@2x.jpg",
		"alt" => ""
	],
  "style" => [
    "type" => false, // if set, to "background-pattern", "graphic-overlay" or "thumbnail"
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];

gsc_define("img", $defaults, function($data) {

	$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="160.781" height="65.232" viewbox="0 0 160.781 65.232" class="figure__graphic" aria-hidden="true">
		<title>Blocks stacked</title>
		<g transform="translate(-710.036 -617.405)">
			<path d="M801.461,617.4h0l-91.425,18.882v46.35H861.15V629.387Z" fill="#ffd961" />
			<path d="M710.036,636.287v46.35h91.426V617.4Z" fill="#ffc40b" />
			<path d="M710.036,644.233v38.4H788.86V628.406Z" fill="#e9e7e3" />
			<path d="M861.15,682.637V629.387L801.461,617.4v65.232Z" fill="#ffd961" />
			<path d="M848.537,682.637V640.389L788.86,628.406v54.231Z" fill="#fff" />
			<path d="M710.036,662.892v19.745h98.646V643.089Z" fill="#eb7023" />
			<path d="M870.817,682.637V655.559l-62.134-12.474v39.552Z" fill="#f6954b" />
		</g>
	</svg>';

	$type = $data["style"]["type"];
	$class = $data["style"]["class"];
	$img_class = $class; // by default any class will be put onto the image

	if ($type == "thumbnail") {
		$img_class = "thmbnl ".$class;
	}

	if ($type == "background-pattern" || $type == "graphic-overlay") {
		$img_class = "figure__img";
	}

	if ($type == "background-pattern") {
		$class = "figure figure--pttrn-bkg " . $class;
	}

	if ($type == "graphic-overlay") {
		$class = "figure figure--graphic-ovrly " . $class;
	}

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

	$image_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($data['content']['src'])['path'];
	list($width, $height) = getimagesize($image_path);

	if (empty($type) || $type == "thumbnail") {
		$content = "<img $id_attr $misc_attrs src='{$data['content']['src']}' alt='{$data['content']['alt']}' class='{$img_class}' width='{$width}' height='{$height}' />";
	}
	else {
		$content = "<img src='{$data['content']['src']}' alt='{$data['content']['alt']}' class='{$img_class}' />";

		if ($type == "background-pattern") {
			$content = "<figure $id_attr $misc_attrs class='{$class}'>" . $content . "</figure>";
		}

		if ($type == "graphic-overlay") {
			$content = "<figure $id_attr $misc_attrs class='{$class}'>" . $content . $svg . "</figure>";
		}

	}

	return $content;
});



gsc_meta("img", [ATOM]);
gsc_test("img", "", function() {
  echo gsc("img", []);

	echo gsc("img", [
    "content" => [
			"src" => get_template_directory_uri()."/images/temp/card-img.jpg",
			"alt" => "Stupid horse"
		],
		"style" => [
			"type" => "thumbnail"
		]
	]);

	echo gsc("img", [
    "content" => [
			"src" => get_template_directory_uri()."/images/temp/img-grphc-ovrly.jpg"
		],
		"style" => [
			"type" => "graphic-overlay",
			"class" => "test-class-here",
			"id" => "unique-id-example"
		]
	]);

	echo gsc("img", [
    "content" => [
			"alt" => "Stupid horse"
		],
		"style" => [
			"type" => "background-pattern",
			"attrs" => [
				"aria-hidden" => "true"
			]
		]
	]);
});
