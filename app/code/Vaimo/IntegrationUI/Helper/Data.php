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

class Vaimo_IntegrationUI_Helper_Data extends Mage_Core_Helper_Abstract
{
    const FILE_TYPE_CSV = 'csv';
    const FILE_TYPE_XML = 'xml';

    const APPROACH_FILE = 'file';
    const APPROACH_CURL = 'curl';
    const APPROACH_SOAP = 'soap';

    /**
     * Generate a storable representation of a value
     *
     * @param mixed $value
     * @return string
     */
    protected function _serializeValue($value)
    {
        if (is_numeric($value)) {
            $data = (float)$value;
            return (string)$data;
        } else if (is_array($value)) {
            $data = array();
            foreach ($value as $groupId => $qty) {
                if (!array_key_exists($groupId, $data)) {
                    $data[$groupId] = $qty;
                }
            }
            if (count($data) == 1 && array_key_exists(Mage_Customer_Model_Group::CUST_GROUP_ALL, $data)) {
                return (string)$data[Mage_Customer_Model_Group::CUST_GROUP_ALL];
            }
            return serialize($data);
        } else {
            return '';
        }
    }

    /**
     * Create a value from a storable representation
     *
     * @param mixed $value
     * @return array
     */
    protected function _unserializeValue($value)
    {
        if (is_numeric($value)) {
            return array(
                Mage_Customer_Model_Group::CUST_GROUP_ALL => $value
            );
        } else if (is_string($value) && !empty($value)) {
            return unserialize($value);
        } else {
            return array();
        }
    }

    /**
     * Check whether value is in form retrieved by _encodeArrayFieldValue()
     *
     * @param mixed
     * @return bool
     */
    protected function _isEncodedArrayFieldValue($value)
    {
        if (!is_array($value)) {
            return false;
        }
        unset($value['__empty']);
        foreach ($value as $_id => $row) {
            if (!is_array($row) || !array_key_exists('db_field', $row) || !array_key_exists('file_field', $row)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Encode value to be used in Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
     *
     * @param array
     * @return array
     */
    protected function _encodeArrayFieldValue(array $value,array $update,array $prefix)
    {
        $result = array();
        foreach ($value as $groupId => $qty) {
            $_id = Mage::helper('core')->uniqHash('_');
            $result[$_id] = array(
                'db_field' => $groupId,
                'file_field' => $qty,
            );
        }
        if (sizeof($update) > 0) {
            $new = array();
            foreach ($update as $groupId => $qty) {
                foreach ($result as $temp) {
                    if ($temp['db_field'] == $groupId) {
                        $_id = Mage::helper('core')->uniqHash('_');
                        $new[$_id] = array(
                            'db_field' => $temp['db_field'],
                            'file_field' => $temp['file_field'],
                            'new' => $qty,
                        );
                        break;
                    }
                }
            }
            $result = $new;
        }
        if (sizeof($prefix) > 0) {
            $new = array();
            foreach ($prefix as $groupId => $qty) {
                foreach ($result as $temp) {
                    if ($temp['db_field'] == $groupId) {
                        $_id = Mage::helper('core')->uniqHash('_');
                        $new[$_id] = array(
                            'db_field' => $temp['db_field'],
                            'file_field' => $temp['file_field'],
                            'new' => $temp['new'],
                            'prefix' => $qty,
                        );
                        break;
                    }
                }
            }
            $result = $new;
        }
        return $result;
    }

    /**
     * Decode value from used in Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
     *
     * @param array
     * @return array
     */
    protected function _decodeArrayFieldValue(array $value,$update,$prefix)
    {
        $result = array();
        unset($value['__empty']);
        foreach ($value as $_id => $row) {
            if (!is_array($row) || !array_key_exists('db_field', $row) || !array_key_exists('file_field', $row)) {
                continue;
            }
            $groupId = $row['db_field'];
            $qty = $row['file_field'];
            if ($update){
                $qty = $row['new'];
            }
            if ($prefix){
                $qty = $row['prefix'];
            }
            $result[$groupId] = $qty;
        }
        return $result;
    }

    /**
     * Make value readable by Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
     *
     * @param mixed $value
     * @return array
     */
    public function makeArrayFieldValue($value,$update = null,$prefix = null)
    {
        $value = $this->_unserializeValue($value);
        $update = $this->_unserializeValue($update);
        $prefix = $this->_unserializeValue($prefix);
        if (!$this->_isEncodedArrayFieldValue($value)) {
            $value = $this->_encodeArrayFieldValue($value,$update,$prefix);
        }
        return $value;
    }

    /**
     * Make value ready for store
     *
     * @param mixed $value
     * @return string
     */
    public function makeStorableArrayFieldValue($value,$update = false,$prefix = false)
    {
        if ($this->_isEncodedArrayFieldValue($value)) {
            $value = $this->_decodeArrayFieldValue($value,$update,$prefix);
        }
        $value = $this->_serializeValue($value);
        return $value;
    }

    public function getFileTypeOptionArray()
    {
        return array(
            self::FILE_TYPE_CSV => $this->__('CSV File'),
            self::FILE_TYPE_XML => $this->__('XML File'),
        );
    }

    public function getProcessOptionArray()
    {
        $processes = Mage::getConfig()->getNode('global/integrationui_processes')->asArray();
        $result = array();

        foreach ($processes as $code => $process) {
            $result[$code] = $process['label'];
        }

        return $result;
    }

    public function getProcessDetails($code)
    {
        $processes = Mage::getConfig()->getNode('global/integrationui_processes')->asArray();

        if (isset($processes[$code])) {
            return $processes[$code];
        } else {
            return null;
        }
    }

    public function getApproachOptionArray()
    {
        return array(
            self::APPROACH_FILE => $this->__('File'),
            self::APPROACH_CURL => $this->__('CURL'),
            self::APPROACH_SOAP => $this->__('Soap'),
        );
    }

    public static function getOrderStatusList($type = null)
    {
        $status = array();
        $items = Mage::getStoreConfig('integrationui/settings/status');
        if ($items) {
            $items = unserialize($items);
            $count = 0;
            foreach ($items as $key => $value) {
                if ($type) {
                    if ($type == $value['code'] or $value['code'] == 'completed') {
                        $status[$count] = $value['status'];
                    }
                } else {
                    $status[$count] = $value['status'];
                }
                $count ++;
            }
        }
        return $status;
    }

    public static function setIntegrationOrderStatus($orderId, $status)
    {
        $sql = "SELECT order_id FROM integrationui_order_status WHERE order_id = ?;";
        $result = Icommerce_Db::getValue($sql, $orderId);

        if ($result) {
            $sql = "UPDATE integrationui_order_status SET integration_status = ? WHERE order_id = ?;";
            Icommerce_db::getDbRead()->query($sql, array($status, $orderId));
        } else {
            $sql = "INSERT INTO integrationui_order_status (order_id, integration_status) VALUES (?, ?);";
            Icommerce_db::getDbRead()->query($sql, array($orderId, $status));
        }
    }

}
