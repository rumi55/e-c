<?php


$cat= Url::getParam('category');

if(empty($cat)){
    
    require_once ('error.php');
}
else {
    $objCatalogue = new Catalogue();
    $category = $objCatalogue -> getCategory($cat);

    
    if(empty($category)){
        require_once ('error.php');
    }else{
       $rows = $objCatalogue->getProducts($cat);
        
        //shfaqja e numrit te caktuar producteve per faqe
       $objPageination = new Pagination($rows,5);

       $rows = $objPageination->getRecords();


        require_once ('template/_header.php');
 ?>
 <div class="large-8 columns">
    <div class="row">
<h1>Katalogu::<?php echo $category['name']; ?></h1>

<?php
if(!empty($rows)){
   foreach ($rows as $row) {

?>


        <?php
            $image = !empty($row['image'])?

                    $objCatalogue->_path.$row['image'] :
                    $objCatalogue->_path.'unavailable.png';
            
            $width = Helper::getImageSize($image,0);
            $width = $width>120 ? 120 : $width;
            
            
        ?>
        
        <a href="?page=catalogue-item&amp;category=<?php echo $category['id']; ?>
           &amp;id=<?php echo $row['id']; ?>">
        <image src="<?php echo $image; ?>" alt="<?php echo Helper::encodeHTML($row['name'],1) ?>"
               width ="<?php echo $width; ?>" />
        </a>
           
    
    <div class="">
        <h4>
            <a href="?page=catalogue-item&amp;category=<?php echo $category['id']; ?>
           &amp;id=<?php echo $row['id']; ?>"><?php echo Helper::encodeHTML($row['name'],1); ?></a>
        </h4>
        <h4>
            Çmimi: <?php echo Catalogue::$_currency; echo number_format($row['price'],2); ?>
        </h4>
        <p><?php echo Helper::shortenString(Helper::encodeHTML($row['description'])); ?></p>
        <p><?php echo Cart::activeButton($row['id']); ?></p>

    </div>
    


<?php
    
    }

    echo $objPageination->getPagination();

 }else {

 ?>

<p>There is no products in this category</p>

 <?php
 }
    echo "</div></div>";
    require_once ('_footer.php');
    }
}
?>
