<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $street
 * @property string $zip_code
 * @property string $number
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $complement
 */
class Address extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'street', 'zip_code', 'number', 'city', 'state', 'country'], 'required'],
            [['customer_id'], 'integer'],
            [['street', 'zip_code', 'number', 'city', 'state', 'country', 'complement'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'street' => 'Street',
            'zip_code' => 'Zip Code',
            'number' => 'Number',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'complement' => 'Complement',
        ];
    }

    /**
     * Gets the associated Customer model.
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}