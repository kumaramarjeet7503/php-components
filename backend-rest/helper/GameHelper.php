<?php

namespace app\helper ;

use Yii ;
use app\models\GamePlayed ;

class GameHelper
{
    public static function getGame()
    {
        return new GamePlayed() ;
    }

    
}

?>