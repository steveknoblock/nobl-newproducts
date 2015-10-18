<?php 

     class Nobl_Newproducts_IndexController extends Mage_Core_Controller_Front_Action{
		public function indexAction()
                    {		
                        $this->loadLayout();

                        /* Alan Storm debug block
                        $block = $this->getLayout()->createBlock('id/action');
						var_dump($block);
						{
						    $block->setTemplate('example/newproducts/exampleblock.phtml');
						    var_dump($block->toHtml());   
						}    
						*/

                        $this->renderLayout();
                    }
}