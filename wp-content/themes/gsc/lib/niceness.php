<?php // make the theme feel right.  enable good core/standard plugin features, patch up holes in gutenberg/classic editor etc.

if( function_exists('acf_add_options_page') ) {
	 acf_add_options_page();
} 

add_filter('wp_editor_settings', 'gs_editor_settings');
function gs_editor_settings($settings) {
   if ( ! current_user_can('administrator') ) {
       $settings['quicktags'] = false;
       return $settings;
   } else {
       $settings['quicktags'] = true;
       return $settings;
   }
}

add_filter('default_page_template_title', function() {
  return __('Standard Interior', 'avt');
});

add_filter('use_block_editor_for_post_type', 'gs_limit_gutenberg', 10, 2);
function gs_limit_gutenberg($current_status, $post_type)
{
		// gutenberg only on standard interior pages
   if ($post_type !== 'page') return false;
		$template = get_page_template_slug(get_queried_object());
		if (!empty($template)) {
			return false;
		}
   return $current_status;
}

add_filter('admin_footer', 'gs_admin_style');
function gs_admin_style() {
	?>
	<style>
	button.components-button.components-menu-item__button.components-menu-items-choice:last-child {
	    display: none;
	}
	</style>
	<?php
}
