<?php

function form_ajax_submission(){

    $res = new stdClass;
    $res->post = $_POST;
    $res->error = false;
    $res->error_text = '';
    ob_start();

	global $wpdb;
    $fieldsInfo = $_POST['fieldsInfo'];

    $sf_fname = $fieldsInfo['fname'];
    $sf_lname = $fieldsInfo['lname'];
    $sf_email = $fieldsInfo['email'];
    $sf_subject = $fieldsInfo['subject'];
    $sf_message = $fieldsInfo['message'];

    $sf_mail_body = get_option('sf_mail_body');
    $sf_mail_success_msg = get_option('sf_mail_success_msg');

    $table_name = $wpdb->prefix . 'sf_entry';
    
    $latest_column_info = $wpdb->insert( 
        $table_name, 
        array( 
            'time' => current_time( 'mysql' ),
            'sf_fname' => $sf_fname, 
            'sf_lname' => $sf_lname, 
            'sf_email' => $sf_email, 
            'sf_subject' => $sf_subject, 
            'sf_message' => $sf_message
        ) 
    );

    if($latest_column_info) {

        $formatted_mail_body = sprintf_custom_value( $sf_mail_body,
            array(
                'firstName'   => $sf_fname,
                'lastName'   => $sf_lname,
                'email'   => $sf_email,
                'subject'   => $sf_subject,
                'message'   => $sf_message,
            )
        );

        $sender_email = $sf_email;
        $res->success_msg = __($sf_mail_success_msg ? $sf_mail_success_msg : 'Thank you for your submission!', SF_TEXT_DOMAIN);
        mail_sending($sender_email, $formatted_mail_body);
    }

	$res->res = ob_get_clean();
	echo json_encode( $res );

    die();
}
add_action('wp_ajax_simple-form-entry-submission', 'form_ajax_submission'); 
add_action('wp_ajax_nopriv_simple-form-entry-submission', 'form_ajax_submission');


// Send mail to mailchimp subscriber email address
function mail_sending($sender_email, $mail_body){

    $http_host = str_replace( 'www.', '', $_SERVER['HTTP_HOST'] );
    $mail_subject = __('Simple Contact Form', SF_TEXT_DOMAIN);
    $site_title = bloginfo('name');

    $sf_mail_address = get_option('sf_mail_address');

    $to = $sf_mail_address;
    $sender_email = $sender_email;
    $subject = $mail_subject;
    $body = $mail_body;
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = "From: {$site_title} <mail@{$http_host}>";
     
    // For admin email
    wp_mail( $to, $subject, $body, $headers );

    // For sender email
    wp_mail( $sender_email, $subject, $body, $headers );

}