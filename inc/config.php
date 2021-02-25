<?php error_reporting(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 * config.php
 *
 * Author: pixelcave
 *
 * Configuration file. It contains variables used in the template as well as the primary navigation array from which the navigation is created
 *
 */
include 'database.php';
/* Template variables */
$template = array(
    'name'          => 'Admin',
    'version'       => '1.1',
    'author'        => 'pixelcave',
    'robots'        => 'noindex, nofollow',
    'title'         => 'Admin Dashboard',
    'description'   => 'Admin Dashboard Template',
    // 'navbar-default'         for a light header
    // 'navbar-inverse'         for a dark header
    'header_navbar' => 'navbar-default',
    // ''                       empty for a static header
    // 'navbar-fixed-top'       for a top fixed header / fixed sidebars
    // 'navbar-fixed-bottom'    for a bottom fixed header / fixed sidebars
    'header'        => '',
    // ''                                               for a full main and alternative sidebar hidden by default (> 991px)
    // 'sidebar-visible-lg'                             for a full main sidebar visible by default (> 991px)
    // 'sidebar-partial'                                for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)
    // 'sidebar-partial sidebar-visible-lg'             for a partial main sidebar which opens on mouse hover, visible by default (> 991px)
    // 'sidebar-alt-visible-lg'                         for a full alternative sidebar visible by default (> 991px)
    // 'sidebar-alt-partial'                            for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)
    // 'sidebar-alt-partial sidebar-alt-visible-lg'     for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)
    // 'sidebar-partial sidebar-alt-partial'            for both sidebars partial which open on mouse hover, hidden by default (> 991px)
    // 'sidebar-no-animations'                          add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!
    'sidebar'       => 'sidebar-partial sidebar-visible-lg sidebar-no-animations',
    // ''                       empty for a static footer
    // 'footer-fixed'           for a fixed footer
    'footer'       => '',
    // ''                       empty for default style
    // 'style-alt'              for an alternative main style (affects main page background as well as blocks style)
    'main_style'    => '',
    // 'night', 'amethyst', 'modern', 'autumn', 'flatie', 'spring', 'fancy', 'fire' or '' leave empty for the Default Blue theme
    'theme'         => '',
    // ''                       for default content in header
    // 'horizontal-menu'        for a horizontal menu in header
    // This option is just used for feature demostration and you can remove it if you like. You can keep or alter header's content in page_head.php
    'header_content'=> '',
    'active_page'   => basename($_SERVER['PHP_SELF'])
);

if(!empty($_GET['page_id'])){
    $template['active_page'] = basename($_SERVER['PHP_SELF']).'?page_id='.$_GET['page_id'];
}

/* Primary navigation array (the primary navigation will be created automatically based on this array, up to 3 levels deep) */

$primary_nav_Admin = array(
	array(
        'name'  => 'User Management',
        'url'   => 'index.php',
        'icon'  => 'gi gi-user'
    ), 
    array(
        'name'  => 'Page Content',
        'url'   => 'page_content_list.php',
        'icon'  => 'gi gi-pencil'
    ), 
    array(
        'name'  => 'Maintain Data File',
        'url'   => '#',
        'icon'  => 'gi gi-upload',
        'border'=> '1'
    ), 
    array(
        'name'  => 'eBay Vehicles MVL',
        'url'   => 'csv_uploader.php',
    ), 
    array(
        'name'  => 'eBay Motorcycles MVL',
        'url'   => 'csv_uploader_motor.php',
        // 'icon'  => 'gi gi-show_big_thumbnails'
    ), 

    array(
        'name'  => 'Model Finder',
        'url'   => '#',
        'icon'  => 'gi gi-search',
        'border'=> '1'
    ), 

	array(
        'name'  => 'eBay Vehicles',
        'url'   => 'search.php',
        // 'icon'  => 'gi gi-search'
    ), 
    array(
        'name'  => 'eBay Motorcycles',
        'url'   => 'search_motor.php',
        // 'icon'  => 'gi gi-show_big_thumbnails'
    ), 

	array(
        'name'  => 'Website Fitment',
        'url'   => 'website-fitment.php',
        'icon'  => 'gi gi-show_big_thumbnails',
        'border'=> '1'
    ), 
    
    
	array(
        'name'  => 'Logout',
        'url'   => 'logout.php',
        'icon'  => 'gi gi-exit',
        'border'=> '1'
    ),    
       
);

$primary_nav = array(
    array(
        'name'  => 'eBay Vehicles',
        'url'   => 'index.php',
        // 'icon'  => 'gi gi-search'
        'image'=>'img/car1.png'
    ), 
	array(
        'name'  => 'eBay Motorcycles',
        'url'   => 'search_motor.php',
        // 'icon'  => 'gi gi-show_big_thumbnails'
        'image'=>'img/bike1.png'
    ), 
    array(
        'name'  => 'Custom Fitment',
        'url'   => 'website-fitment.php',
        'image'=>'img/website_icon1.png'
        // 'icon'  => 'gi gi-show_big_thumbnails'
    ), 
	array(
		'name'  => 'How to push fitment to eBay',
        'url'   => 'html_data_from_db_display.php?page_id=1',
		'icon' => 'gi gi-show_big_thumbnails'
	),
	array(
		'name'  => 'Report missing vehicles',
        'url'   => 'html_data_from_db_display.php?page_id=3',
		'icon' => 'gi gi-show_big_thumbnails'
	),
	array(
		'name'  => 'ZELLIS Auto User Agreement',
        'url'   => 'html_data_from_db_display.php?page_id=2',
		'icon' => 'gi gi-show_big_thumbnails'
	),
	array(
        'name'  => 'Logout',
        'url'   => 'logout.php',
        'icon'  => 'gi gi-exit'
    ),    
       
);