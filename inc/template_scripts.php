<?php
/**
 * template_scripts.php
 *
 * Author: pixelcave
 *
 * All vital JS scripts are included here
 *
 */
?>

<!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL) -->
<script src="<?php echo SITEURL; ?>js/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo SITEURL; ?>js/vendor/jquery-1.11.0.min.js"%3E%3C/script%3E'));</script>

<!-- Bootstrap.js, Jquery plugins and Custom JS code -->
<script src="<?php echo SITEURL; ?>js/plugins.js"></script>
<script src="<?php echo SITEURL; ?>js/app.js"></script>
<!-- <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script> -->


<!--<script type="text/javascript" src="js/timepicker.js"></script>-->
<!--script src="js/pages/tablesDatatables.js"></script-->
<script type="text/javascript" src="<?php echo SITEURL; ?>DataTables/datatables.min.js"></script>
<script src="<?php echo SITEURL; ?>js/custom.js"></script>
<script src="<?php echo SITEURL; ?>js/jquery.validate.js"></script>
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script src="<?php echo SITEURL; ?>js/jquery-ui.min.js"></script>
<script src="<?php echo SITEURL; ?>js/vendor/bootstrap.min.js"></script>
<script>
var SITE_URL;
    $(document).ready(function(){
        SITE_URL = '<?php echo SITEURL; ?>';
    });
</script>
<script src = '<?php echo SITEURL; ?>js/neto-api.js'></script>