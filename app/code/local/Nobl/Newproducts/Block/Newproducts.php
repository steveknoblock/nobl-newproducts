<?php

class Nobl_Newproducts_Block_Newproducts extends Mage_Core_Block_Template {

    public function getNewProductsList($products, $limit, $featured) {
echo "B1";
        //$products['ids'] = '410,413,418';
        //$products['skus'] = 'mtk004c,mkt012c,wbk003c';

        /*
         * Handle product entity id or sku
         */
        if($products['skus'] != '') {
            $skus = preg_replace('/\s+/', ' ', $products['skus']);
            $products = explode(',', $skus);
            $o = array();
            foreach ($products as $key=>$id) {
                $o[] = array('attribute' => 'sku', 'eq' => $id);
            }
        } elseif($products['ids'] != ''){
            $ids = preg_replace('/\s+/', ' ', $products['ids']);
            $products = explode(',', $ids);
            $o = array();
            foreach ($products as $key=>$id) {
                $o[] = array('attribute' => 'entity_id', 'eq' => $id);
            }
        }


        $collection = Mage::getResourceModel('catalog/product_collection')
        ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
        ->addFieldToFilter($o)
        ->addMinimalPrice()
        ->addTaxPercents()
        ->addStoreFilter()
        ->setPageSize($limit);  // set pagination
        
        /* Restrict to featured products */

            $eavConfig = Mage::getModel('eav/config');
            /* @var $eavConfig Mage_Eav_Model_Config */

            $attributes = $eavConfig->getEntityAttributeCodes(
                Mage_Catalog_Model_Product::ENTITY
            );
            //var_dump($attributes);
            //die('ATTR');
            if (in_array('featured',$attributes)) {
                if($featured) {
                    $collection->addAttributeToFilter('featured', 1);
                }
            }

        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);

        return $collection;
    }


    public function getNewProducts($limit, $featured) {
        echo "B2";
        // after Mage_Catalog_Block_Product_New
        $todayStartOfDayDate  = Mage::app()->getLocale()->date()
            ->setTime('00:00:00')
            ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);

        $todayEndOfDayDate  = Mage::app()->getLocale()->date()
            ->setTime('23:59:59')
            ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);

        $collection = Mage::getResourceModel('catalog/product_collection');
        $collection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());

        // after Mage_Catalog_Block_Product_Abstract
        // _addProductAttributesAndPrices
        $collection
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('news_from_date', array('or'=> array(
                    0 => array('date' => true, 'to' => $todayStartOfDayDate),
                    1 => array('is' => new Zend_Db_Expr('null')))
                ), 'left')
            ->addAttributeToFilter('news_to_date', array('or'=> array(
                    0 => array('date' => true, 'from' => $todayEndOfDayDate),
                    1 => array('is' => new Zend_Db_Expr('null')))
                ), 'left')
            ->addAttributeToFilter(
                    array(
                        array('attribute' => 'news_from_date', 'is'=>new Zend_Db_Expr('not null')),
                        array('attribute' => 'news_to_date', 'is'=>new Zend_Db_Expr('not null'))
                        )
                  )
            ->addMinimalPrice()
            //->addFinalPrice()
            ->addTaxPercents()
            ->addAttributeToSort('news_from_date', 'desc')
            ->setPageSize($limit)
            ->addStoreFilter();
            // may be unnecessary with only add to cart button visible
            // jssor does not allow clicking on image in this configuration
            //->addUrlRewrite();

            /* Restrict to featured products */

            $eavConfig = Mage::getModel('eav/config');
            /* @var $eavConfig Mage_Eav_Model_Config */

            $attributes = $eavConfig->getEntityAttributeCodes(
                Mage_Catalog_Model_Product::ENTITY
            );
            //var_dump($attributes);
            //die('ATTR');
            if (in_array('featured',$attributes)) {
                if($featured) {
                    $collection->addAttributeToFilter('featured', 1);
                }
            }


            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
            Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);

            return $collection;

    }
                                                                                                                                                                                                                                                                                                                          
}
