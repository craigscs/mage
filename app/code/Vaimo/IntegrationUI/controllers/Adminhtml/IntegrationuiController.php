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

class Vaimo_IntegrationUI_Adminhtml_IntegrationuiController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        try {
            $this->_title($this->__('Integration UI'))
                ->loadLayout()
                ->_setActiveMenu('icommerce/integrationui');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/dashboard');
        }

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('integrationui/adminhtml_profile'));
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->_initAction();
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('integrationui/profile');
        $model->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('integrationui_profile_data', $model);

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('integrationui/adminhtml_profile_edit'))
                ->_addLeft($this->getLayout()->createBlock('integrationui/adminhtml_profile_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('integrationui')->__('Record does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('integrationui/profile');

            $model->setName($this->getRequest()->getParam('name'));
            $model->setProcess($this->getRequest()->getParam('process'));
            $model->setApproach($this->getRequest()->getParam('approach'));
            $model->setEvent($this->getRequest()->getParam('event'));
            $model->setStatus($this->getRequest()->getParam('status'));
            $model->setStatusAfter($this->getRequest()->getParam('status_after'));

            $curlInfo = $this->getRequest()->getParam('curl_info');
            $curlInfo = Mage::helper('integrationui')->makeStorableArrayFieldValue($curlInfo);
            $model->setCurlInfo($curlInfo);

            $fileInfo = $this->getRequest()->getParam('file_info');
            $fileInfo = Mage::helper('integrationui')->makeStorableArrayFieldValue($fileInfo);
            $model->setFileInfo($fileInfo);

            $soapInfo = $this->getRequest()->getParam('soap_info');
            $soapInfo = Mage::helper('integrationui')->makeStorableArrayFieldValue($soapInfo);
            $model->setSoapInfo($soapInfo);

            $defaultValues = $this->getRequest()->getParam('default_values');
            $defaultValues = Mage::helper('integrationui')->makeStorableArrayFieldValue($defaultValues);
            $model->setDefaultValues($defaultValues);

            $fieldMapping = $this->getRequest()->getParam('field_mapping');
            $updateMapping = $this->getRequest()->getParam('field_mapping');
            $prefix = $this->getRequest()->getParam('field_mapping');
            $fieldMapping = Mage::helper('integrationui')->makeStorableArrayFieldValue($fieldMapping);
            $model->setFieldMapping($fieldMapping);

            $updateMapping = Mage::helper('integrationui')->makeStorableArrayFieldValue($updateMapping,true);
            $model->setUpdateMapping($updateMapping);

            $prefix = Mage::helper('integrationui')->makeStorableArrayFieldValue($prefix,false,true);
            $model->setPrefix($prefix);

            if ($this->getRequest()->getParam('id') != '') {
                $model->setId($this->getRequest()->getParam('id'));
            }

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('integrationui')->__('Profile was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('integrationui')->__('Unable to find Profile to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('integrationui/profile');

                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('integrationui')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

}
