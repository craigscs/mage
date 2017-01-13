<?php
namespace Vaimo\IntegrationUI\Block\Adminhtml;

class Profile extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_profile';
        $this->_blockGroup = 'Vaimo_IntegrationUI';
        $this->_headerText = __('Profile');
        $this->_addButtonLabel = __('Create New Profile');
        parent::_construct();
    }
}
