<?php 
/**
 * Mini Framework
 */
include_once "classes/Page.php";
 $ma_page = new Page();

 $ma_page->setDossierController("controller/");
 $ma_page->setTheme("html5up-stellar");
//  $ma_page->setTemplate("catalogue");

 $ma_page->prepare();

 echo $ma_page;