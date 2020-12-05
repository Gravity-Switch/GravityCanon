<?php

$defaults = [
  "content" => [
    "title" => "",
    "img_src" => '',
    "img_alt" => "",
    "img_class" => "",
    "text" => "",
    "list_items" => [],
    "cta" => '',
    "cta_url" => '#',
    "group_name" => ''
  ],
  "style" => [
    "cta_type" => 'button',
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];

gsc_define("ui-card-with-data", $defaults, function($data) {

  if (!empty($data["content"]["group_name"])) {
    $groupname = $data["content"]["group_name"];
  } else {
    $n=3;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    $groupname = $randomString;
  }


  $class = $data["style"]["class"];

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

  $cta_type = $data["style"]["cta_type"] == "button" ? "btn" : "link__content";

  $html = '';
  $html .= "<article class='card card--with-data {$class}' {$misc_attrs}>";
  $html .= "<aside class='card__aside'>";
  $html .= "<figure class='card__figure figure--graphic-ovrly'>";

  $html .= gsc("img", [
    "content" => [
      "src" => $data["content"]["img_src"],
      "alt" => $data["content"]["img_alt"]
    ],
    "style" => [
      "class" => $data["content"]["img_class"]
    ]
  ]);

  $html .= "</figure";
  $html .= "</aside>";
  $html .= "<!-- /.card__aside -->";

  $html .=  "<div class='card__main'>";
  $html .= "<header class='card__header'>";
  $html .= "<h2 class='card__title'> {$data["content"]["title"]} </h2>";
  $html .= "</header>";
  $html .= "<!-- /.card__header -->";

  $html .= "<div class='card__body'>";


  if (!empty($data["content"]["list_items"])) {
    // tab buttons
    $html .= "<div class='tabs'>";
    $html .= "<ul class='tabs__list' role='tablist' aria-label='title for tab content'>";
    $html .= "<li class='tabs__item' role='presentation'>";
    $html .= "<button type='button' class='btn btn--toggle is-active' id='tabs-{$groupname}__tab-link-1' role='tab' aria-selected='true' aria-controls='tabs-{$groupname}__panel-1' tabindex='-1'>";
    $html .= "{$data["content"]["list_items"][0]["title"]}";
    $html .= "</li>";

    $html .= "<li class='tabs__item' role='presentation'>";
    $html .= "<button type='button' class='btn btn--toggle' id='tabs-{$groupname}__tab-link-2' role='tab' aria-selected='false' aria-controls='tabs-{$groupname}__panel-2'>";
    $html .= "{$data["content"]["list_items"][1]["title"]}";
    $html .= "</li>";

    $html .= "</ul>";

    // tab sections
    $html .= "<div class='tabs__section' id='tabs-{$groupname}__panel-1' role='tabpanel' aria-labelledby='tabs-{$groupname}__tab-link-1' tab-index='0'>";
    $html .= "<div class='tabs__body'>";

    // Allows for stats to be present in any order, or for stats to be present on either page one or page 2 of the tab
    if (!empty($data["content"]["list_items"][0]["content"]["stats"])) {
      $stats = $data["content"]["list_items"][0]["content"]["stats"];
      foreach ($stats as $stat) {
        $html .= "<div class='stat stat--datapoint stat--{$stat["class"]}'>
          <h3 class='stat__heading'> {$stat["label"]} </h3>
            <p class='stat__info'>
              <span class='stat__ico'>
                {$stat["icon"]}
              </span>
              <strong class='stat__num'>{$stat["value"]}</strong>
              <span class='stat__label'>{$stat["label"]}</class>
            </p>
          </div>";
      }
    } else {
      $html .= "div class='stat stat--ico-txt'>
        <h3 class='stat__heading'>{$data["content"]["list_items"][0]["title"]}</h3>
        <p class='stat__info'>
          <span class='stat__ico'>
            {$data["content"]["list_items"][0]["icon"]}
          </span>
          <span class='stat__txt'>
            {$data["content"]["list_items"][0]["content"]}
          </span>
          </p>
        </div>";
    }

    $html .= "</div>";
    $html .= "</div>";


    $visibility = "aria-hidden='true'"; // replace with server-side tab param checking eventually

    $html .= "<div class='tabs__section' id='tabs-{$groupname}__panel-2' role='tabpanel' aria-labelledby='tabs-{$groupname}__tab-link-2' tabindex='0'  {$visibility} >";
    $html .= "<div class='tabs__body'>";

    // Allows for either stats or normal list_items content to be present on page 2
    if (!empty($data["content"]["list_items"][1]["content"]["stats"])) {
      $stats = $data["content"]["list_items"][1]["content"]["stats"];
      foreach ($stats as $stat) {
        $html .= "<div class='stat stat--datapoint stat--{$stat["class"]}'>
          <h3 class='stat__heading'> {$stat["label"]} </h3>
            <p class='stat__info'>
              <span class='stat__ico'>
                {$stat["icon"]}
              </span>
              <strong class='stat__num'>{$stat["value"]}</strong>
              <span class='stat__label'>{$stat["label"]}</class>
            </p>
          </div>";
      };
    } else {
      $html .= "<div class='stat stat--ico-txt'>
        <h3 class='stat__heading'>{$data["content"]["list_items"][1]["title"]}</h3>
        <p class='stat__info'>
          <span class='stat__ico'>
            {$data["content"]["list_items"][1]["icon"]}
          </span>
          <span class='stat__txt'>
            {$data["content"]["list_items"][1]["content"]}
          </span>
          </p>
        </div>";
    }

    $html .= "</div>";
    $html .= "</div>";

    $html .= "</div>";
    $html .= "<!-- /.tabs -->";
  }
  else {
    $html .= $data["content"]["text"];
  }


  $html .= "</div>";
  $html .= "<!-- /.card__body -->";

  // Footer
  $html .= "<footer class='card__footer'>";
  $html .= "<div class='card__actions'>";

  $html .= gsc("btn", [
    "content" => [
      "button" => $cta_type,
      "url" => $data["content"]["cta_url"],
      "text" => $data["content"]["cta"]
    ]
  ]);

  $html .= "</div>";
  $html .= "</footer>";
  $html .= "</div>";
  $html .= "</article>";

  return $html;
});
gsc_meta("ui-card-with-data", [MOLECULE]);
gsc_test("ui-card-with-data", "", function() {
  echo gsc("ui-card-with-data", []);
  echo gsc("ui-card-with-data", [
    "content" => [
      "title" => "Highway Maintenance Workers",
      "group_name" => 'test-group',
      "img_src" => get_template_directory_uri() . "/images/temp/img-stndrd@2x.jpg",
      "list_items" => [ // if false, main is used instead
        [
          "title" => 'Overview',
          "content" => [
            "stats" => [
              [
                "icon" => "<svg xmlns='http://www.w3.org/2000/svg' width='24.714' height='30.817' viewBox='0 0 24.714 30.817' aria-hidden='true'><title>Money bag</title><g transform='translate(0.857 0.75)'><path class='ico__path' d='M362.6,301.75h-2.649a1.749,1.749,0,0,0-.652,3.371l2.69,1.076a1.749,1.749,0,0,1-.652,3.371h-2.647' transform='translate(-349.14 -286.113)'></path><path class='ico__path' d='M360.074,301.977V301' transform='translate(-348.572 -286.341)'></path><path class='ico__path' d='M360.074,308.727v-.977' transform='translate(-348.572 -284.295)'></path><path class='ico__path' d='M354.824,297.25h13.682' transform='translate(-350.163 -287.477)'></path><path class='ico__path' d='M366.245,295.335l1.874-3.748a.978.978,0,0,0-1.311-1.311l-2.476,1.235a.977.977,0,0,1-1.25-.332l-.655-.994a.977.977,0,0,0-1.626,0l-.663.994a.976.976,0,0,1-1.25.332l-2.472-1.235a.978.978,0,0,0-1.312,1.311l1.837,3.675' transform='translate(-350.109 -289.75)'></path><path class='ico__path' d='M356.446,299.5l-3.6,4.17a7.73,7.73,0,0,0,6.124,12.443h7.545a7.729,7.729,0,0,0,6.124-12.443l-3.6-4.17' transform='translate(-351.247 -286.795)'></path></g></svg>",
                "value" => '?',
                "label" => "Average Wage",
                "class" => 'wage'
              ],
              [
                "icon" => "<svg xmlns='http://www.w3.org/2000/svg' width='32.571' height='30.5' viewBox='0 0 32.571 30.5' aria-hidden='true'><title>Briefcase</title><g transform='translate(0.75 0.75)'><path class='ico__path' d='M204.748,117.725a2.153,2.153,0,0,1,2.071-2.227h26.929a2.154,2.154,0,0,1,2.071,2.227v20.045A2.154,2.154,0,0,1,233.748,140H206.819a2.154,2.154,0,0,1-2.071-2.227Z' transform='translate(-204.748 -110.998)'></path><path class='ico__path' d='M209.248,120.748h22.071' transform='translate(-204.748 -107.284)'></path><path class='ico__path' d='M209.248,126.748h22.071' transform='translate(-204.748 -104.998)'></path><path class='ico__path' d='M219.34,112.023A1.5,1.5,0,0,0,217.917,111h-3.838a1.5,1.5,0,0,0-1.423,1.025L211.5,115.5h9Z' transform='translate(-200.462 -110.998)'></path><path class='ico__path' d='M207.748,115.5V114' transform='translate(-204.748 -110.998)'></path><path class='ico__path' d='M224.248,115.5V114' transform='translate(-196.177 -110.998)'></path></g></svg>",
                "value" => '?',
                "label" => "Current Openings",
                "class" => 'job'
              ]
            ]
          ]
        ],
        [
          "title" => 'Interests',
          "content" => 'Working with machines or with your hands, organized and detail-oriented',
          "icon" => "<svg xmlns='http://www.w3.org/2000/svg' width='30.5' height='30.5' viewBox='0 0 30.5 30.5' aria-hidden='true'>
            <title>Heart</title>
            <g transform='translate(-427 -568)'>
              <g transform='translate(427.75 568.75)'>
                <path class='ico__path' d='M440.517,587.9l-5.767-6.017a3.414,3.414,0,0,1-.644-3.939h0a3.413,3.413,0,0,1,5.465-.887l.946.942.942-.942a3.413,3.413,0,0,1,5.465.887h0a3.416,3.416,0,0,1-.644,3.939Z' transform='translate(-426.017 -566.637)'></path>
                <path class='ico__path' d='M442.25,597.75a14.5,14.5,0,1,0-14.5-14.5A14.5,14.5,0,0,0,442.25,597.75Z' transform='translate(-427.75 -568.75)'></path>
              </g>
            </g>
          </svg>"
          ]
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

 ?>
