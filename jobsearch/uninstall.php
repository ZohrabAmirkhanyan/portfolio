<?php
/**
 * Created by PhpStorm.
 * User: Zohrab
 * Date: 23.01.2020
 * Time: 1:40
 */

if (! defined('WP_UNINSTALL_PLUGIN')){
    die;
}

// Access the database via SQL
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'book'");