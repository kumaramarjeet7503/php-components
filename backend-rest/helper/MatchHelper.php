<?php

namespace app\helper ;

use Yii ;
use app\models\Matches ;

class MatchHelper
{
    public static function getMatch()
    {
        return new Matches() ;
    }
}

?>