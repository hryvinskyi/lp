<?php
/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

/**
 * @var $this Mage_Core_Model_Resource_Setup
 */

$tableReviews = $this->getTable('lpreviews/reviews_items');
$this->startSetup();

$table = $this->getConnection()->addForeignKey(
    $this->getFkName(
        'lpreviews/reviews_items',
        'user_id',
        'customer/entity',
        'entity_id'
    ),
    $tableReviews,
    'user_id',
    $this->getTable('customer/entity'),
    'entity_id',
    Varien_Db_Ddl_Table::ACTION_CASCADE,
    Varien_Db_Ddl_Table::ACTION_CASCADE
);

$this->endSetup();
