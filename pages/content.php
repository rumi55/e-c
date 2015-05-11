 <div class="large-8 columns">
        <div class="row">
          
          <?php 

              $objCatalogue = new Catalogue();
              $products = $objCatalogue->getAllProducts(12);

              if(!empty($products))
              {
                  foreach ($products as $product) 
                  {


                      $image = !empty($product['image']) ?

                      $objCatalogue->_path.$product['image'] :
                   
                         $objCatalogue->_path.'unavailable.png';
            
                      $width = Helper::getImageSize($image,0);
                      $width = $width>120 ? 120 : $width;
                      $height = Helper::getImageSize($image,1);
                      $height = $height>150 ? 150 : $height;

                    ?>
                    <div class="large-4 small-6 columns">
                      <a href="?page=catalogue-item&amp;category=<?php echo $product['category']; ?>
               &amp;id=<?php echo $product['id']; ?>">
                      <image src="<?php echo $image; ?>" alt="<?php echo Helper::encodeHTML($product['name'],1) ?>"
                   width ="<?php echo $width; ?>" height="<?php echo $height; ?>"/></a>

                      <div class="panel">
                        <h5> <a href="?page=catalogue-item&amp;category=<?php echo $product['id']; ?>
           &amp;id=<?php echo $product['id']; ?>"><?php echo Helper::shortenString(Helper::encodeHTML($product['name'],1),15); ?></a></h5>

                        <h6 class="subheader"><?php echo Catalogue::$_currency; echo number_format($product['price'],2); ?></h6>
                      </div>
                    </div>

                    <?php
                  }
              } else {
                echo "Nuk ka produkte per momentin";
              }
          ?>
          

        

         
        </div>
      </div>