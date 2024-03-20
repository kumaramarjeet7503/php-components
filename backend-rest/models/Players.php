<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "players".
 *
 * @property int $id
 * @property string $role
 * @property string $name
 * @property int $team_id
 * @property string $created_date
 */
class Players extends \yii\db\ActiveRecord
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
        return 'players';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'role', 'name', 'team_id'], 'required'],
            [['team_id'], 'integer'],
            [['created_date'], 'safe'],
            [['role', 'name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'name' => 'Name',
            'team_id' => 'Team ID',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PlayersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlayersQuery(get_called_class());
    }
}
