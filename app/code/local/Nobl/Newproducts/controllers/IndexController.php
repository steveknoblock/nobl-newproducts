<?php 

     class Nobl_Newproducts_IndexController extends Mage_Core_Controller_Front_Action{
		public function indexAction()
                    {		
                        $this->loadLayout();
                        
                        /* Alan Storm debug code */
                        /*
                        $block = $this->getLayout()->createBlock('newproducts/newproducts');
						var_dump($block);
						{
						    $block->setTemplate('nobl/newproducts/newproducts.phtml');
						    var_dump($block->toHtml());   
						}     
						*/

                        $this->renderLayout();
                    }
}