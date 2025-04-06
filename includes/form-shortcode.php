<?php 

// Shortcode [form_shortcode] support
function form_shortcode($atts, $content=null){
    
	extract( $atts = shortcode_atts(
	    array(
	        'form_title'             => __('Submit your feedback', SF_TEXT_DOMAIN),
	        ), $atts, 'form_shortcode' ) );
	ob_start();
	?>

	<div class="sf-form">
		<div class="sf-form-wrapper">

			<h2 class="form-titlte"><?php _e($form_title); ?></h2>

			<form action="">
				<div class="input-group">
					<div class="input-field">
						<label for="first-name"><?php _e('First Name', SF_TEXT_DOMAIN ); ?></label>
						<input type="text" id="first-name" class="first_name form_field">
					</div>
					<div class="input-field">
						<label for="last-name"><?php _e('Last Name', SF_TEXT_DOMAIN ); ?></label>
						<input type="text" id="last-name" class="last_name form_field">
					</div>
				</div>
				<div class="input-field">
					<label for="email"><?php _e('Email', SF_TEXT_DOMAIN ); ?></label>
					<input type="text" id="email" class="email form_field">
				</div>
				<div class="input-field">
					<label for="subject"><?php _e('Subject', SF_TEXT_DOMAIN ); ?></label>
					<input type="text" id="subject" class="subject form_field">
				</div>
				<div class="input-field">
					<label for="message"><?php _e('Message', SF_TEXT_DOMAIN ); ?></label>
					<textarea id="message" cols="30" rows="4" class="message form_field"></textarea>
				</div>
				<div class="input-field">
					<input type="submit" class="submit-btn" value="<?php _e('Submit', SF_TEXT_DOMAIN ); ?>">
				</div>
			</form>
		</div>
	</div>

<?php 
	return ob_get_clean();
}
add_shortcode('form_shortcode', 'form_shortcode');