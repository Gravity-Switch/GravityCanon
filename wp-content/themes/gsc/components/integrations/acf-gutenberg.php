<?php
add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types() {
  // Check function function exists
  if ( function_exists('acf_register_block_type')) {

    acf_register_block_type(array (
      'name' => 'button',
      'title' => __('Button'),
      'description' => __('Rendering a GSC Button'),
      'render_template' => 'template-parts/blocks/button-block.php',
      'category' => 'layout',
      'keywords' => array('button', 'gs', 'gravity switch')
    ));
  }
}
