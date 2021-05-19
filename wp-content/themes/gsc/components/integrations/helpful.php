<?php
add_action("wp_footer", function () {
  ?>
  <script>
  jQuery(".helpful-button").addClass("btn");
  jQuery(".helpful-contra").addClass("btn--secondary");
  </script>
  <?php
});

// save helpful total score for ordering
add_action('save_post',function ($post_id) {
	make_helpful_queryable($post_id);
});
add_action( 'helpful_ajax_save_vote', function () {
	if ( isset( $_POST['post'] ) ) {
		$post_id = intval( $_POST['post'] );
		make_helpful_queryable($post_id);
	}
}, 99999, 0 );
function make_helpful_queryable($post_id){
	global $wpdb;
	$the_post = get_post($post_id);

  if ($the_post->post_type !== 'resource'){
      return;
  }
  $pro = $wpdb->get_var("SELECT COUNT(id) FROM `wp_helpful` WHERE pro > 0 AND post_id = {$post_id}");
	$contra = $wpdb->get_var("SELECT COUNT(id) FROM `wp_helpful` WHERE contra > 0 AND post_id = {$post_id}");
	$total = $pro - $contra;

	update_post_meta($post_id, "helpful-total", $total);
}
