<?php
/**
 * Copyright (c) 2009-2012 Vaimo AB
 *
 * Vaimo reserves all rights in the Program as delivered. The Program
 * or any portion thereof may not be reproduced in any form whatsoever without
 * the written consent of Vaimo, except as provided by licence. A licence
 * under Vaimo's rights in the Program may be available directly from
 * Vaimo.
 *
 * Disclaimer:
 * THIS NOTICE MAY NOT BE REMOVED FROM THE PROGRAM BY ANY USER THEREOF.
 * THE PROGRAM IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE PROGRAM OR THE USE OR OTHER DEALINGS
 * IN THE PROGRAM.
 *
 * @category    Vaimo
 * @package     Vaimo_IntegrationUI
 * @copyright   Copyright (c) 2009-2012 Vaimo AB
 * @author      Urmo Schmidt
 */

namespace Mageplaza\HelloWorld\Block\Adminhtml\Form\Field;

class Fieldmapping extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    protected $_dbFieldRenderer;
    protected $_yesnoRenderer;
    protected $_prefixRenderer;
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
                'Mageplaza\Helloworld\Block\Adminhtml\Form\Field\DbField', '',
                array($this->context, 'is_render_to_js_template' => true)
            );
            //            $this->_dbFieldRenderer->setClass('customer_group_select');
            $this->_dbFieldRenderer->setExtraParams('style="width:300px"');
        }
        return $this->_dbFieldRenderer;
    }

    protected function _getYesnoRenderer()
    {
        if (!$this->_yesnoRenderer) {
            $this->_yesnoRenderer = $this->getLayout()->createBlock(
                'Mageplaza\HelloWorld\Block\Adminhtml\Form\Field\YesNo', '',
                array($this->context, 'is_render_to_js_template' => true)
            );
            $this->_yesnoRenderer->setClass('yesno_select');
            $this->_yesnoRenderer->setExtraParams('style="width:60px"');
        }
        return $this->_yesnoRenderer;
    }

    protected function _getPrefixRenderer()
    {
        if (!$this->_prefixRenderer) {
            $this->_prefixRenderer = $this->getLayout()->createBlock(
                'Mageplaza\HelloWorld\Block\Adminhtml\Form\Field\DbField', '',
                array($this->context, 'is_render_to_js_template' => true)
            );
            $this->_prefixRenderer->setExtraParams('style="width:100px"');
        }
        return $this->_prefixRenderer;
    }

    /**
     * Prepare to render
     */
    protected function _prepareToRender()
    {
        $this->addColumn('db_field', array(
            'label' => __('In Database'),
            'renderer' => $this->_getDbFieldRenderer(),
        ));
        $this->addColumn('file_field', array(
            'label' => __('In File'),
            'style' => 'width:126px',
        ));
        $this->addColumn('new', array(
            'label' => __('New Only'),
            'renderer' => $this->_getYesnoRenderer(),
        ));
        $this->addColumn('prefix', array(
            'label' => __('Prefix'),
            'renderer' => $this->_getPrefixRenderer(),
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Field Mapping');
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
        $row->setData(
            'option_extra_attr_' . $this->_getYesnoRenderer()->calcOptionHash($row->getData('new')),
            'selected="selected"'
        );
        $row->setData(
            'option_extra_attr_' . $this->_getPrefixRenderer()->calcOptionHash($row->getData('prefix')),
            'selected="selected"'
        );
    }
}
