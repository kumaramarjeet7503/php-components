<?php


namespace app\modules\gift\helper;

use yii;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;	


class RestAPIController extends ActiveController
{
	public $modelClass = 'not defined';	
	
	public function invokePostApi($url, $authorization, $newdata,$method){
		
		$options = array(
			'http' => array(
				'header'  => array("Content-Type: application/json",
					"Authorization: ".$authorization),
				'method'  => $method,
				'content' => $newdata,
				'ignore_errors' => true
			)
		);
		
		// return $options ;
		return self::callApi($url, $options);
	}

	private function callApi($url, $options){	

		$context  = stream_context_create($options);
		$response = file_get_contents($url, false, $context);

		$status_line = $http_response_header[0];

		preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
		$status = $match[1];
		$result = strlen($response) ==  0? "" :self::isJSON($response)?json_decode($response):$response;
		if ($status == "200")
		{
			return $result;
		}
		else
		{
			if(isset($result->message))
			{
				return self::createResponse($result->message,400);
			}
			else
			{
				return $result;
			}
		}	
	}

	private	function isJSON($string){
		return is_string($string) && is_array(json_decode($string, true)) ? true : false;
	}

	private function createResponse($data,$statusCode)
	{
		$response = Yii::$app->getResponse();
		$response->setStatusCode((int)$statusCode);
		$response->data = $data;
		return $response;
	}

}