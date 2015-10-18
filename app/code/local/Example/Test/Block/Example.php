<?php

class Example_Test_Block_Example extends Mage_Core_Block_Template {

public function getNewProductsList($skuList) {
        
        //var_dump($skuList);

/*
        if(!is_array($skuList)) {
            $skuList = array();
        }
*/
        $productIds = explode(',', $skuList);
        //var_dump($productIds);


        $collection = Mage::getResourceModel('catalog/product_collection')
        ->addAttributeToSelect('*')
        ->addAttributeToFilter(
        'sku', array('in' => $productIds)
    )
    ->addMinimalPrice()
    ->addTaxPercents()
    ->addStoreFilter(); 

    //var_dump($collection);

    Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
    Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);

// set pagination
$collection->setPageSize(5);

echo "Breakpoint";
foreach ($collection as $product) {
    var_dump($product);
}

return $collection;


    }
	public function getNewProducts() {
		
		$today  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
        $collection = Mage::getResourceModel('catalog/product_collection')
                            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                            ->addAttributeToSelect('*') //Need this so products show up correctly in product listing
                            ->addAttributeToFilter('news_from_date', array('or'=> array(
                                0 => array('date' => true, 'to' => $today),
                                1 => array('is' => new Zend_Db_Expr('null')))
                            ), 'left')
                            ->addAttributeToFilter('news_to_date', array('or'=> array(
                                0 => array('date' => true, 'from' => $today),
                                1 => array('is' => new Zend_Db_Expr('null')))
                            ), 'left')
                            ->addAttributeToFilter(
                                array(
                                    array('attribute' => 'news_from_date', 'is'=>new Zend_Db_Expr('not null')),
                                    array('attribute' => 'news_to_date', 'is'=>new Zend_Db_Expr('not null'))
                                    )
                              )
                            ->addAttributeToSort('news_from_date', 'desc')
                            ->addMinimalPrice()
                            ->addTaxPercents()
                            ->addStoreFilter(); 


                            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        					Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);

        					// set pagination
        					$collection->setPageSize(5);
                            //var_dump($collection);
                            foreach ($collection as $product) {
    var_dump($product);
}
die("Breakpoint");
        					return $collection;
	}
                                                                                                                                                                                                                                                                                                                          
}
