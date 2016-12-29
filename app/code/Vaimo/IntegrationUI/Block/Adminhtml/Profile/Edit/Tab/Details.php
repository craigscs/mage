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

class Vaimo_IntegrationUI_Block_Adminhtml_Profile_Edit_Tab_Details extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        // General
        $general = $form->addFieldset('general_form', array('legend' => $this->__('Profile Information')));

        $general->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('integrationui')->__('Name'),
            'required'  => true,
        ));

        $general->addField('process', 'select', array(
            'name'      => 'process',
            'label'     => Mage::helper('integrationui')->__('Process'),
            'required'  => false,
            'options'   => Mage::helper('integrationui')->getProcessOptionArray(),
        ));

        $general->addField('approach', 'select', array(
            'name'      => 'approach',
            'label'     => Mage::helper('integrationui')->__('Approach'),
            'required'  => false,
            'options'   => Mage::helper('integrationui')->getApproachOptionArray(),
        ));

        $general->addField('event', 'text', array(
            'name'      => 'event',
            'label'     => Mage::helper('integrationui')->__('Event'),
            'required'  => false,
        ));

        // File Information
        $fileInfo = $form->addFieldset('file_info', array('legend' => $this->__('File Information')));

        $fileInfo->addField('file_info[pattern]', 'text', array(
            'name'      => 'file_info[pattern]',
            'label'     => Mage::helper('integrationui')->__('Pattern'),
            'required'  => false,
            'comment'   => 'siin kirjeldus',
        ));

        $fileInfo->addField('file_info[done]', 'text', array(
            'name'      => 'file_info[done]',
            'label'     => Mage::helper('integrationui')->__('Imported Path'),
            'required'  => false,
        ));

        $fileInfo->addField('file_info[type]', 'select', array(
            'name'      => 'file_info[type]',
            'label'     => Mage::helper('integrationui')->__('Type'),
            'required'  => false,
            'options'   => Mage::helper('integrationui')->getFileTypeOptionArray(),
        ));

        $fileInfo->addField('file_info[delimiter]', 'text', array(
            'name'      => 'file_info[delimiter]',
            'label'     => Mage::helper('integrationui')->__('Field Delimiter'),
            'required'  => false,
        ));

        $fileInfo->addField('file_info[enclosure]', 'text', array(
            'name'      => 'file_info[enclosure]',
            'label'     => Mage::helper('integrationui')->__('Enclose Values In'),
            'required'  => false,
        ));

        // CURL Information
        $curlInfo = $form->addFieldset('curl_info', array('legend' => $this->__('CURL Information')));

        $field = $curlInfo->addField('curl_info[general]', 'text', array(
            'name'      => 'curl_info[general]',
            'label'     => Mage::helper('integrationui')->__('CURL Information'),
            'comment'   => '<b>Option:</b> CURLOPT_URL</br><b>Value:</b> https://www.example.com/',
        ));

        $fieldRenderer = Mage::getBlockSingleton('integrationui/adminhtml_form_field_curllist');
        $field->setRenderer($fieldRenderer);

        $field = $curlInfo->addField('curl_info[header]', 'text', array(
            'name'      => 'curl_info[header]',
            'label'     => Mage::helper('integrationui')->__('CURL Header'),
        ));

        $fieldRenderer = Mage::getBlockSingleton('integrationui/adminhtml_form_field_curl');
        $field->setRenderer($fieldRenderer);

        // SOAP Information
        $soapInfo = $form->addFieldset('soap_info', array('legend' => $this->__('SOAP Information')));

        $soapInfo->addField('soap_info[url]', 'text', array(
            'name'      => 'soap_info[url]',
            'label'     => Mage::helper('integrationui')->__('URL'),
        ));

        $soapInfo->addField('soap_info[method]', 'text', array(
            'name'      => 'soap_info[method]',
            'label'     => Mage::helper('integrationui')->__('Method'),
        ));

        $field = $soapInfo->addField('soap_info[parameters]', 'text', array(
            'name'      => 'soap_info[parameters]',
            'label'     => Mage::helper('integrationui')->__('Parameters'),
        ));

        $fieldRenderer = Mage::getBlockSingleton('integrationui/adminhtml_form_field_soap');
        $field->setRenderer($fieldRenderer);

        // Default Values
        $defaultValues = $form->addFieldset('default_values_form', array('legend' => $this->__('Default Values')));

        $field = $defaultValues->addField('default_values', 'text', array(
            'name'      => 'default_values',
            'label'     => Mage::helper('integrationui')->__('Default Values'),
        ));

        $fieldRenderer = Mage::getBlockSingleton('integrationui/adminhtml_form_field_defaultvalues');
        $field->setRenderer($fieldRenderer);

        // Field Mapping
        $fieldMapping = $form->addFieldset('field_mapping_form', array('legend' => $this->__('Field Mapping')));

        $fieldMapping->addField('field_mapping', 'text', array(
            'name'      => 'field_mapping',
            'label'     => Mage::helper('integrationui')->__('Field Mapping'),
        ))->setRenderer(Mage::getBlockSingleton('integrationui/adminhtml_form_field_fieldmapping'));

        $order = $form->addFieldset('order', array('legend' => $this->__('Order Export')));

        $order->addField('status', 'select', array(
            'name'      => 'status',
            'label'     => Mage::helper('integrationui')->__('Export Status'),
            'required'  => false,
            'values'   => Mage::helper('integrationui')->getOrderStatusList(),
        ));

        $order->addField('status_after', 'select', array(
            'name'      => 'status_after',
            'label'     => Mage::helper('integrationui')->__('Status After Export'),
            'required'  => false,
            'values'   => Mage::helper('integrationui')->getOrderStatusList(),
        ));

        // Set Values
        if (Mage::getSingleton('adminhtml/session')->getIntegrationuiProfileData()) {
            $data = Mage::getSingleton('adminhtml/session')->getIntegrationuiProfileData();
            Mage::getSingleton('adminhtml/session')->setIntegrationuiProfileData(null);
            $form->setValues($data);
        } elseif (Mage::registry('integrationui_profile_data')) {
            $data = Mage::registry('integrationui_profile_data')->getData();
            if (isset($data['file_info'])) {
                $fileInfo = unserialize($data['file_info']);
                foreach ($fileInfo as $key => $value) {
                    $data['file_info[' . $key . ']'] = $value;
                }
            }
            if (isset($data['curl_info'])) {
                $curlInfo = unserialize($data['curl_info']);
                foreach ($curlInfo as $key => $value) {
                    foreach ($curlInfo[$key] as $key2 => $value2){
                        if ($value2) {
                            $data['curl_info[' . $key . ']'][$key2] = $value2;
                        }
                    }
                }
            }
            if (isset($data['soap_info'])) {
                $soapInfo = unserialize($data['soap_info']);
                if ($soapInfo) {
                    foreach ($soapInfo as $key => $value) {
                        if (is_array($value)) {
                            foreach ($soapInfo[$key] as $key2 => $value2){
                                if ($value2) {
                                    $data['soap_info[' . $key . ']'][$key2] = $value2;
                                }
                            }
                        } else {
                            $data['soap_info[' . $key . ']'] = $value;
                        }
                    }
                }
            }
            if (isset($data['default_values'])) {
                $data['default_values'] = Mage::helper('integrationui')->makeArrayFieldValue($data['default_values']);
            }
            if (isset($data['field_mapping'])) {
                $data['field_mapping'] = Mage::helper('integrationui')->makeArrayFieldValue($data['field_mapping'],$data['update_mapping'],$data['prefix']);
            }
            $form->setValues($data);
        }


        return parent::_prepareForm();
    }
}