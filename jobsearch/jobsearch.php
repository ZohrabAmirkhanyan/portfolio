<?php
/**
 * Plugin Name: jobsearch
 * Description: Show results from JobSearch.
 * Version: 1.0.0
 * Author: Zohrab
 * Copyright: 2020
 */

// Exit if accessed directly
if(!defined('ABSPATH')){
	die;
}
// Define plugin constants.zga_zip_menu

defined( 'zgaZIP_DIR' ) or define( 'zgaZIP_DIR', plugin_dir_path( __FILE__ ) );
defined( 'zgaZIP_URL' ) or define( 'zgaZIP_URL', plugin_dir_url( __FILE__ ) );


// Load Class
ob_start();
include_once (zgaZIP_DIR.'class/zga_zip_menu.php');
include_once (zgaZIP_DIR.'class/zga_zip_display_dashboard.php');
include_once (zgaZIP_DIR.'class/zga_zip_api.php');
include_once (zgaZIP_DIR.'class/zga_zip_api_rss.php');

ob_clean();



class zga_job_plugin{
    function __construct(){

    }
    function activate(){

    }
    function deactivate(){

    }
    function uninstall(){

    }

}


if (class_exists('zga_job_plugin')){
    $zgaJobPlugin = new zga_job_plugin();
}

// Activate
register_activation_hook(__FILE__,array($zgaJobPlugin,'activate'));
// Deactivate
register_deactivation_hook(__FILE__,array($zgaJobPlugin,'deactivate'));





add_shortcode('zga-job-ziprecruiterasa', 'customPluginFunction');

function customPluginFunction(){
    include_once  zgaZIP_DIR.'views/shortcodestest.php';
}



/********************* Page Job ShortCode *************************/
add_shortcode("zga_page_job_list_ziprecruiter", "zga_ziprecruiter_page_jobs");

function zga_ziprecruiter_page_jobs($atts){
    
    $api_args = shortcode_atts(array(
        "search"        => "PPS",
        "location"      => "USA",
        'page'          => 1,
        'jobs_per_page' => 10,
        'radius_miles'  => 20
    ),
        $atts,
        'zga_ziprecruiter_page_jobs');
        
        
        include_once  zgaZIP_DIR.'views/shortcodes-page.php';
}


/*********************** Front Page  **************************/
add_shortcode("zga_front_page_job_list_ziprecruiter", "zga_ziprecruiter_front_page_jobs_shortcode");

function zga_ziprecruiter_front_page_jobs_shortcode($atts){
   
    $api_args = shortcode_atts(array(
        "search"        => "PPS",
        "location"      => "USA",
        'page'          => 1,
        'jobs_per_page' => 2,
        'radius_miles'  => 20
    ),
        $atts,
        'zga_ziprecruiter_front_page_jobs_shortcode');
        
        
        include_once  zgaZIP_DIR.'views/shortcodestest.php';
}



















