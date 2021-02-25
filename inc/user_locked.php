<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="page-content">
            <div class="content-header">
                <div class="header-section">
                    <h1>
                        <i><img class="zlogo" src="<?php echo SITEURL; ?>img/zlogo.png"></i>Automotive Parts Fitment System<br><small></small>
                    </h1>
                </div>
            </div>
            <ul class="breadcrumb breadcrumb-top">
                <li>Dashboard</li>
            </ul>
            <div class="block blockLocked">
                <div class="row">
                    <div class="col-lg-1"><img class="locked-image" src="<?php echo SITEURL; ?>img/lock.png" alt="locked-image"></div>
                    <div class="col-lg-11"><h1 class="text-danger text-left mt-50">Your account has been locked</h1></div>
                </div>
                <br>
                <p>Payment for your monthly subscription has not been received</p>
                <p>In accordance with our <a href="<?php echo SITEURL."html_data_from_db_display.php?page_id=2"; ?>"><strong class="text-danger">user agreement</strong></a>, access to our services is temporarily locked.</p>
                <p>To unlock your account, please arrange payment of your outstanding invoice</p>
                <p>If you believe you have already paid,please <a href="javascript:void(0)"><strong class="text-danger contact-zellis">email us</strong></a> immediately with details of when and how you paid<br> so we can track it down and unlock your access</p>
                <p>if payment is not received within 7 days, your account may be deactivated permanently</p>
                <br>
                <button class="btn btn-danger contact-zellis"> Contact ZELLIS Auto </button>
            </div>
    </div>
</body>
</html>
<?php if($d_row['us_lock']){ ?>
      <script>
          $(document).ready(function(){
            $('.sidebar-nav > li > a').not('a:eq(3)').attr('href','javascript:void(0)');
          });
      </script>
<?php } ?>


