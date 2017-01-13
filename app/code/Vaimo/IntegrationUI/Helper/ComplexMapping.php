<?php

namespace Vaimo\IntegrationUI\Helper;

class ComplexMapping extends \Magento\Framework\App\Helper\AbstractHelper
{
    // Translate magento attribute set name to attribute set id
    public function CATEGORY($attributeSetName, $magentoAttributeName)
    {
        if($magentoAttributeName != "attribute_set_id") return $attributeSetName; //This is for when single csv column is used for multiple magento attributes, but only needs to be translated for one of them.

        $attribute_set = Mage::getModel("eav/entity_attribute_set")
                            ->getCollection()
                            ->addFieldToFilter("attribute_set_name", $attributeSetName)
                            ->getFirstItem();

//        if($attrubte_set === null) throw new Exception("Can't find attribute set '{$attributeSetName}'");

        return $attribute_set->getAttributeSetId();
    }

    public function PROD_LIFE_CYCLE($value, $magentoAttributeName)
    {
        return str_replace(')', "", $value);
    }

    public function BRAND($brandName, $magentoAttributeName)
    {
        if($magentoAttributeName != "website_id") return $brandName; //This is for when single csv column is used for multiple magento attributes, but only needs to be translated for one of them.

        $site_id = Mage::getResourceModel('core/website_collection')
                    ->addFieldToFilter('name', strtolower($brandName))
                    ->getFirstItem()
                    ->getWebsiteId();

        return array($site_id);
    }

}
