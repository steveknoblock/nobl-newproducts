<?php

class Nobl_Newproducts_Block_Newproducts extends Mage_Core_Block_Template {

public function getNewProductsList($skuList) {
        
        $productIds = explode(',', $skuList);
 
        $collection = Mage::getResourceModel('catalog/product_collection')
        ->addAttributeToSelect('*')
        ->addAttributeToFilter(
        'sku', array('in' => $productIds)
    )
    ->addMinimalPrice()
    ->addTaxPercents()
    ->addStoreFilter(); 

    Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
    Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);

    // set pagination
    $collection->setPageSize(5);

    return $collection;
    }


	public function getNewProducts($limit) {
		
		$today  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
        $collection = Mage::getResourceModel('catalog/product_collection')
                            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                            ->addAttributeToSelect('*')
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
		$collection->setPageSize($limit);
        
		return $collection;
	}
                                                                                                                                                                                                                                                                                                                          
}
