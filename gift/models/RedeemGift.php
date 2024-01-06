<?php

namespace app\modules\gift\models;

use Yii;

/**
 * This is the model class for table "redeem_gift".
 *
 * @property int $id
 * @property string $customer_number
 * @property string $card_number
 * @property float $balance
 */
class RedeemGift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'redeem_gift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_number', 'card_number', 'balance'], 'required'],
            [['balance'], 'number'],
            [['customer_number'], 'string', 'max' => 20],
            [['card_number'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_number' => 'Customer Number',
            'card_number' => 'Card Number',
            'balance' => 'Balance',
        ];
    }
}
