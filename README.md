# GravityCanon
base setup for gs wp sites using gsc system

## The Component System Methodology

GSCanon is based on the concepts outlined in [Atomic Design](https://bradfrost.com/blog/post/atomic-web-design/#atoms). GSCanon allows devs to put together a library of modular web components within a WordPress theme.

GSCanon provides integrations for connecting your components to Gutenberg Blocks via ACF, WP Facet and Gravity Forms.

### Atoms, Molecules and Organisms

Within the the themes/GSC/components folder you'll find a folder for atoms and a folder for molecules. Atoms are basic components like buttons, links, titles and etc. Molecules can contain several "atoms" to create a more complex component, like a navigation menu. These molecules can be put together in the form of an organism, which is typically housed in the template-parts folder. 

## Working With GSCanon

### Creating a Component's Structure

#### Assign Defaults

The PHP file for defining the HTML structure of the component should be named index.php and must be housed within that new atom folder. 

At the top of index.php, an array called $defaults must be declared. This array will provide your component with the expected inputs your component can receive as well as the default values for those inputs for cases where they are ommitted.

As an example, this is how we might define the defaults for a title component. Since the title is a basic component that doesn't utilize others, it would be housed in the Atoms folder and it's component type would be Atom.

```
$defaults = [
    "content" => [
        "main" => '',
    ],
    "style" => [
        "container" => 'h2'
        "class" => '',
        "id" => '',
        "attrs" => []
    ]
]
```

In the above example, we've split the component into two parts, the content for that web component, and the styling for that web component. 

You can build your defaults array any way you wish, for example, you may have components which you do not want to assign styling to to prevent collisions with it's molecule styling. This is a fairly common practice for atoms.

#### Define the HTML

After you've defined your defaults, you'll need to use the function `gsc_define`, to create a modular definition of how your atom is constructed. 

This function takes two arguments
1. The name of the component (Title, Button, Paragraph and etc)
2. The variable with your defaults array

Use your provided defaults to construct a string using your input array to fill in the variable sections of your HTML structure. Once you've constructed your string be sure to return it at the end of the function.

Using the previous example, we would build our GSC_Define function as follows, 

```
gsc_define("title", $defaults, function ($data) {
    $container = $data["style"]["container"];
    $main_content = $data["content"]["main"];
    
    $id_attr = "";
    if (!empty($data["style"]["id"])) {
        $id_attr = "id='{data["style"]["id"]}'";
    }

    $class_attr = "";
    $class = $data["style"]["class"];
    if (!empty($class)) {
        $class_attr = "class='{$class}'";
    }

    $misc_attrs = "";
    if (!empty($data["style"]["attrs"])) {
        foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
            $misc_attrs .= "$attr_name='$attr_value' ";
    }
  }
  return "<$container $id_attr $class_attr $misc_attrs>$main_content</$container>";
});
```

#### GSC Meta

Before your test cases, you must include the gsc_meta function, with a string representing the name of the component as the first argument, and the type of component as the second argument.

`gsc_meta("title", [ATOM]);`

#### Test Cases

At the end of the file, is where you can include test cases, these test cases will be pulled to the page template "Component Test" where all components will be displayed a long with their test cases.

All test cases begin with the function gsc_text with two args, the first being the title of the component, and the second being an empty string.

Below is an example of a GSC test using the "Title" component.

```
gsc_test("title", "", function() {
    // You can then test your components by calling gsc and providing the name of the component and it's input array
    echo gsc("title", [
        "content" => [
            "main" => "Test Heading Text",
        ],
        "style" => [
            "container" => "h2",
            "class" => "test-title"
        ]
    ]);
});
```

### Adding Component Styling and Functionality

#### Styling via SASS

For the most part, styling via GSCanon is the same as most SASS projects. While you can define your styling outside of GSC, you can include the file in your component's folder. If you do this, the name of the sass file must be 'component.scss'. By doing this, it will automatically be included in the output CSS file. 

#### Functionality via JS

For components that need JavaScript functionality, the file can be added directly to the component's folder, in which case it must be titled 'component.js'.

### Integrations

#### Gravity Forms
How it Works
The GSC/Gravity Form integration works mainly by utilizing the hook “gform_field_content” to edit the HTML generated by the Gravity Form Plugin. The most common use of these integrations is to apply Gravity Switch input styling to Gravity Forms without the need for adding Gravity Form classes to our inputs styling and without needing to utilize JQuery to apply GSC HTML to these input fields.

Gravity Form Labels
`remove_gform_labels`

Are removed automatically via this snippet here: 

```
add_filter( 'gform_field_content', 'remove_gform_labels', 10, 5 );
function remove_gform_labels( $content, $field, $value, $lead_id, $form_id ) {
	$doc = new DOMDocument();
	$doc->loadHTML($content);
	// $labels = $doc->getElementsByTagName("label");
	$finder = new DomXPath($doc);
	$classname = "gfield_label";
	$labels = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

	foreach ($labels as $label) {
		$label->parentNode->removeChild($label);
	}

	return $doc->saveHTML();
}
```

This code removes the labels entirely, because typical GSC input components have labels with different types of class names and different placements within the fields' HTML it’s best to remove all of them anyway.

The labels are then added via the ‘customized’ version of the input as shown below

Customized Inputs

`customize_gform_inputs`

This function requires a selector, typically a gform fieldtype, and returns the customized HTML. 

When editing the file, it’s important to ensure that more specific fields are contained at the top of the function, while general input fields are at the bottom. 

For instance an address field, which is a type of a select field, is the first item in this function, while the generic input field radio field is the last item in the function.

The below code snippet shows the function in action. When a Gravity Form includes the fieldtype of “time”, it will be replaced with the new HTML in the $input field. The parameters from the ‘customize_gform_inputs’ function are utilized to keep the data consistent between the gravity form and the GSC implementation, keeping the label, id and description consistent.

```
	if ( $field->type == "time" ) {
		$input = "<div class='form__element--required'>
				<label class='form__label' for='input_1_".$field->id."'>".$field->label."</label>
				<div class='form__description' id='gfield_description_1_".$field->id."'>".$field->description."</div>
			<div class='ginput_complex'>
				<div class='gfield_time_hour ginput_container ginput_container_time' id='input_1_8'>
				<input type='number' maxlength='2' name='input_8[]' id='input_1_8_1' value='' min='0' max='12' step='1' placeholder='HH' aria-required='true' aria-describedby='gfield_description_1_8'> 
			</div>
			<div class='above hour_minute_colon'>:</div>
			<div class='gfield_time_minute ginput_container ginput_container_time'>
				<label class='minute_label screen-reader-text' for='input_1_8_2'>Minutes</label>
				<input type='number' maxlength='2' name='input_8[]' id='input_1_8_2' value='' min='0' max='59' step='1' placeholder='MM' aria-required='true'>
			</div>
			<div class='gfield_time_ampm ginput_container ginput_container_time above'>
				<select name='input_8[]' id='input_1_8_3'>
					<option value='am'>AM</option>
					<option value='pm'>PM</option>
				</select> 
			</div>
		
		</div>";
	}
```

Below is an example of a GSC component being utilized in the customize_gform_inputs function.

```
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
```


Gravity Form Submit Button

`add_custom_css_classes`

```
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
```

This function will likely change in the future, it handles the application of specific classes to the submit button. These classes are site specific and should be scrubbed between site projects.


Extending this File
You can find a full list of Gravity Form Hooks and Filters here: 

[Hooks Archives - Gravity Forms Documentation](https://docs.gravityforms.com/category/developers/hooks/) 



## GMap Component

In order to use the component

- Functions.php needs proper GMap API Keys
- An ACF Google Maps field must be added to the options page