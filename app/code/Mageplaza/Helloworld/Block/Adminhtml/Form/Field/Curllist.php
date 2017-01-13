<?php
namespace Mageplaza\Helloworld\Block\Adminhtml\Form\Field;

class CurlList extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    protected $_dbFieldRenderer;
    protected $context;

    public function __construct(\Magento\Backend\Block\Template\Context $om)
    {
        $this->context = $om;
        return parent::__construct($om);
    }


    /**
     * Retrieve dbfield column renderer
     *
     * @return Vaimo_IntegrationUI_Block_Adminhtml_Form_Field_Dbfield
     */
    protected function _getDbFieldRenderer()
    {
        if (!$this->_dbFieldRenderer) {
            $this->_dbFieldRenderer = $this->getLayout()->createBlock(
                'Mageplaza\Helloworld\Block\Adminhtml\Form\Field\Curlfield', '',
                array($this->context, 'is_render_to_js_template' => true)
            );
            $this->_dbFieldRenderer->setExtraParams('style="width:300px"');
        }
        return $this->_dbFieldRenderer;
    }

    /**
     * Prepare to render
     */
    protected function _prepareToRender()
    {
        $this->addColumn('db_field', array(
            'label' => __('Option'),
            'renderer' => $this->_getDbFieldRenderer(),
        ));
        $this->addColumn('file_field', array(
            'label' => __('Value'),
            'style' => 'width:200px',
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Option');
    }

    /**
     * Prepare existing row data object
     *
     * @param Varien_Object
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->_getDbFieldRenderer()->calcOptionHash($row->getData('db_field')),
            'selected="selected"'
        );
    }
}
