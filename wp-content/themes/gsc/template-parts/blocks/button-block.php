<?php

/*
  Banner Block

  @param array $block the block settings and attributes
  @param string $content the block inner HTML
  @param bool $is_preview True during AJAX preview
  @param (int|string) $post_id The post ID this block is saved to

*/

// create an id attribute for custom 'anchor' value
$id = 'banner-group' . $block['id'];
if ( !empty($block['anchor'])) {
  $id = $block['anchor'];
}

if (have_rows('button_group')) :
  the_row();

  $button = get_sub_field('button');
  $active = get_sub_field('active');
  $type = get_sub_field('type');
  $main = get_sub_field('main');
  $text = get_sub_field('text');
  $url = get_sub_field('url');
  $target = get_sub_field('target');
  $svg = get_sub_field('svg');
  $class = get_sub_field('class');
  $id = get_sub_field('id');

  if (have_rows('attrs')) :
    $attrs = [];
    while(have_rows('attrs')) : the_row();
      array_push($attrs, get_sub_field('attr_label') + ', ' + get_sub_field('attr_value'));
    endwhile;
  endif;

  echo gsc("btn", [
    "content" => [
      "button" => $button,
      "active" => $active,
      "type" => $type,
      "main" => $main,
      "text" => $text,
      "url" => $url,
      "target" => $target,
    ],
    "style" => [
      "svg" => $svg,
      "class" => $class,
      "id" => $id,
      "attrs" => [
        $attrs
      ]
    ]
  ]);

endif;

?>
