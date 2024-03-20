<?php

namespace app\helper ;

use Yii ;
use app\models\Players ;

class PlayerHelper
{
    public static function getPlayer()
    {
        return new Players() ;
    }
}

?>