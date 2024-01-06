<?php

namespace app\modules\gift\controllers;

use Yii;
use yii\rest\ActiveController;
use app\modules\gift\helper\RestAPIController;
use app\modules\gift\models\RedeemGift ;

/**
 * Default controller for the `gift` module
 */
class GiftRestController  extends ActiveController
{
    public $modelClass  = 'not defined' ;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionValidateRedeem()
    {   
        $url = "https://etesting.space/wp-json/wc-pimwick/v1/pw-gift-cards?number=".Yii::$app->request->get("number") ;
        $authorization = "Basic ".base64_encode("ck_ad713bc399f8d63da81a3583057b3e7b3d0899d4:cs_ee0259074bde553ce2008e6e0cd3994f99da77d5")  ;
        $newdata = json_encode(array()) ;
        $method = 'GET' ;
        $apiResponse = RestAPIController::invokePostApi($url, $authorization, $newdata,$method) ;

        $response = empty($apiResponse) ?  $this->sendResponse("Not Found",$apiResponse,404) : $this->sendResponse("Success",$apiResponse,200) ;
        return $response ;
    }

    private function sendResponse($message,$apiResponse,$statusCode)
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->statusCode = $statusCode;
        $response->data = ['message' => $message,"data"=> $apiResponse];
        return $response ;
    }

    public function actionApplyPayment()
    {
        $post = json_decode(file_get_contents('php://input'), true);
        $redeemGift = new RedeemGift($post) ;
        $response = $redeemGift->save() ?  $this->sendResponse("success",$redeemGift,200) :  $this->sendResponse("success",$redeemGift->error,500)  ;
        return  $response ;
    }
}