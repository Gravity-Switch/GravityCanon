<?php
/**
 * GS Canon standard functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package GS_Canon
*/

 if ( ! defined( '_S_VERSION' ) ) {
 	// Replace the version number of the theme on each release.
 	define( '_S_VERSION', '1.0.0' );
 }

 if ( ! function_exists('glob_recursive'))
 {
     // Does not support flag GLOB_BRACE
    function glob_recursive($pattern, $flags = 0)
    {
      $files = glob($pattern, $flags);
      foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
      {
        $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
      }
      return $files;
    }
 }

 // load initial libs
 foreach (glob_recursive(get_template_directory()."/lib/*.php") as $filename)
 {
     include_once $filename;
 }

 // include files for components
 include_once get_template_directory()."/components/gsc.php";
 foreach (glob_recursive(get_template_directory()."/components/atoms/*/index.php") as $filename)
 {
     include_once $filename;
 }
 foreach (glob_recursive(get_template_directory()."/components/molecules/*/index.php") as $filename)
 {
     include_once $filename;
 }
 // gsc integrations
 foreach (glob(get_template_directory()."/components/integrations/*.php") as $filename)
 {
     include_once $filename;
 }


 /**
  * Enqueue/dequeue appropriate scripts and styles.
  */
 function gsc_scripts() {
   // random version for dev cache bust. remove this before go-live!!!!!!!
  $random_version = rand(0,9999);
 	wp_enqueue_style( 'gsc-style', get_stylesheet_uri(), [], $random_version );
 	wp_enqueue_script( 'gsc-bundle', get_template_directory_uri() . '/bundle.js', ["jquery"], $random_version, true );
 }
 add_action( 'wp_enqueue_scripts', 'gsc_scripts' );
 remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
 remove_action( 'wp_print_styles', 'print_emoji_styles' );

 if( function_exists('acf_add_local_field_group') ):

   if( function_exists('acf_add_local_field_group') ):

   acf_add_local_field_group(array(
   	'key' => 'group_5fcbd0749e7f4',
   	'title' => 'Button Group',
   	'fields' => array(
   		array(
   			'key' => 'field_5fcbd08e01e10',
   			'label' => 'Button',
   			'name' => 'button',
   			'type' => 'true_false',
   			'instructions' => '',
   			'required' => 0,
   			'conditional_logic' => 0,
   			'wrapper' => array(
   				'width' => '',
   				'class' => '',
   				'id' => '',
   			),
   			'message' => '',
   			'default_value' => 1,
   			'ui' => 0,
   			'ui_on_text' => '',
   			'ui_off_text' => '',
   		),
   		array(
   			'key' => 'field_5fcbd0b201e11',
   			'label' => 'Active',
   			'name' => 'active',
   			'type' => 'true_false',
   			'instructions' => '',
   			'required' => 0,
   			'conditional_logic' => 0,
   			'wrapper' => array(
   				'width' => '',
   				'class' => '',
   				'id' => '',
   			),
   			'message' => '',
   			'default_value' => 0,
   			'ui' => 0,
   			'ui_on_text' => '',
   			'ui_off_text' => '',
   		),
   		array(
   			'key' => 'field_5fcbd0c201e12',
   			'label' => 'Type',
   			'name' => 'type',
   			'type' => 'select',
   			'instructions' => '',
   			'required' => 0,
   			'conditional_logic' => 0,
   			'wrapper' => array(
   				'width' => '',
   				'class' => '',
   				'id' => '',
   			),
   			'choices' => array(
   				'default' => 'default',
   				'secondary' => 'secondary',
   				'toggle' => 'toggle',
   				'modal' => 'modal',
   				'icon' => 'icon',
   			),
   			'default_value' => array(
   			),
   			'allow_null' => 0,
   			'multiple' => 0,
   			'ui' => 0,
   			'return_format' => 'value',
   			'ajax' => 0,
   			'placeholder' => '',
   		),
   		array(
   			'key' => 'field_5fcbd0fb01e13',
   			'label' => 'Main',
   			'name' => 'main',
   			'type' => 'text',
   			'instructions' => '',
   			'required' => 0,
   			'conditional_logic' => 0,
   			'wrapper' => array(
   				'width' => '',
   				'class' => '',
   				'id' => '',
   			),
   			'default_value' => '',
   			'placeholder' => '',
   			'prepend' => '',
   			'append' => '',
   			'maxlength' => '',
   		),
   		array(
   			'key' => 'field_5fcbd10401e14',
   			'label' => 'Text',
   			'name' => 'text',
   			'type' => 'text',
   			'instructions' => '',
   			'required' => 0,
   			'conditional_logic' => 0,
   			'wrapper' => array(
   				'width' => '',
   				'class' => '',
   				'id' => '',
   			),
   			'default_value' => '',
   			'placeholder' => '',
   			'prepend' => '',
   			'append' => '',
   			'maxlength' => '',
   		),
   		array(
   			'key' => 'field_5fcbd10c01e15',
   			'label' => 'Url',
   			'name' => 'url',
   			'type' => 'url',
   			'instructions' => '',
   			'required' => 0,
   			'conditional_logic' => 0,
   			'wrapper' => array(
   				'width' => '',
   				'class' => '',
   				'id' => '',
   			),
   			'default_value' => '',
   			'placeholder' => '',
   		),
   		array(
   			'key' => 'field_5fcbd11701e16',
   			'label' => 'target',
   			'name' => 'target',
   			'type' => 'select',
   			'instructions' => '',
   			'required' => 0,
   			'conditional_logic' => 0,
   			'wrapper' => array(
   				'width' => '',
   				'class' => '',
   				'id' => '',
   			),
   			'choices' => array(
   				'__blank' => '__blank',
   				'__self' => '__self',
   				'__parent' => '__parent',
   				'__top' => '__top',
   			),
   			'default_value' => array(
   			),
   			'allow_null' => 0,
   			'multiple' => 0,
   			'ui' => 0,
   			'return_format' => 'value',
   			'ajax' => 0,
   			'placeholder' => '',
   		),
   		array(
   			'key' => 'field_5fcbd15601e17',
   			'label' => 'SVG',
   			'name' => 'svg',
   			'type' => 'icon-picker',
   			'instructions' => '',
   			'required' => 0,
   			'conditional_logic' => 0,
   			'wrapper' => array(
   				'width' => '',
   				'class' => '',
   				'id' => '',
   			),
   			'initial_value' => '',
   		),
   		array(
   			'key' => 'field_5fcbd17101e18',
   			'label' => 'Class',
   			'name' => 'class',
   			'type' => 'text',
   			'instructions' => '',
   			'required' => 0,
   			'conditional_logic' => 0,
   			'wrapper' => array(
   				'width' => '',
   				'class' => '',
   				'id' => '',
   			),
   			'default_value' => '',
   			'placeholder' => '',
   			'prepend' => '',
   			'append' => '',
   			'maxlength' => '',
   		),
   		array(
   			'key' => 'field_5fcbd17701e19',
   			'label' => 'ID',
   			'name' => 'id',
   			'type' => 'text',
   			'instructions' => '',
   			'required' => 0,
   			'conditional_logic' => 0,
   			'wrapper' => array(
   				'width' => '',
   				'class' => '',
   				'id' => '',
   			),
   			'default_value' => '',
   			'placeholder' => '',
   			'prepend' => '',
   			'append' => '',
   			'maxlength' => '',
   		),
   		array(
   			'key' => 'field_5fcbd17d01e1a',
   			'label' => 'Attrs',
   			'name' => 'attrs',
   			'type' => 'repeater',
   			'instructions' => '',
   			'required' => 0,
   			'conditional_logic' => 0,
   			'wrapper' => array(
   				'width' => '',
   				'class' => '',
   				'id' => '',
   			),
   			'collapsed' => '',
   			'min' => 0,
   			'max' => 0,
   			'layout' => 'table',
   			'button_label' => '',
   			'sub_fields' => array(
   				array(
   					'key' => 'field_5fcbd18c01e1b',
   					'label' => 'Attr Label',
   					'name' => 'attr_label',
   					'type' => 'text',
   					'instructions' => '',
   					'required' => 0,
   					'conditional_logic' => 0,
   					'wrapper' => array(
   						'width' => '',
   						'class' => '',
   						'id' => '',
   					),
   					'default_value' => '',
   					'placeholder' => '',
   					'prepend' => '',
   					'append' => '',
   					'maxlength' => '',
   				),
   				array(
   					'key' => 'field_5fcbd19401e1c',
   					'label' => 'Attr Value',
   					'name' => 'attr_value',
   					'type' => 'text',
   					'instructions' => '',
   					'required' => 0,
   					'conditional_logic' => 0,
   					'wrapper' => array(
   						'width' => '',
   						'class' => '',
   						'id' => '',
   					),
   					'default_value' => '',
   					'placeholder' => '',
   					'prepend' => '',
   					'append' => '',
   					'maxlength' => '',
   				),
   			),
   		),
   	),
   	'location' => array(
   		array(
   			array(
   				'param' => 'block',
   				'operator' => '==',
   				'value' => 'acf/button-block',
   			),
   		),
   	),
   	'menu_order' => 0,
   	'position' => 'normal',
   	'style' => 'default',
   	'label_placement' => 'top',
   	'instruction_placement' => 'label',
   	'hide_on_screen' => '',
   	'active' => true,
   	'description' => '',
   ));

   endif;
endif;
