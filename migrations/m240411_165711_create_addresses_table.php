<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%addresses}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%customer}}`
 */
class m240411_165711_create_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%addresses}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'street' => $this->string()->notNull(),
            'zip_code' => $this->string()->notNull(),
            'number' => $this->string()->notNull(),
            'city' => $this->string()->notNull(),
            'state' => $this->string()->notNull(),
            'country' => $this->string()->notNull(),
            'complement' => $this->string(),
        ]);

        // creates index for column `customer_id`
        $this->createIndex(
            '{{%idx-addresses-customer_id}}',
            '{{%addresses}}',
            'customer_id'
        );

        // add foreign key for table `{{%customer}}`
        $this->addForeignKey(
            '{{%fk-addresses-customer_id}}',
            '{{%addresses}}',
            'customer_id',
            '{{%customers}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%customer}}`
        $this->dropForeignKey(
            '{{%fk-addresses-customer_id}}',
            '{{%addresses}}'
        );

        // drops index for column `customer_id`
        $this->dropIndex(
            '{{%idx-addresses-customer_id}}',
            '{{%addresses}}'
        );

        $this->dropTable('{{%addresses}}');
    }
}
