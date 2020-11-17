<?php
$defaults = [
  "content" => [
		"title" => "",
    "main" => "",
		"stat_1_heading" => "Average Wage",
		"stat_1_info" => "",
		"stat_2_heading" => "Current Openings",
		"stat_2_info" => "",
		"stat_3_heading" => "Interests",
		"stat_3_info" => "",
		"openings" => "",
		"interests" => "",
		"link_text" => "Learn More About This Job",
		"url" => "",
		"img_src" => "",
		"img_alt" => "",
	],
  "style" => [
    "class" => '',
    "id" => '',
    "attrs" => [],
	],
];
gsc_define("card-list", $defaults, function($data) {

	// Setting up useful variables including shorthand variables and SVG images
	$title = $data["content"]["title"];
	$stat_1_heading = $data["content"]["stat_1_heading"];
	$stat_1_info = $data["content"]["stat_1_info"];
	$stat_2_heading = $data["content"]["stat_2_heading"];
	$stat_2_info = $data["content"]["stat_2_info"];
	$stat_3_heading = $data["content"]["stat_3_heading"];
	$stat_3_info = $data["content"]["stat_3_info"];
	$link_text = $data["content"]["link_text"];
	$url = $data["content"]["url"];
  $main = $data["content"]["main"];
	$img_src = $data["content"]["img_src"];
	$img_alt = $data["content"]["img_alt"];
	$class = 'card card--with-data card--list ' . $data["style"]["class"];

	$img =  gsc("img", [
								"content" => [
									"src" => $img_src,
									"alt" => $img_alt,
								],
								"style" => [
									"class" => "card__img",
								],
							]);


	// Standard style attribute stuff
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

	$content = "
		<article $misc_attrs $id_attr class='$class'>
			<aside class='card__aside'>
				<figure class='card__figure figure--graphic-ovrly'>
					$img
				</figure>
			</aside>
			<div class='card__main'>
				<header class='card__header'>
					<h2 class='card__title'>$title</h2>
				</header>
				<div class='card__body'>";
          if (!empty($main)) {
            $content .= $main;
          }
          else {
            $content .= "
    					<div class='tabs'><div class='tabs__section'>
  							<div class='tabs__body'>
  								<div class='stat stat--datapoint stat--wage'>
  									<h3 class='stat__heading'>$stat_1_heading</h3>
  									<p class='stat__info'>
  										<strong class='stat__num'>$stat_1_info</strong>
  										<span class='stat__label'>Average wage</span>
  									</p>
  								</div>
  								<div class='stat stat--datapoint stat--jobs'>
  									<h3 class='stat__heading'>$stat_2_heading</h3>
  									<p class='stat__info'>
  										<strong class='stat__num'>$stat_2_info</strong>
  										<span class='stat__label'>Current openings</span>
  									</p>
  								</div>
  							</div>
  						</div>
  						<div class='tabs__section'>
  							<div class='tabs__body'>
  								<div class='stat stat--ico-txt'>
  									<h3 class='stat__heading'>$stat_3_heading</h3>
  									<p class='stat__info'>
  										<span class='stat__txt'>$stat_3_info</span>
  									</p>
  								</div>
  							</div>
  						</div></div>";
          }

				$content .= "</div>

				<footer class='card__footer'>
					<div class='card__actions'>
						<a href='$url' class='link__content'>$link_text</a>
					</div>
				</footer>
			</div>
		</article>";

	return $content;
});
gsc_meta("card-list", [MOLECULE]);
gsc_test("card-list", "", function() {

	echo gsc("card-list", [
		"content" => [
			"title" => "Highway Maintenance Workers",
			"stat_1_info" => "$18.13",
			"stat_2_info" => 130,
			"stat_3_info" => "Working with your hands or with machines, organized and detail-oriented",
			"url" => "http://example.com",
			"img_src" => get_template_directory_uri()."/images/temp/card-img@2x.jpg",
			"img_alt" => "this is example img alt text!",
		],
	]);

	echo gsc("card-list", [
		"content" => [
			"title" => "Frontend Developer",
			"stat_1_heading" => "Text Editor",
			"stat_1_info" => "Whichever",
			"stat_2_info" => "None",
			"stat_3_heading" => "Job Description",
			"stat_3_info" => "HTML, CSS, JavaScript, PHP, WordPress and just general webby stuff",
			"link_text" => "Liv’s Site for No Reason",
			"url" => "http://oliviaartz.com",
			"img_src" => get_template_directory_uri()."/images/temp/card-img@2x.jpg",
			"img_alt" => "this is example img alt text!",
		],
	]);

});
