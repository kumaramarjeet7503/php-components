<?php

namespace app\helper ;

use Yii ;
use app\models\Teams ;

class TeamHelper
{
    public static function getTeam()
    {
        return new Teams() ;
    }
}

?>