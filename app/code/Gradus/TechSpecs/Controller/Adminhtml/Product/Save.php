<?php

namespace Gradus\TechSpecs\Controller\Adminhtml\Product;

class Save extends \Magento\Catalog\Controller\Adminhtml\Product\save
{
    protected $tss;
    public function execute()
    {
        if (isset($_POST['techspec'])) {
            $ts = $_POST['techspec'];
            $tss = json_encode($ts);
            $_POST['product']['tech_specs'] = $tss;
            $this->tss = $tss;
            $this->getRequest()->setParams($_POST);
        } else {
            $this->tss = '';
        }
        return parent::execute();
    }
}