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

namespace Vaimo\IntegrationUI\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Context;

class Set extends \Magento\Framework\View\Element\Html\Select
{
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
//        if (!$this->getOptions()) {
//            $attributeSetCollection = new \Magento\Catalog\Model\Product\AttributeSet\Optionn();
//            var_dump($attributeSetCollection); die();
//            $options = array();
//            foreach ($attributeSetCollection as $id=>$attributeSet) {
//                if ($attributeSet->getEntityTypeId() == 4) {
//                    $options[$id] = $attributeSet->getAttributeSetName();
//                }
//            }
//
//            foreach ($options as $label => $values) {
//                $this->addOption($label, $values);
//            }
//        }
        return parent::_toHtml();
    }
}
