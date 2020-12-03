<?php
$defaults = [
  "content" => [
		"avatar_src" => "",
		"avatar_alt" => "",
		"person_name" => "",
		"person_title" => "",
		"story_title" => "",
		"story_text" => ""
	],
	"style" => [
		"class" => '',
    "id" => '',
    "attrs" => []
	]
];
gsc_define("story-card", $defaults, function($data) {

	$avatar = gsc("avatar", [
		"content" => [
			"src" => $data["content"]["avatar_src"],
			"alt" => $data["content"]["avatar_alt"]
		],
		"style" => [ "class" => "card__avatar" ]
	]);

	$subtitle = gsc("subtitle", [
		"content" => [
			"main" => $data["content"]["person_name"] . " | " . $data["content"]["person_title"]
		],
		"style" => [ "class" => "card__subtitle" ]
	]);

	$title = gsc("title", [
    "content" => [
			"main" => $data["content"]["story_title"]
		],
		"style" => [ "class" => "card__title", "container" => "h2" ]
	]);

	$text = $data["content"]["story_text"];

  $id_attr = "";
  if (!empty($data["style"]["id"])) {
    $id_attr = "id='{$data["style"]["id"]}'";
  }

  $class = $data["style"]["class"];

  $misc_attrs = "";
  if (!empty($data["style"]["attrs"])) {
    foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
      $misc_attrs .= "$attr_name='$attr_value' ";
    }
	}

	return "<article $id_attr $misc_attrs class='card card--alt card--story $class'>
						<div class='card__main'>
							<header class='card__header'>
								$avatar
								$subtitle
								$title
							</header>
							<div class='card__body'>
								$text
							</div>
						</div>
					</article>";
});
gsc_meta("story-card", [MOLECULE]);
gsc_test("story-card", "", function() {
  echo gsc("story-card", [
		"content" => [
			"avatar_src" => get_template_directory_uri()."/images/temp/avatar@2x.jpg",
			"avatar_alt" => "Avatar",
			"person_name" => "Olivia Artz",
			"person_title" => "Frontend Developer",
			"story_title" => "Olivia's Career Story",
			"story_text" => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Justo nec ultrices dui sapien eget mi proin sed libero. Elementum nibh tellus molestie nunc non blandit. Vestibulum lectus mauris ultrices eros in. Pulvinar neque laoreet suspendisse interdum consectetur libero id faucibus. Et netus et malesuada fames ac turpis egestas sed tempus.</p><p>Augue mauris augue neque gravida in. Non quam lacus suspendisse faucibus interdum posuere. Est lorem ipsum dolor sit. Non odio euismod lacinia at quis risus sed vulputate odio. Dictum sit amet justo donec enim diam vulputate. Eget velit aliquet sagittis id consectetur purus ut. Sed id semper risus in hendrerit gravida rutrum quisque.</p>"
		],
    "style" => [
      "class" => "custom-class",
      "attrs" => [
        "custom-attr" => "attr"
      ]
    ]
	]);
});
