<?php
namespace Vaimo\IntegrationUI\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\DataObject;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Sites extends AbstractFieldArray
{
    protected $_setRenderer;

    /**
     * Returns renderer for country element
     *
     * @return Countries
     */
    protected function _getSetRenderer()
    {
        if (!$this->_setRenderer) {
            $this->_setRenderer =  $this->getLayout()->createBlock(
                'Vaimo\IntegrationUI\Block\Adminhtml\System\Config\Form\Field\Site', '',
                ['data' => ['is_render_to_js_template' => true]]
            );
            $this->_setRenderer->setExtraParams('style="width:200px"');
        }
        return $this->_setRenderer;
    }

    /**
     * Prepare to render
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn('site', array(
            'label' => 'Web Site',
            'renderer' => $this->_getSetRenderer(),
        ));
        $this->addColumn('code', array(
            'label' => 'Code',
            'style' => 'width:150px',
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->_getSetRenderer()->calcOptionHash($row->getData('site')),
            'selected="selected"'
        );
    }
}
