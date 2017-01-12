<?php
/**
 * Copyright (c) 2009-2013 Vaimo AB
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
 * @copyright   Copyright (c) 2009-2013 Vaimo AB
 * @author      Raivo Balins
 */

namespace Vaimo\IntegrationUI\Block\Adminhtml\System\Config\Form\Field;

class Statues extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    protected $_setRenderer;

    /**
     * Retrieve dbfield column renderer
     *
     * @return Vaimo_IntegrationUI_Block_Adminhtml_Form_Field_Dbfield
     */
    protected function _getSetRenderer()
    {
        if (!$this->_setRenderer) {
            $this->_setRenderer = Mage::getModel('core/layout')->createBlock(
                'integrationui/adminhtml_system_config_form_field_stat', '',
                array('is_render_to_js_template' => true)
            );
            $this->_setRenderer->setExtraParams('style="width:100px"');
        }
        return $this->_setRenderer;
    }

    /**
     * Prepare to render
     */
    public function __construct()
    {
        $this->addColumn('stat', array(
            'label' => Mage::helper('integrationui')->__('Product Status'),
            'renderer' => $this->_getSetRenderer(),
        ));
        $this->addColumn('code', array(
            'label' => Mage::helper('integrationui')->__('Code'),
            'style' => 'width:200px',
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('integrationui')->__('Add');
        parent::__construct();
    }

    /**
     * Prepare existing row data object
     *
     * @param Varien_Object
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->_getSetRenderer()->calcOptionHash($row->getData('stat')),
            'selected="selected"'
        );
    }
}
