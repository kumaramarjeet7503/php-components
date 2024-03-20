<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "teams".
 *
 * @property int $id
 * @property string $name
 * @property int $wins
 * @property int $losses
 * @property string $created_date
 */
class Teams extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => false,
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teams';
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'name', 'wins', 'losses'], 'required'],
            [['wins', 'losses'], 'integer'],
            [['created_date'], 'safe'],
            [['name'], 'string', 'max' => 150]
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
            'wins' => 'Wins',
            'losses' => 'Losses',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TeamsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeamsQuery(get_called_class());
    }
}
