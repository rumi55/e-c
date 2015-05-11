
<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" data-useragent="Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tema Diplomes</title>

    
    <meta name="description" content="" />
    
    <meta name="author" content="" />
    <meta name="copyright" content="Copyright (c) 2014" />

    <link rel="stylesheet" href="../assets/css/templates/foundation.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <script src="../assets/js/modernizr.js"></script>
  </head>
  <body>
    

<div class="row">
  <div class="large-12 columns">
    <!-- Navigation -->

    <div class="row">
      <div class="large-12 columns">
        <nav class="top-bar" data-topbar>
          <ul class="title-area">
            <!-- Title Area -->

            <li class="name">
              <h1><a href="index.php">Dashboard</a></h1>
            </li>

            <li class="toggle-topbar menu-icon">
              <a href="#"><span>menu</span></a>
            </li>
          </ul>

          <section class="top-bar-section">
            <!-- Right Nav Section -->

            <ul class="right">
             <!-- linku log in -->
             <?php if(Login::isLogged(Login::$_login_admin)){ 
              echo "<li>Ju jeni kqyr si administrator</li>";
              echo '<li><a href="?page=logout">Logout</a></li>';
             } else {
                echo '<li><a href="?page=index">Login</a></li>';
             }
             
             ?>

            </ul>
          </section>
        </nav><!-- End Top Bar -->
      </div>
    </div><!-- End Navigation -->

    <div class="row">
      <!-- Side Bar -->

      <div class="large-4 small-12 columns">
        
 <?php if(Login::isLogged(Login::$_login_admin)) { ?>
        <div class="hide-for-small panel">
         
         
          
          <h5 class="subheader">Menyte:
              <ul class="categories">
                 <li>
                    <a href="?page=categories"
                    <?php echo Helper::getActive(array('page'=>'categories')); ?>>Kategorite
                  </a>
                 </li>
                  <li>
                    <a href="?page=products"
                    <?php echo Helper::getActive(array('page'=>'products')); ?>>Produktet
                  </a>
                 </li>
              </ul>
              <?php } else { ?>
              &nbsp;
              <?php } ?>
              
          </h5>
        </div>
      </div><!-- End Side Bar -->
     

    
