<?php

$defaults = [
  "content" => [
    "products" => []
  ],
  "style" => [
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];

gsc_define("product-grid", $defaults, function($data) {

  $class = "product-grid " . $data["style"]["class"];

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

  $products = $data["content"]["products"];
  $inner_content = "";
  foreach($products as $product) {
    $title = $product["title"];
    $link_title = $product["link_title"];
    $link_type = $product["type"];
    $link_url = $product["url"];
    $link_target = $product["target"];
    $image = $product["image"];

    $product_html = gsc("ui-card", [
      "content" => [
        "title" => $title,
        "cta" => $link_title,
        "cta_url" => $link_url,
        "img_src" => $image,
        "img_alt" => $title
      ],
      "style" => [
        "cta_type" => $link_type
      ]
    ]);

    $inner_content .= $product_html;
  }

  $html = "";
  $html .= "<div class='$class' $id $misc_attrs>";
  $html .= $inner_content;
  $html .= "</div>";

  return $html;

});

gsc_meta("product-grid", [MOLECULE]);

gsc_test("product-grid", "default product-grid", function() {

  echo gsc("product-grid", [
    "content" => [
      "products" => [
        [
          "title" => "HDPE Bags & Film",
          "link_title" => "View Product",
          "url" => "https://gravityswitch.com",
          "type" => "button"
      ],
      [
        "title" => "LLDPE Bags & Film",
        "link_title" => "View Product",
        "url" => "https://gravityswitch.com",
        "type" => "button"
      ],
      [
        "title" => "Bags on Rolls",
        "link_title" => "View Product",
        "url" => "https://gravityswitch.com",
        "type" => "button"
      ],
      [
        "title" => "Coreless Rolls",
        "link_title" => "View Product",
        "url" => "https://gravityswitch.com",
        "type" => "button"
      ],
      [
        "title" => "Drum Liners",
        "link_title" => "View Product",
        "url" => "https://gravityswitch.com",
        "type" => "button"
      ],
      [
        "title" => "Carton & Box Liners",
        "link_title" => "View Product",
        "url" => "https://gravityswitch.com",
        "type" => "button"
      ]
    ]
  ]
  ]);

});
