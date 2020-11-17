<?php
add_filter( 'gform_field_content', 'remove_gform_labels', 10, 5 );
function remove_gform_labels( $content, $field, $value, $lead_id, $form_id ) {
	$doc = new DOMDocument();
	$doc->loadHTML($content);
	//$labels = $doc->getElementsByTagName("label");
	$finder = new DomXPath($doc);
	$classname = "gfield_label";
	$labels = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

	foreach ($labels as $label) {
		$label->parentNode->removeChild($label);
	}

	return $doc->saveHTML();
}
add_filter( 'gform_field_input', 'customize_gform_inputs', 10, 5 );
function customize_gform_inputs( $input, $field, $value, $lead_id, $form_id ) {
	//echo "Field<br><pre style='font-size:11px'>"; print_r($field); echo "</pre>";
	//echo "Value<br><pre style='font-size:11px'>"; print_r($value); echo "</pre>";

	$error = false;
	if ($field->failed_validation) {
		$error = $field->validation_message;
	}

	if ($field->type == "text" || $field->type == "email" || $field->type == "number") {
		$input = gsc("input-text", [
			"content" => [
				"label" => $field->label,
				"value" => $value,
				"required" => $field->isRequired,
				"error" => $error
			],
			"style" => [
				"id" => "input_{$form_id}_{$field->id}",
				"name" => "input_{$field->id}",
        "class" => "input--full-width",
        "type" => $field->type
			]
		]);
	}

	if ($field->type == "textarea") {
		$input = gsc("textarea", [
			"content" => [
				"label" => $field->label,
				"value" => $value,
				"required" => $field->isRequired,
				"error" => $error
			],
			"style" => [
				"id" => "input_{$form_id}_{$field->id}",
				"name" => "input_{$field->id}",
        "class" => "input--full-width",
        "attrs" => ["rows" => 10]
			]
		]);
	}

	if ($field->type == "select" || $field->type == "multiselect" || $field->inputType == "multiselect" ) {
		$options = [];
		foreach ($field->choices as $choice) {
			$option = [
				"value" => $choice["value"],
				"text" => $choice["text"],
				"selected" => $choice["isSelected"],
				"disabled" => false,
        "multiple" => ($field->type == "multiselect")
			];
			array_push($options, $option);
		}
		$input = gsc("select", [
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

	if ($field->type == "checkbox") {

		$options = [];
		foreach ($field->choices as $index=>$choice) {
			$printed_index = $index+1;
			$option = [
				"id" => "choice_{$form_id}_{$field->id}_{$printed_index}",
				"name" => "input_{$field->id}.{$printed_index}",
				"value" => $choice["value"],
				"text" => $choice["text"],
				"checked" => (in_array($choice["value"], array_values($value))),
				"disabled" => false
			];
			array_push($options, $option);
		}
		$input = gsc("checkboxes", [
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

	if ($field->type == "radio") {
		$options = [];
		foreach ($field->choices as $index=>$choice) {
			$printed_index = $index+1;
			$option = [
				"id" => "choice_{$form_id}_{$field->id}_{$printed_index}",
				"name" => "input_{$field->id}",
				"value" => $choice["value"],
				"text" => $choice["text"],
				"checked" => (in_array($choice["value"], array_values($value))),
				"disabled" => false
			];
			array_push($options, $option);
		}
		$input = gsc("radios", [
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

  return $input;
}

/**
* Gravity Wiz // Disable HTML5 Validation on Gravity Forms
* http://gravitywiz.com/disable-html5-validation-on-gravity-forms/
*/
add_filter( 'gform_form_tag', 'add_no_validate_attribute_to_form_tag' );
function add_no_validate_attribute_to_form_tag( $form_tag ) {
    return str_replace( '>', ' novalidate="novalidate">', $form_tag );
}
add_filter( 'gform_submit_button', 'add_custom_css_classes', 10, 2 );
function add_custom_css_classes( $button, $form ) {
    $dom = new DOMDocument();
    $dom->loadHTML( '<?xml encoding="utf-8" ?>' . $button );
    $input = $dom->getElementsByTagName( 'input' )->item(0);
    $classes = $input->getAttribute( 'class' );
    $classes .= " btn";
    $input->setAttribute( 'class', $classes );
    return $dom->saveHtml( $input );
}
