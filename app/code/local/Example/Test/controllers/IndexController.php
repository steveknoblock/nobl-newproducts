<?php 
     class Example_Test_IndexController extends Mage_Core_Controller_Front_Action{
		public function indexAction()
                    {		
                        $this->loadLayout();

                        /* Alan Storm debug block
                        $block = $this->getLayout()->createBlock('id/action');
						var_dump($block);
						{
						    $block->setTemplate('example/test/exampleblock.phtml');
						    var_dump($block->toHtml());   
						}    
						*/

                        $this->renderLayout();
                    }
}