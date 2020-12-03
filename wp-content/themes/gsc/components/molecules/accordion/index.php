<?php

$defaults = [
  "content" => [
    "titles" => [],
    "content" => [],
    "data-allow-toggle" => false,
    "data-allow-multiple" => true
  ],
  "style" => [
    "fieldset" => [], // works paralell to titles and content... might want to refactor all three to be tighter at some point
    "section_class" => '',
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];

gsc_define("accordion", $defaults, function($data) {

  $class_attr = "";
  if (!empty($data["style"]["class"])) {
    $class_attr = $data["style"]["class"];
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

  // opening tag of accordion object
  $accordion_html = "";
  $data_allow_toggle = "";
  if ($data["content"]["data-allow-toggle"] == true) {
    $data_allow_toggle = "data-allow-toggle";
  }
  $data_allow_multiple = "";
  if ($data["content"]["data-allow-multiple"] == true) {
    $data_allow_multiple = "data-allow-multiple";
  }
  $accordion_html .= "<div class='accordion js-accordion {$class_attr}' {$data_allow_toggle} {$data_allow_multiple} {$misc_attrs}>";

  // check if title content exists
  if (!empty($data["content"]["titles"])) {
    // save titles and contents arrays to variable
    $titles = $data["content"]["titles"];
    $contents = $data["content"]["content"];

    // indexing variable
    $accordion_index = 1;

    foreach ($titles as $title) {
      $aria_expanded = "false";
      $aria_hidden = "true";

      if ($accordion_index == 1) {
        $aria_expanded = "true";
        $aria_hidden = "false";
      }
      $fieldset_status = false;
      if (isset($data["style"]["fieldset"]) && isset($data["style"]["fieldset"][$accordion_index-1])) {
        $fieldset_status = $data["style"]["fieldset"][$accordion_index-1];
      }
      $item_wrapper = "section";
      $heading_wrapper = "h2";
      $fieldset_label = "";
      if ($fieldset_status == true) {
        $item_wrapper = "fieldset";
        $heading_wrapper = "legend";
        $fieldset_label = " id='legend__filters-".($accordion_index)."' ";
      }



      // accordion header
      $section_html = "";
      $section_html .= "<{$item_wrapper} class='accordion__item'>";
      $section_html .= "<{$heading_wrapper} class='accordion__heading' $fieldset_label >";
      $section_html .= "<button type='button' class='accordion__btn js-accordion__btn' id='accordion-1__accordion-btn-{$accordion_index}' aria-expanded='{$aria_expanded}' aria-controls='accordion-1__panel-{$accordion_index}'>";
      $section_html .= "{$title}";
      $section_html .= "</button>";
      $section_html .= "</{$heading_wrapper}>";

      // accordion content
      $section_html .= "<div class='accordion__section js-accordion__section' id='accordion-1__panel-{$accordion_index}' aria-labelledby='accordion-1__accordion-btn-{$accordion_index}' aria-hidden='{$aria_hidden}' >";
      $section_html .= "<div class='accordion__body'>";
      if ($fieldset_status == true) {
        $section_html .= '<ul class="accordion__list" aria-labelledby="legend__filters-'.$accordion_index.'" role="group">';
      }
      $section_html .= $contents[$accordion_index - 1];
      if ($fieldset_status == true) {
        $section_html .= '</ul>';
      }
      $section_html .= "</div>";
      $section_html .= "</div>";
      $section_html .= "</{$item_wrapper}>";

      $accordion_html .= $section_html;
      $accordion_index++;
    };

    $accordion_html .= "</div>";

    return $accordion_html;
  }
});
gsc_meta("accordion", [MOLECULE, "multiple", "interactive"]);
gsc_test("accordion", "basic accordion test", function() {
  echo gsc("accordion", [
    "content" => [
      "titles" => [
        "A cross-sector convening of executives from across the state selected the goal of 70 percent attainment",
        "A cross-sector convening of executives from across the state selected the goal of 70 percent attainment"
      ],
      "content" => [
        "<p>By using this Website, you agree to the Terms of Use.</p>
        <p>
          Vermont Student Assistance Corporation (“VSAC”) maintains this website on the Internet for students, parents, financial aid professionals, education lenders, and others interested in
          learning about access to education, training, and career opportunities and for those interested in applying to VSAC for education loans.
        </p>
        <p>
          Please read these Terms of Use carefully. They govern the use of our website and form a legally binding agreement between you and VSAC. If you do not agree to abide by the Terms of
          Use, you must not use this website. These Terms of Use apply to this website and the other VSAC websites or web applications that display or link to these Terms of Use.
        </p>",
        "<p>By using this Website, you agree to the Terms of Use.</p>
        <p>
          Vermont Student Assistance Corporation (“VSAC”) maintains this website on the Internet for students, parents, financial aid professionals, education lenders, and others interested in
          learning about access to education, training, and career opportunities and for those interested in applying to VSAC for education loans.
        </p>
        <p>
          Please read these Terms of Use carefully. They govern the use of our website and form a legally binding agreement between you and VSAC. If you do not agree to abide by the Terms of
          Use, you must not use this website. These Terms of Use apply to this website and the other VSAC websites or web applications that display or link to these Terms of Use.
        </p>"
      ]
    ]
  ]);
});

gsc_test("accordion", "Accordion with custom class and attrs", function() {
  echo gsc("accordion", [
    "content" => [
      "titles" => [
        "A cross-sector convening of executives from across the state selected the goal of 70 percent attainment",
        "A cross-sector convening of executives from across the state selected the goal of 70 percent attainment"
      ],
      "content" => [
        "<p>By using this Website, you agree to the Terms of Use.</p>
        <p>
          Vermont Student Assistance Corporation (“VSAC”) maintains this website on the Internet for students, parents, financial aid professionals, education lenders, and others interested in
          learning about access to education, training, and career opportunities and for those interested in applying to VSAC for education loans.
        </p>
        <p>
          Please read these Terms of Use carefully. They govern the use of our website and form a legally binding agreement between you and VSAC. If you do not agree to abide by the Terms of
          Use, you must not use this website. These Terms of Use apply to this website and the other VSAC websites or web applications that display or link to these Terms of Use.
        </p>",
        "<p>By using this Website, you agree to the Terms of Use.</p>
        <p>
          Vermont Student Assistance Corporation (“VSAC”) maintains this website on the Internet for students, parents, financial aid professionals, education lenders, and others interested in
          learning about access to education, training, and career opportunities and for those interested in applying to VSAC for education loans.
        </p>
        <p>
          Please read these Terms of Use carefully. They govern the use of our website and form a legally binding agreement between you and VSAC. If you do not agree to abide by the Terms of
          Use, you must not use this website. These Terms of Use apply to this website and the other VSAC websites or web applications that display or link to these Terms of Use.
        </p>"
      ]
    ],
    "style" => [
      "class" => "custom-class",
      "attrs" => [
        "custom-attr" => "attr"
      ]
    ]
  ]);
});
