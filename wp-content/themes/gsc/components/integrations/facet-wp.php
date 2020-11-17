<?php
add_filter( 'facetwp_facet_html', function( $output, $params ) {
	//var_dump($params);
	$type = $params["facet"]["type"];
	if ($type == "pager" && $params["facet"]["name"] == "load_more") {
		$output = gsc("btn", [
			"content" => [
	      "button" => true,
	      "text" => 'Show More'
	    ],
			"style" => [
				"class" => "facetwp-load-more",
				"attrs" => [
					"data-loading" => "Loading..."
				]
			]
		]);
	}
	if ($type == "search" || $type == "autocomplete") {
		$output = gsc("input-text", [
			"content" => [
				"label" => $params["facet"]["label"],
				"value" => $params["facet"]['selected_values'],
			],
			"style" => [
				"id" => "input_{$params["facet"]["name"]}",
				"name" => "input_{$params["facet"]["name"]}",
        "class" => "input--full-width",
				"input-class" => "facetwp-search"
			]
		]);
	}

	if ($type == "fselect" || $type == "dropdown") {
		$options = [];
		foreach ($field->choices as $choice) {
			$option = [
				"value" => $facet['facet_value'],
				"text" => $facet['facet_display_value'],
				"selected" => $choice["isSelected"],
				"disabled" => false,
        "multiple" => ($field->type == "multiselect")
			];
			array_push($options, $option);
		}
		$output = gsc("select", [
			"content" => [
        "label" => $field->label,
				"options" => $options
			],
			"style" => [
				"id" => "input_{$form_id}_{$field->id}",
				"name" => "input_{$field->id}",
        "class" => "input--full-width"
			]
		]);
	}


	if ($type == "checkboxes" || $type == "range_list" ) {
		$stated_type = ($type == "range_list") ? "radio" : "checkbox";
		$options = [];
		foreach ($params['values'] as $index=>$facet) {
			$is_checked = (in_array($facet['facet_value'], $params["selected_values"]));
			$is_disabled = ($facet["counter"] == 0);
			$checked_class = $is_checked ? " checked " : "";
			$disabled_class = $is_disabled ? " disabled " : "";
			$option = [
				"id" => "checkbox-{$facet['facet_value']}",
				"name" => $facet['facet_value'],
				"value" => $facet['facet_value'],
				"text" => $facet['facet_display_value']." ({$facet["counter"]})",
				"checked" => $is_checked,
				"disabled" => $is_disabled,
				"class" => "facetwp-{$stated_type} {$checked_class}{$disabled_class}",
				"attrs" => [
					"data-value" => $facet['facet_value'],
				]
			];
			array_push($options, $option);
		}
    if (true) {
      $output = "";
      foreach ($options as $option) {
        $output .= gsc("checkbox", [
          "content" => [
            "value" => $option["value"],
            "text" => $option["text"],
          ],
          "style" => [
            "id" => $option["id"],
            "name" => $option["name"],
            "class" => $option["class"],
            "checked" => $option["checked"],
    				"disabled" => $option["disabled"],
            "container" => "li",
            "attrs" => $option["attrs"]
          ]
        ]);
      }
    }
    else {
      $output = gsc("checkboxes", [
  			"content" => [
  				"legend_text" => $params["facet"]["label"],
  				"legend_id" => "label_{$params["facet"]["name"]}",
  				"options" => $options
  			]
  		]);
    }

	}

	if ($type == "radio") {
		$options = [];
		foreach ($field->choices as $index=>$choice) {
			$printed_index = $index+1;
			$option = [
				"id" => "choice_{$form_id}_{$field->id}_{$printed_index}",
				"name" => "input_{$field->id}",
				"value" => $choice["value"],
				"text" => $choice["text"]." ({$facet["counter"]})",
				"checked" => (in_array($choice["value"], array_values($value))),
				"disabled" => false
			];
			array_push($options, $option);
		}
		$output = gsc("radios", [
			"content" => [
				"legend_text" => $field->label,
				"legend_id" => "label_{$form_id}_{$field->id}",
				"options" => $options
			],
			"style" => [
				"id" => "input_{$form_id}_{$field->id}",
				"name" => "input_{$field->id}",
			]
		]);
	}

  return $output;
}, 10, 2 );

add_filter( 'facetwp_result_count', function( $output, $params ) {
	$output =  gsc("filter_result", ["content" => ["num_results" => $params['total']]]);
	return $output;
}, 10, 2 );
function my_cache_lifetime( $seconds ) {
    return 300; // 5mins
}
add_filter( 'facetwp_cache_lifetime', 'my_cache_lifetime' );

// add js hook for return to index, input return fix
add_action("wp_footer", function () {
  ?>
  <script>
    jQuery(document).on('facetwp-refresh', function() {
      window.localStorage.setItem('gs_last_search__'+FWP.template, window.location.pathname+window.location.search);
    });

		jQuery(".facetwp-type-search").on("keydown", function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
				jQuery(this).closest(".menu__wrapper").find("data-modal-close-btn").click();
	      return false;
	    }
	  });
  </script>
  <?php
});
