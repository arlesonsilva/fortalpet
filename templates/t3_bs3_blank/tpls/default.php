<?php
/** 
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org 
 *------------------------------------------------------------------------------
 */


defined('_JEXEC') or die;
?>
<?php
if($this->getParam('responsive', 1)){
$pageclass_noresp = 'resp';}else {$pageclass_noresp = 'noresp ';}

?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" class='<jdoc:include type="pageclass" />'>
  <head>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/jquery-migrate.min.js"></script>
  	<link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <jdoc:include type="head" />
    <?php $this->loadBlock ('head') ?>
  </head>
  <body class="<?php echo $pageclass_noresp;?>">
  <div class="t3-wrapper"> <!-- Need this wrapper for off-canvas menu. Remove if you don't use of-canvas -->

  <div class="boxed">
      <div class="top-block">
       	 <?php $this->loadBlock ('topheader') ?>
       	 <?php $this->loadBlock ('header') ?>
       		 <?php $this->loadBlock ('mainnav') ?>
       </div>
       <div class="center-block">
       		 <?php $this->loadBlock ('slider') ?>
             <?php $this->loadBlock ('social_slider') ?>
       		 <?php $this->loadBlock ('breadcrumbs') ?>
			 <?php $this->loadBlock ('spotlight-1') ?>
    	<div class="MainRow">
       		 <?php $this->loadBlock ('mainbody') ?>
        </div>
       		 <?php $this->loadBlock ('spotlight-2') ?>
        
       		 <?php $this->loadBlock ('brand') ?>
        </div>
        <div class="bottom-block">
       		 <?php $this->loadBlock ('footer') ?>
         </div>
    </div>
    </div>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/allscripts.js"></script>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/linescript.js"></script>
  </body>
</html>