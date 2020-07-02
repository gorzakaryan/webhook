<?php

namespace CrmPerks\Webhook\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package CrmPerks\Webhook\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (!$installer->tableExists("crmperks_hooks")) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable("crmperks_hooks")
            )->addColumn(
                "id",
                Table::TYPE_INTEGER,
                null,
                ["identity" => true, "unsigned" => true, "nullable" => false, "primary" => true],
                "Id"
            )->addColumn(
                "name",
                Table::TYPE_TEXT,
                255,
                ["nullable" => false],
                "Hook Name"
            )->addColumn(
                "status",
                Table::TYPE_SMALLINT,
                null,
                ["nullable" => false],
                "Status"
            )->addColumn(
                "event",
                Table::TYPE_TEXT,
                255,
                ["nullable" => false],
                "Event"
            )->addColumn(
                "priority",
                Table::TYPE_INTEGER,
                11,
                [],
                "Priority"
            )->addColumn(
                "service_address",
                Table::TYPE_TEXT,
                255,
                ["nullable" => false],
                "Service URL"
            )->addColumn(
                "format",
                Table::TYPE_TEXT,
                255,
                ["nullable" => false],
                "Data Format"
            )->addColumn(
                "mapping_fields",
                Table::TYPE_TEXT,
                "2M",
                ["nullable" => false],
                "Mapping Fields"
            )->addColumn(
                "headers",
                Table::TYPE_TEXT,
                "2M",
                [],
                "Headers"
            )->addColumn(
                "created_at",
                Table::TYPE_TIMESTAMP,
                null,
                ["default" => Table::TIMESTAMP_INIT],
                "Created At"
            )->addColumn(
                "updated_at",
                Table::TYPE_TIMESTAMP,
                null,
                ["default" => Table::TIMESTAMP_INIT],
                "Update At"
            )->setComment(
                "CRM perks hooks table"
            );
            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists("crmperks_logs")) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable("crmperks_logs")
            )->addColumn(
                "id",
                Table::TYPE_INTEGER,
                null,
                ["identity" => true, "unsigned" => true, "nullable" => false, "primary" => true],
                "Id"
            )->addColumn(
                "hook_name",
                Table::TYPE_TEXT,
                255,
                ["nullable" => false],
                "Hook Name"
            )->addColumn(
                "log_status",
                Table::TYPE_TEXT,
                100,
                [],
                "Status"
            )->addColumn(
                "event",
                Table::TYPE_TEXT,
                255,
                ["nullable" => false],
                "Event"
            )->addColumn(
                "service_address",
                Table::TYPE_TEXT,
                255,
                ["nullable" => false],
                "Service URL"
            )->addColumn(
                "message",
                Table::TYPE_TEXT,
                512,
                [],
                "Message"
            )->addColumn(
                "webhook_id",
                Table::TYPE_INTEGER,
                null,
                [],
                "Webhook Id"
            )->addColumn(
                "created",
                Table::TYPE_TIMESTAMP,
                null,
                ["default" => Table::TIMESTAMP_INIT],
                "Created At"
            )->setComment(
                "CRM perks logs table"
            );
            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists("crmperks_unregistered_data")) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable("crmperks_unregistered_data")
            )->addColumn(
                "id",
                Table::TYPE_INTEGER,
                null,
                ["identity" => true, "unsigned" => true, "nullable" => false, "primary" => true],
                "ID"
            )->addColumn(
                "webhook_id",
                Table::TYPE_INTEGER,
                null,
                [],
                "Webhook Id"
            )->addColumn(
                "service_url",
                Table::TYPE_TEXT,
                255,
                ["nullable" => false],
                "Service URL"
            )->addColumn(
                "hook_data",
                Table::TYPE_TEXT,
                "2M",
                ["nullable" => false],
                "Hook Data"
            )->setComment(
                "CRM perks unregistered data table"
            );
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
