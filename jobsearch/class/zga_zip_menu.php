<?php


class zga_zip_menu
{
    function zga_zip_menus()
    {
        add_menu_page(
            __('zga Job', 'zga_zip_table_analysis'),
            __('zga Job', 'zga_zip_table_analysis'),
            'activate_plugins',
            'advanced-mailchimp-reports',
            'zga_zip_dashboard',
            'dashicons-dashboard'
            );
        // add new will be described in next part
        add_submenu_page(
            'advanced-mailchimp-reports',
            __('Tools', 'zga_zip_table_analysis'),
            __('Tools', 'zga_zip_table_analysis'),
            'activate_plugins',
            'reports_tools_form',
            'zga_zip_setting'
            );
    }
    
    function zga_zip_register(){
        add_action('admin_menu',array($this,'zga_zip_menus'));
    }
}

