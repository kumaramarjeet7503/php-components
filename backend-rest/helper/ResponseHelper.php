<?php

namespace app\helper ;

use Yii ;
use app\models\Players ;

class ResponseHelper
{
    public static function createResponse($statusCode,$message,$data)
    {
        $response = ['message' => $message,"data"=>$data, 'statusCode' => $statusCode];
        return json_encode($response) ;
    }
}

?>