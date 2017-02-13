<?php
/**
 * Copyright © 2015 Inchoo d.o.o.
 * created by Zoran Salamun(zoran.salamun@inchoo.net)
 */
namespace Gradus\Importer\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $context->getObjectManager()->get("Magento\Framework\Controller\ResultFactory");
    }

    public function execute()
    {
        exec('php shell/import/features.php');
        $resultPageFactory = $this->resultPageFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultPageFactory->setUrl($this->_redirect->getRefererUrl());

        return $resultPageFactory;
    }
}