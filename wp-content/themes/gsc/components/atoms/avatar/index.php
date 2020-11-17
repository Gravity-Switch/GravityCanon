<?php
$defaults = [
  "content" => [
		"src" => get_template_directory_uri()."/images/temp/avatar@2x.jpg",
		"alt" => "Avatar",
		"url" => '', // get a basic link in the heading if url is filled
    "target" => '_self' // support for url
	],
	"style" => [
		"class" => ''
	]
];
gsc_define("avatar", $defaults, function($data) {
	$image = "<img src='{$data['content']['src']}' alt='{$data['content']['alt']}' />";

	$image_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($data['content']['src'])['path'];
	list($width, $height) = getimagesize($image_path);

	$class = "avatar {$data['style']['class']}";

	if ($width > $height) {
		$class .= " wide";
	}
	elseif ($height > $width) {
		$class .= " tall";
	}

	if (!empty($data["content"]["url"])) {
    $avatar = "<a class='{$class}' href='{$data["content"]["url"]}' target='{$data["content"]["target"]}'>$image</a>";
	}
	else {
		$avatar = "<span class='{$class}'>$image</span>";
	}

	return $avatar;
});
gsc_meta("avatar", [ATOM]);
gsc_test("avatar", "default image", function() {
  echo gsc("avatar", []);
});
gsc_test("avatar", "custom image with link", function() {
	echo gsc("avatar", [
    "content" => [
			"src" => get_template_directory_uri()."/images/temp/card-img@2x.jpg",
			"alt" => "Stupid horse",
			"url" => "http://example.com",
			"target" => "_blank"
    ]
	]);
});
gsc_test("avatar", "custom image, no link", function() {
	echo gsc("avatar", [
    "content" => [
			"src" => get_template_directory_uri()."/images/temp/img-grphc-ovrly.jpg",
			"alt" => "Some guy at desk"
    ]
	]);
});
