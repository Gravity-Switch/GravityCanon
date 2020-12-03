<?php
$defaults = [
  "content" => [
		"tabs" => [
			[
				"link" => "",
				"content" => ""
			],
		],
    "group_name" => '', // prepended to ID of UI card object
		"aria_title" => ""
	],
  "style" => [
    "class" => '',
    "id" => '',
    "attrs" => []
  ]
];

gsc_define("tabs", $defaults, function($data) {

  // If groupname is empty, groupname = random string
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

	$tabs = $data["content"]["tabs"];

	$links_str = "";
	$panels_str = "";

	if (!empty($tabs)) {
		$tab_i = 0;
    foreach ($tabs as $tab) {
			$tab_i++;
			$is_active_class = ($tab_i == 1) ? "is_active" : "";
			$links_str .= "
				<li class='tabs__item' role='presentation'>
					<button type='button' class='tabs__link {$is_active_class}' id='tabs-{$groupname}__tab-link-{$tab_i}' role='tab' aria-selected='true' aria-controls='tabs-{$groupname}__panel-{$tab_i}'>{$tab["link"]}</button>
				</li>";
			$panels_str .= "
				<div class='tabs__section' id='tabs-{$groupname}__panel-{$tab_i}' role='tabpanel' aria-labelledby='tabs-{$groupname}__tab-link-{$tab_i}' tabindex='0'>
					<div class='tabs__body'>{$tab["content"]}</div>
				</div>";
		}
	}

	$links_str = "<ul class='tabs__list' role='tablist' aria-label='{$data["content"]["aria_title"]}'>
									$links_str
								</ul>";

	$class_attr = "class='tabs'";
  if (!empty($data["style"]["class"])) {
    $class_attr = "class='tabs {$data["style"]["class"]}'";
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

	$content = $links_str;

	return "<div $id_attr $class_attr $misc_attrs>
						$links_str
						$panels_str
					</div>";
});
gsc_meta("tabs", [MOLECULE]);
gsc_test("tabs", "", function() {

	echo gsc("tabs", [
    "content" => [
			"tabs" => [
				[
					"link" => "Costs",
					"content" => "
						<p><strong>Note:</strong> Calculation based on average family income for VSAC Vermont Incentive Grant recipients.</p>
						<p>
							<strong>Source:</strong> Vermont Student Assistance Corporation. (2018). VSAC Higher Education Fact Sheets for Vermont Counties. Accessed May 2019. Retrieved from:
							<a href='https://www.vsac.org/about/how-we-influence-policy'>https://www.vsac.org/about/how-we-influence-policy</a>
						</p>"
				],
				[
					"link" => "Debt",
					"content" => "Content of section 2 (Debt)"
				],
				[
					"link" => "Funding",
					"content" => "Content of section 2 (Funding)"
				],
				[
					"link" => "Perception",
					"content" => "Content of section 2 (Perception)"
				]
			],
			"aria_title" => "title for tab content",
      "group_name" => 'group'
		]
	]);

  echo gsc("tabs", [
    "content" => [
			"tabs" => [
				[
					"link" => "Yes",
					"content" => gsc_mock()
				],
				[
					"link" => "No",
					"content" => gsc_mock()
				],
				[
					"link" => "Maybe so",
					"content" => gsc_mock()
				],
				[
					"link" => "Gosh",
					"content" => gsc_mock()
				],
        [
					"link" => "Hmm",
					"content" => gsc_mock()
				],
        [
					"link" => "OK!",
					"content" => gsc_mock()
				],
			],
			"aria_title" => "title for tab content",
      "group_name" => 'wow'
		]
	]);

  echo gsc("tabs", [
    "content" => [
			"tabs" => [
				[
					"link" => gsc_mock(),
					"content" => gsc_mock()
				],
				[
					"link" => gsc_mock(),
					"content" => gsc_mock()
				],
			],
			"aria_title" => "title for tab content",
      "group_name" => 'looongtitle'
		],
    "style" => [
      "class" => "custom-class",
      "attrs" => [
        "custom-attr" => "attr"
      ]
    ]
	]);

});
