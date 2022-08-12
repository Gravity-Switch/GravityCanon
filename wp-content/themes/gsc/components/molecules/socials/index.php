<?php
$defaults = [
  "content" => [
		"facebook" => false,
    "twitter" => false,
    "instagram" => false,
    "linkedin" => false,
    "youtube" => false,
    "rss" => false
	],
  "style" => [
    "type" => "socials",
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];

gsc_define("socials", $defaults, function($data) {

  $id_attr = "";
  if (!empty($data["style"]["id"])) {
    $id_attr = "id='{$data["style"]["id"]}'";
  }
  $class = "socials " . $data["style"]["class"];

  $misc_attrs = "";
  if (!empty($data["style"]["attrs"])) {
    foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
      $misc_attrs .= "$attr_name='$attr_value' ";
    }
  }

  if ($data["style"]["type"] == "share") {
    $output = '<script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>';
    $output .= "<ul class='{$class}' {$id_attr} {$misc_attrs}>";
    $output .= "<li class='socials__social socials__social--facebook'><a target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=" . urlencode(get_permalink()) . "'><span class='screen-reader-text'>Share to Facebook</span></a></li>";
    $output .= "<li class='socials__social socials__social--twitter'><a target='_blank'  href='https://twitter.com/intent/tweet?url=" . urlencode(get_permalink()) . "'><span class='screen-reader-text'>Share to Twitter</span></a></li>";
    $output .= "<li class='socials__social socials__social--linkedin'><a target='_blank'  href='https://www.linkedin.com/sharing/share-offsite/?url=" . urlencode(get_permalink()) . "'><span class='screen-reader-text'>Share to LinkedIn</span></a></li>";
    $output .= "<li class='socials__social socials__social--email'><a target='_blank'  href='mailto:?subject=I wanted you to see this site&amp;body=Check out this site " . urlencode(get_permalink()) . "'><span class='screen-reader-text'>Share this post via Email</span></a></li>";
    $output .= "<li class='socials__social socials__social--print'><a href='javascript:window.print()'><span class='screen-reader-text'>Visit our page</span></a></li>";
    $output .= "</ul>";

    return $output;
  }

  else {
    foreach ($data["content"] as $key => $value) {
      if (empty($value)) {
         unset($data["content"][$key]);
      } else {
        if (!empty(get_field($key, 'option'))) {
          $data["content"][$key] = get_field($key, 'option');
        }
      }
    }

    $output = "<!-- no socials defined -->";
    if (!empty(array_key_first($data["content"]))) {
      $output .= "<ul class='{$class}' {$id_attr} {$misc_attrs}>";
      foreach ($data["content"] as $social_name=>$url) {
        $output .= "<li class='socials__social socials__social--{$social_name}'><a href='${url}' target='_blank'><span class='screen-reader-text'>Visit our {$social_name} page</span></a></li>";
      }
      $output .= "</ul>";
    }
    return $output;
  }

});
gsc_test("socials", "sample socials", function() {
  echo gsc("socials", [
    "content" => [
      "facebook" => "facebook.com",
      "twitter" => "twitter.com",
      "instagram" => "instagram.com",
      "youtube" => "youtube.com"
    ]
  ]);
});
gsc_test("socials", "facebook and twitter only", function() {
  echo gsc("socials", [
    "content" => [
      "facebook" => "facebook.com",
      "twitter" => "twitter.com",
    ]
  ]);
});
gsc_test("socials", "insta and youtube only", function() {
  echo gsc("socials", [
    "content" => [
      "facebook" => false,
      "twitter" => false,
      "instagram" => "instagram.com",
      "youtube" => "youtube.com"
    ]
  ]);
});
