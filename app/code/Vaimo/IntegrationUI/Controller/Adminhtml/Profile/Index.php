<?php
namespace Vaimo\IntegrationUI\Controller\Adminhtml\Profile;

use Magento\Framework\Controller\ResultFactory;
class Index extends \Vaimo\IntegrationUI\Controller\Adminhtml\Profile
{
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Integration Profiles'));
        return $resultPage;
    }
}