<?php

function sf_entry_table_create() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'sf_entry';
    
    $charset_collate = $wpdb->get_charset_collate();

    // Create Customer Table if not exist
    if( $wpdb->get_var( "show tables like '$table_name'" ) != $table_name ) {

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            sf_fname text DEFAULT '' NOT NULL,
            sf_lname text DEFAULT '' NOT NULL,
            sf_email text DEFAULT '' NOT NULL,
            sf_subject text DEFAULT '' NOT NULL,
            sf_message text DEFAULT '' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        // Include Upgrade Script
        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

        // Create Table
        dbDelta( $sql );

    }

}