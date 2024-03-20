<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "game_played".
 *
 * @property int $m_id
 * @property int $host
 * @property int $guest
 * @property int $player_of_the_match
 * @property int $result
 */
class GamePlayed extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_played';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['m_id', 'host', 'guest', ], 'required'],
            [['m_id', 'host', 'guest'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'm_id' => 'M ID',
            'host' => 'Host',
            'guest' => 'Guest',
            'player_of_the_match' => 'Player Of The Match',
            'result' => 'Result',
        ];
    }

    /**
     * {@inheritdoc}
     * @return GamePlayedQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GamePlayedQuery(get_called_class());
    }
}
