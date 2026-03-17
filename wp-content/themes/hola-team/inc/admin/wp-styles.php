<?php

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //

//  This file creates any custom functions used for the WordPress backend.
//
//  [_1_] Login Styles
//  [_2_] Admin Styles

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_1_] Login Styles  //

//  The below function adds a stylesheet to the wp login page for styling customisation  //

function my_login_stylesheet()
{

    //  Register Log In Page Styles File  //
    wp_enqueue_style('custom-login', get_template_directory_uri() . '/assets/admin/login.css', '', null, '');

    //  Enqueue Log In Styles  //
    wp_enqueue_style('custom-login');

}
add_action('login_enqueue_scripts', 'my_login_stylesheet');


//  [_2_] Admin Styles  //

//  The below function adds a stylesheet to the wp backend for styling customisation  //

function my_admin_stylesheet()
{

    //  Register Admin Styles File  //
    wp_enqueue_style('custom-admin', get_template_directory_uri() . '/assets/admin/admin.css?v=1', '', null, '');

    //  Enqueue Admin Styles  //
    wp_enqueue_style('custom-admin');

}
add_action('wp_before_admin_bar_render', 'my_admin_stylesheet');

