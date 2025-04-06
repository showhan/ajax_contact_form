<?php

// Shortcode [form_entry_display] support
function form_entry_display_shortcode($atts, $content=null){
	extract( $atts = shortcode_atts(
		array(
			'block_title' 			=> __('Form Entries', SF_TEXT_DOMAIN),
			), $atts, 'form_entry_display' ) );
	ob_start();
?> 	

    <?php 
        $current_user = wp_get_current_user();
        $current_user_roles = $current_user->roles;
        $admin = false;
        if(in_array('administrator', $current_user_roles)) {
            $admin = true;
        }
    ?>

    <div class="sf-entry-table-box">

    	<h2 class="entry-table-title"><?php echo _e($block_title); ?></h2>

	    <?php if($admin) : ?>

			<?php  
				global $wpdb;
			    $posts_per_page = get_option('posts_per_page');
			    $page = 1;
				$offset = ( $page * $posts_per_page ) - $posts_per_page;
				$table_name = $wpdb->prefix . "sf_entry";
			    $retrieve_total_data = $wpdb->get_results( "SELECT * FROM $table_name" );
			    $retrieve_partial_data = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY time LIMIT {$offset}, {$posts_per_page}" );
			    $retrieve_total_data_count = count($retrieve_total_data);
			?>

			<?php if($retrieve_partial_data) : ?>
				<table class="sf-entry-table">
					<tr class="sf-table-heading">
						<th><?php _e('First Name', SF_TEXT_DOMAIN ); ?></th>
						<th><?php _e('Last Name', SF_TEXT_DOMAIN ); ?></th>
						<th><?php _e('Email', SF_TEXT_DOMAIN ); ?></th>
						<th><?php _e('Subject', SF_TEXT_DOMAIN ); ?></th>
						<th><?php _e('Message', SF_TEXT_DOMAIN ); ?></th>
					</tr>
					<?php foreach($retrieve_partial_data as $single_column) : ?>
						<tr>
							<td><?php echo $single_column->sf_fname; ?></td>
							<td><?php echo $single_column->sf_lname; ?></td>
							<td><?php echo $single_column->sf_email; ?></td>
							<td><?php echo $single_column->sf_subject; ?></td>
							<td><?php echo $single_column->sf_message;; ?></td>
						</tr>
					<?php endforeach; ?>
				</table>

				<?php  
					echo '<div class="sf_pagination">';
					echo paginate_links( array(
						'base' => add_query_arg( '?sf_page', '%#%' ),
						'format' => '',
						'prev_text' => __('&laquo;', SF_TEXT_DOMAIN ),
						'next_text' => __('&raquo;', SF_TEXT_DOMAIN ),
						'total' => ceil($retrieve_total_data_count / $posts_per_page),
						'current' => $page,
						'mid_size'  => 2,
					));
					echo '</div>';
				?>
			<?php endif; ?>

		<?php else: ?>
			<h4 style="text-align: center;">Sorry! You're not authorized to view this content. Only admin users can view the entries.</h4>
		<?php endif; ?>

	</div>

<?php
	return ob_get_clean();
}
add_shortcode('form_entry_display', 'form_entry_display_shortcode');

// Form entries AJAX request
function sf_form_entry_display_ajax_request(){

    $res = new stdClass;
    $res->post = $_POST;
    $res->error = false;
    $res->error_text = '';
    ob_start();

	global $wpdb;
    $posts_per_page = get_option('posts_per_page');
	$page = $_POST['page'];
	$offset = ( $page * $posts_per_page ) - $posts_per_page;
	$table_name = $wpdb->prefix . "sf_entry";
    $retrieve_total_data = $wpdb->get_results( "SELECT * FROM $table_name" );
    $retrieve_partial_data = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY time LIMIT {$offset}, {$posts_per_page}" );
    $retrieve_total_data_count = count($retrieve_total_data);
	?>

	<?php if($retrieve_partial_data) : ?>
		<?php foreach($retrieve_partial_data as $single_column) : ?>
			<tr>
				<td><?php echo $single_column->sf_fname; ?></td>
				<td><?php echo $single_column->sf_lname; ?></td>
				<td><?php echo $single_column->sf_email; ?></td>
				<td><?php echo $single_column->sf_subject; ?></td>
				<td><?php echo $single_column->sf_message;; ?></td>
			</tr>
		<?php endforeach; ?>

	<?php
		$pagination_text = '';
		$pagination_text .= paginate_links( array(
			'base' => add_query_arg( '?sf_page', '%#%' ),
			'format' => '',
			'prev_text' => __('&laquo;', SF_TEXT_DOMAIN ),
			'next_text' => __('&raquo;', SF_TEXT_DOMAIN ),
			'total' => ceil($retrieve_total_data_count / $posts_per_page),
			'current' => $page,
			'mid_size'  => 2,
		));
	?>

	<?php endif;

	$res->pagination_text = $pagination_text;
	$res->res = ob_get_clean();
	echo json_encode( $res );

    die();
}
add_action('wp_ajax_simple-form-entry-display', 'sf_form_entry_display_ajax_request'); 
add_action('wp_ajax_nopriv_simple-form-entry-display', 'sf_form_entry_display_ajax_request');