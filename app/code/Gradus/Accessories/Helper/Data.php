<?php
namespace Gradus\Accessories\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public function getProductsGridUrl()
    {
        return $this->_backendUrl->getUrl('wsproductsgrid/contacts/products', ['_current' => true]);
    }
}