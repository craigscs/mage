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

namespace Vaimo\IntegrationUI\Block\Adminhtml\Form\Field;

class Dbfield extends \Magento\Framework\View\Element\Html\Select
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
        if (!$this->getOptions()) {
            $sql = "SELECT eav_entity_type.entity_type_code, eav_attribute.attribute_code, eav_attribute.frontend_label"
                . " FROM eav_attribute"
                . " JOIN eav_entity_type ON (eav_attribute.entity_type_id = eav_entity_type.entity_type_id)"
                . " ORDER BY eav_attribute.entity_type_id, eav_attribute.frontend_label";

            $query = Icommerce_Db::getRead()->query($sql);
            $options = array('' => 'null');

            foreach ($query as $row) {
                if ($row['frontend_label']) {
                    $label = $row['frontend_label'];
                    $options[$row['entity_type_code']][$row['entity_type_code'] . '.' . $row['attribute_code']] = addslashes($label);
                }
            }

            $categoryExtra = array(
                'code1' => 'Code 1',
                'name1' => 'Name 1',
                'code2' => 'Code 2',
                'name2' => 'Name 2',
                'code3' => 'Code 3',
                'name3' => 'Name 3',
                'code4' => 'Code 4',
                'name4' => 'Name 4',
            );

            foreach ($categoryExtra as $value => $label) {
                $options['catalog_category']['catalog_category.' . $value] = $label;
            }

            $productExtra = array(
                'attribute_set_id' => 'Attribute Set ID',
                'website_id' => 'Website ID',
            );

            foreach ($productExtra as $value => $label) {
                $options['catalog_product']['catalog_product.' . $value] = $label;
            }

            $productStock = array(
                'stock_id' => 'Stock ID',
                'qty' => 'Quantity',
                'min_qty' => 'Min Quantity',
                'use_config_min_qty' => 'Use Config Min Qty',
                'is_qty_decimal' => 'Qty Uses Decimals',
                'backorders' => 'Backorders',
                'use_config_backorders' => 'Use Config Backorders',
                'min_sale_qty' => 'Min Cart Qty',
                'use_config_min_sale_qty' => 'Use Config Min Cart Qty',
                'max_sale_qty' => 'Max Cart Qty',
                'use_config_max_sale_qty' => 'Use Config Max Cart Qty',
                'notify_stock_qty' => 'Notify Qty Below',
                'use_config_notify_stock_qty' => 'Use Config Notify',
                'manage_stock' => 'Manage Stock',
                'use_config_manage_stock' => 'Use Config Manage Stock',
                'enable_qty_increments' => 'Enable Qty Increments',
                'use_config_enable_qty_inc' => 'Use Config Enable Qty Increments',
            );

            foreach ($productStock as $value => $label) {
                $options['stock_item']['stock_item.' . $value] = $label;
            }

            foreach ($options as $label => $values) {
                $this->addOption($values, $label);
            }

        }
        return parent::_toHtml();
    }
}
