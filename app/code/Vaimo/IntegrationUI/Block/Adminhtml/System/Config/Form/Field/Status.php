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
 * @package     [module]
 * @copyright   Copyright (c) 2009-2013 Vaimo AB
 * @author      Raivo Balins
 */

namespace Vaimo\IntegrationUI\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\DataObject;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Status extends AbstractFieldArray
{
    protected $_codeRenderer;

    /**
     * Retrieve dbfield column renderer
     *
     * @return Vaimo_IntegrationUI_Block_Adminhtml_Form_Field_Dbfield
     */
    protected function _getCodeRenderer()
    {
        if (!$this->_codeRenderer) {
            $this->_codeRenderer = $this->getLayout()->createBlock(
                'Vaimo\IntegrationUI\Block\Adminhtml\System\Config\Form\Field\Code', '',
                array('is_render_to_js_template' => true)
            );
            $this->_codeRenderer->setExtraParams('style="width:100px"');
        }
        return $this->_codeRenderer;
    }

    protected function _prepareToRender()
    {
        $this->addColumn('code', array(
            'label' => 'State',
            'renderer' => $this->_getCodeRenderer(),
        ));
        $this->addColumn('status', array(
            'label' => 'Status',
            'style' => 'width:200px',
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = 'Add';
    }

    /**
     * Prepare existing row data object
     *
     * @param Varien_Object
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->_getCodeRenderer()->calcOptionHash($row->getData('code')),
            'selected="selected"'
        );
    }
}
