<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

/**
 * @var $this Mage_Core_Model_Resource_Setup
 */
$this->startSetup();

$table = $this->getConnection()
    ->newTable($this->getTable('lpreviews/reviews_items'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ))
    ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11)
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT)
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_INTEGER, 11);

$this->getConnection()->createTable($table);

$this->endSetup();