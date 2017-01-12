<?php
namespace Vaimo\IntegrationUI\Block\Adminhtml\Affiliate;

class Grid extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Vaimo_IntegrationUI';
        $this->_controller = 'vaimo_integrationui';
        $this->_headerText = __('Integration Profiles');
        $this->_addButtonLabel = __('Add New Profile');
        var_dump("SDFFSDS"); die();
        parent::_construct();
        $this->buttonList->add(
            'affiliate_apply',
            [
                'label' => __('Profile'),
                'onclick' => "location.href='" . $this->getUrl('affiliate/*/applyAffiliate') . "'",
                'class' => 'apply'
            ]
        );
    }
}