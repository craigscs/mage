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

/** @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn(
    $installer->getTable('integrationui/profile'),
    'curl_info',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'unsigned'  => false,
        'nullable'  => true,
        'comment'   => 'cURL Info'
    )
);

$installer->getConnection()->addColumn(
    $installer->getTable('integrationui/profile'),
    'status',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'unsigned'  => false,
        'nullable'  => true,
        'comment'   => 'Status'
    )
);

$installer->getConnection()->addColumn(
    $installer->getTable('integrationui/profile'),
    'status_after',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'unsigned'  => false,
        'nullable'  => true,
        'comment'   => 'Status After'
    )
);

$definition = "varchar(100) DEFAULT NULL COMMENT 'Approach'";
$installer->getConnection()->addColumn($installer->getTable('integrationui/profile'), 'approach', $definition);

$definition = "varchar(100) DEFAULT NULL COMMENT 'Event'";
$installer->getConnection()->addColumn($installer->getTable('integrationui/profile'), 'event', $definition);

$table = $installer->getConnection()
    ->newTable($installer->getTable('integrationui/order_status'))
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    'identity'  => true,
    'unsigned'  => true,
    'nullable'  => false,
    'primary'   => true,
), 'Order Id')
    ->addColumn('integration_status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Integration Status')
    ->addForeignKey(
    $installer->getFkName(
        'integrationui/order_status',
        'order_id',
        'sales/order',
        'entity_id'),
    'order_id', $installer->getTable('sales/order'), 'entity_id',
    Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Integration Order Status')
;

$installer->getConnection()->createTable($table);

$installer->endSetup();
