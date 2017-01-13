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

namespace Vaimo\IntegrationUI\Model\Resource;

class Profile extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('profile', 'profile_id');
    }

    protected function _beforeSave(	\Magento\Framework\Model\AbstractModel $object)
    {
        if (!$object->getId()) {
            $object->setCreatedAt($this->formatDate(time()));
        }

        $object->setUpdatedAt($this->formatDate(time()));

        return parent::_beforeSave($object);
    }
}