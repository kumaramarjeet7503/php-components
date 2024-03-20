<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "matches".
 *
 * @property int $id
 * @property string $venue
 * @property string $date
 * @property string $status
 */
class Matches extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'matches';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'venue', 'date', 'status'], 'required'],
            [['date'], 'safe'],
            [['venue', 'status'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'venue' => 'Venue',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatchesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatchesQuery(get_called_class());
    }

    public function getGame()
    {
        return $this->hasOne(GamePlayed::class,['m_id'=>'id']) ;
    }
}
