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
