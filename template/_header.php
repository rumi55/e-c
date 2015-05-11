<?php

$objCatalogue = new Catalogue();
$cats = $objCatalogue->getAllCategories();


$objBusiness = new Business();
$business = $objBusiness->getBusiness();

?>
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

    <link rel="stylesheet" href="assets/css/templates/foundation.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <script src="assets/js/modernizr.js"></script>
  </head>
  <body>
    

<div class="row">
  <div class="large-12 columns">
    <!-- Navigation -->

    <div class="row">
      <div class="large-12 columns">
        <nav class="top-bar" data-topbar>
          <ul class="title-area ul_list">
            <!-- Title Area -->

            <li class="name">
              <h1><a href="index.php">Emri kompanise</a></h1>
            </li>

            <li class="right">
              <?php
              if (Login::isLogged(Login::$_login_front)) {
                echo '<div id="logged_as">Logged as: <strong>';
                echo Login::getFullNameFront(Session::getSession(Login::$_login_front));
                echo '</strong> | <a href="?page=orders">My Order</a>';
                echo ' | <a href="?page=logout">Logout</a></div>';
              } else {
                echo '<div id="loged_as"><a href="?page=login">Log in</a>';
              }

              ?>
            </li>

            <li class="toggle-topbar menu-icon">
              <a href="#"><span>menu</span></a>
            </li>
          </ul>

         
        </nav><!-- End Top Bar -->
      </div>
    </div><!-- End Navigation -->

    <div class="row">
      <!-- Side Bar -->

      <div class="large-4 small-12 columns">
        <img src="http://placehold.it/500x500&amp;text=Logo">

        <div class="hide-for-small panel">
          <h3><?php echo $business['name']; ?></h3>

          <?php  if(!empty($cats))  { ?>
          <h5 class="subheader">Kategorite:
              <ul class="categories">
               
                <?php   foreach ($cats as $cat) 
                   {
                       echo "<li><a href=\"
                    ?page=catalogue&amp;category=".$cat['id']."\"";
                       echo Helper::getActive(array('category'=>$cat['id']));
                       echo ">";
                       echo Helper::encodeHTML($cat['name']);
                       echo "</a></li>";
                       
                   }
                ?>
                </ul>
              <?php } ?>
              
          </h5>
        </div><a href="#">
        <div class="panel callout radius">
          <?php require_once('shporta.php'); ?>
        </div></a>
      </div><!-- End Side Bar -->
   


     <?php
     $page= Url::getParam('page');
     if (empty($page))
     {
        require_once('content.php');
     }
     ?>
   
