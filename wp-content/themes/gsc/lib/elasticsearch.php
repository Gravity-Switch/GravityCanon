<?php

// create acf field for dumping synonym words etc, then hook it up here.
// another idea: pull from  https://www.datamuse.com/api/ in bits and pieces on post save
function custom_elastic_query($query) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ($query->is_search) {
		$field_keys = [];
		if (function_exists("acf_get_field_groups")) {
			$field_groups = acf_get_field_groups();
			foreach ( $field_groups as $group ) {
				$fields = get_posts(array(
					'posts_per_page'   => -1,
					'post_type'        => 'acf-field',
					'orderby'          => 'menu_order',
					'order'            => 'ASC',
					'suppress_filters' => true, // DO NOT allow WPML to modify the query
					'post_parent'      => $group['ID'],
					'post_status'      => 'any',
					'update_post_meta_cache' => false
				));
				foreach ( $fields as $field ) {
					$field_keys[]= $field->post_name;
				}
			}
			$field_keys[]= 'helpful-pro';
		}

		$query->set('search_fields', [
        'post_title', 'post_content',
        'meta' => $field_keys]);
    }
  }
}
add_action('pre_get_posts','custom_elastic_query',1);
