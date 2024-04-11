<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "customers".
 *
 * @property int $id
 * @property string $name
 * @property string $nif_number
 * @property string $photo_url
 * @property string $gender
 */
class Customer extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'nif_number', 'photo_url', 'gender'], 'required'],
            [['name', 'photo_url'], 'string', 'max' => 255],
            ['gender', 'filter', 'filter' => 'strtoupper'],
            ['gender', 'in', 'range' => ['MALE', 'FEMALE']],
            ['nif_number', 'validateNifNumber'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'nif_number' => 'NIF Number',
            'photo_url' => 'Photo URL',
            'gender' => 'Gender',
        ];
    }

    /**
     * Gets the associated Address model.
     */
    public function getAddress()
    {
        return $this->hasOne(Address::class, ['customer_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->nif_number = preg_replace('/[^0-9]/', '', $this->nif_number);

        return true;
    }

    public function validateNifNumber($attribute, $params)
    {
        $nif = preg_replace('/[^0-9]/', '', $this->$attribute);

        if (strlen($nif) == 11) {
            if (!$this->validatePersonalNif($nif)) {
                $this->addError($attribute, 'CPF inválido.');
            }
        } elseif (strlen($nif) == 14) {
            if (!$this->validateBusinessNif($nif)) {
                $this->addError($attribute, 'CNPJ inválido.');
            }
        } else {
            $this->addError($attribute, 'NIF inválido.');
        }
    }

    private function validatePersonalNif($cpf)
    {
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    private function validateBusinessNif($cnpj)
    {
        if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $t = 5;
        for ($i = 0, $d = 0; $i < 12; $i++) {
            $d += $cnpj[$i] * $t;
            $t = ($t == 2) ? 9 : $t - 1;
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cnpj[12] != $d) {
            return false;
        }

        $t = 6;
        for ($i = 0, $d = 0; $i < 13; $i++) {
            $d += $cnpj[$i] * $t;
            $t = ($t == 2) ? 9 : $t - 1;
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cnpj[13] != $d) {
            return false;
        }

        return true;
    }
}