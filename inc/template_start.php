<?php
/**
 * template_start.php
 *
 * Author: pixelcave
 *
 * The first block of code used in every page of the template
 *
 */
?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Zellis Auto</title>

        <meta name="description" content="<?php echo $template['description'] ?>">
        <meta name="author" content="<?php echo $template['author'] ?>">
        <meta name="robots" content="<?php echo $template['robots'] ?>">

        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="<?php echo SITEURL; ?>img/favicon.ico">
        <link rel="apple-touch-icon" href="<?php echo SITEURL; ?>img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="<?php echo SITEURL; ?>img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="<?php echo SITEURL; ?>img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="<?php echo SITEURL; ?>img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="<?php echo SITEURL; ?>img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="<?php echo SITEURL; ?>img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="<?php echo SITEURL; ?>img/icon152.png" sizes="152x152">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/main.css">
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/custom.css">
		<link rel="stylesheet" href="<?php echo SITEURL; ?>mystyle.css">
        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->
        <?php if ($template['theme']) { ?><link id="theme-link" rel="stylesheet" href="<?php echo SITEURL; ?>css/themes/<?php echo $template['theme']; ?>.css"><?php } ?>

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/themes.css">
		<link rel="stylesheet" href="<?php echo SITEURL; ?>css/bootstrap-datepicker.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>DataTables/datatables.min.css"/>
        
        <!-- stylesheet for index.php -->
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/index.css">

        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support it, eg IE8) -->
        <script src="<?php echo SITEURL; ?>js/vendor/modernizr-2.7.1-respond-1.4.2.min.js"></script>
        
        <!-- datatable css -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css">
        
        <!-- jquery -->
        <script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- datatable js -->
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <!-- bootstrap glyphicons -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
        <style>
            
            thead input {
                width: 100%;
            }
            /* #page-content{
                display:flex;
                justify-content:column;
            } */
        </style>
    </head>
    <body>
        <?Php 
        $current_userid = $_SESSION['admin']['id']; 
        if($current_userid != 1) {
            echo '<style>a[href="settings.php"] { display: none; }</style>';
        }
        ?>