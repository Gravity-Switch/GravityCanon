<?php

$defaults =  [
  "content" => [
    "container" => 'h1',
    "title" => '',
    "image" => 'http://avtportal.wpengine.com/wp-content/themes/avt/images/temp/hero-img.jpg', // accepts image url
    "aria-label" => 'Hero image alt-text'
  ],
  "style" => [
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];


gsc_define ("banner", $defaults, function($data) {

  $title = $data["content"]["title"];
  $image = $data["content"]["image"];

  $class = $data["style"]["class"];
  $aria_label = $data["content"]["aria-label"];

  $id="";
  if (!empty($data["style"]["id"])) {
    $id = "id='{$data["style"]["id"]}'";
  }

  $misc_attrs = "";
  if (!empty($data["style"]["attrs"])) {
    foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
      $misc_attrs .= "$attr_name='$attr_value' ";
    }
  }

  $html = '';
  $html .= "<header class='hero hero--txt-img-bkg {$class}' {$id} {$misc_attrs}>";
  $html .= "<div class='hero__container'>";
  $html .= "<div class='hero__txt'>";
  $html .= gsc("title", [
    "content" => [
      "main" => $title
    ],
    "style" => [
      "container" => $data["content"]["container"],
      "class" => "hero__title"
    ]
  ]);
  $html .= "</div>";
  $html .= "<div class='hero__img' aria-label='{$aria_label}' style='background-image: url({$image})'></div>";
  $html .= "</div>";
  $html .= "</header>";

  return $html;
});
gsc_meta("banner", [MOLECULE]);
gsc_test("banner", "", function() {
  echo gsc("banner", [
    "content" => [
      "title" => 'See If a Job Fits'
    ]
  ]);

  $args = array(
    'post_type'      => 'attachment',
    'orderby'        => 'rand',
    'post_mime_type' => 'image',
    'post_status'    => 'inherit',
    'posts_per_page' => 20,
  );
  $images = new WP_Query( $args );

  $chosen_image = $images->posts[array_rand($images->posts)];

  echo gsc("banner", [
    "content" => [
      "title" => 'More testing. What about a really long title and random image? '.gsc_mock(),
      "image" => $chosen_image->guid,
    ]
  ]);
});


?>
