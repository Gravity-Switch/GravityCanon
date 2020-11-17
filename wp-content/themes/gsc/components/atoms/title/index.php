<?php
// don't fret too hard over the defaults but try to make it a very basic scenario that'll still be useful.
// when in doubt, keep it null/false/blank - don't want to have to override too much.
// HOWEVER, if a feature can be toggled by existence of only one value, the others can have useful defaults - see "color_" in this example.
// if an option's not self-explanatory from the name/value, put a comment next to it.
$defaults = [
  "content" => [
    "main" => '',
    "url" => '', // get a basic link in the heading if url is filled
    "target" => '_self' // support for url
  ],
  "style" => [
    "container" => 'h2',
    "color_words" => 0, // wrap subset of words in a color. doesn't trigger at 0
    "color" => 'teal', // provide named color-_____ class from SASS
    "color_position" => 'first', // can also be last
    "border" => false, // if set, to "left" or "right"
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];
// gsc define takes the component name, default value array, and the renderer function.
// renderer function must take one argument, $data, and return a string of HTML/etc output
gsc_define("title", $defaults, function ($data) {
  // further sanitize/manipulate/provide testdata as needed
  $container = $data["style"]["container"];
  $main_content = $data["content"]["main"];// = gsc_mock($data["content"]["main"]);
  $color_text = "";
  $color_word_count = $data["style"]["color_words"];
  $color_position = $data["style"]["color_position"];
  //var_dump($color_position);
  if ($color_word_count > 0) {
    $main_content_pieces = preg_split('/\s+/', $main_content, -1, PREG_SPLIT_NO_EMPTY);


    if ($color_position == "first") {
      $color_text = implode(" ", array_splice($main_content_pieces, 0, $color_word_count));
      $color_text = "<span class='color-".$data["style"]["color"]."'>$color_text</span>";
      $main_content = $color_text." ".implode(" ", $main_content_pieces);
    }
    else {
      $color_text = implode(" ", array_splice($main_content_pieces, -$color_word_count));
      $color_text = "<span class='color-".$data["style"]["color"]."'>$color_text</span>";
      $main_content = implode(" ", $main_content_pieces)." ".$color_text;
    }


  }

  $id_attr = "";
  if (!empty($data["style"]["id"])) {
    $id_attr = "id='{$data["style"]["id"]}'";
  }

  $class_attr = "";
  $class = $data["style"]["class"];
  if (!empty($data["style"]["border"])) {
    $class .= " title--border-".$data["style"]["border"];
  }
  if (!empty($class)) {
    $class_attr = "class='{$class}'";
  }

  if (!empty($data["content"]["url"])) {
    $main_content = "<a href='{$data["content"]["url"]}' target='{$data["content"]["target"]}'>$main_content</a>";
  }

  $misc_attrs = "";
  if (!empty($data["style"]["attrs"])) {
    foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
      $misc_attrs .= "$attr_name='$attr_value' ";
    }
  }
  return "<$container $id_attr $class_attr $misc_attrs>$main_content</$container>";
});

// define your test/demo function after defining the component itself.
// this function must take no args, return nothing, and echo the test output itself.
gsc_meta("title", [ATOM]);
gsc_test("title", "", function() {
  echo gsc("title", [
    "content" => [
      "main" => gsc_mock()
    ]
  ]);
  echo gsc("title", [
    "content" => [
      "main" => "Actual Heading Content! Lots of it! 6 words emphasized. So Much heading text! It's unbelievable. There's way too much of it here. Why is there so much? Who would do such a thing? Oh well. It's none of my business."
    ],
    "style" => [
      "container" => "h2",
      "border" => "left",
      "color_words" => 6
    ]
  ]);
  ?>
  <p>See how an ordinary paragraph fits in here.</p>
  <?php
  echo gsc("title", [
    "content" => [
      "main" => "Another little heading. An h3, to be precise, with the last three words emphasized."
    ],
    "style" => [
      "container" => "h3",
      "border" => "right",
      "color_words" => 3,
      "color_position" => "last"
    ]
  ]);
  echo gsc("title", [
    "content" => [
      "main" => "A cheeky lil h4. ".gsc_mock()
    ],
    "style" => [
      "container" => "h3",
      "border" => "left",
      "color_words" => 20
    ]
  ]);
  echo gsc("title", [
    "content" => [
      "main" => "Does anyone use h5s these days? ".gsc_mock()
    ],
    "style" => [
      "container" => "h3",
      "border" => "right",
      "color" => "orange",
      "color_words" => 99
    ]
  ]);
  echo gsc("title", [
    "content" => ["main" => "Custom element, class, id, attrs."],
    "style" => [
      "container" => "div",
      "class" => "custom-class",
      "id" => "idy",
      "attrs" => ["data-flavor"=>"cherry", "data-temperature"=>90]
    ]
  ]);

});
