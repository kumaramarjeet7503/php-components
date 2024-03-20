<?php


namespace app\controllers;

use app\helper\GameHelper;
use Yii;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\filters\ContentNegotiator ;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;
use app\helper\PlayerHelper ;
use app\helper\TeamHelper ;
use app\helper\MatchHelper ;
use app\models\GamePlayed;
use app\models\Match ;
use app\models\Matches;
use app\models\Teams;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;

class GameController extends ActiveController
{
    public $modelClass = 'app\models\Model'; // Specify the model class for your resource

        /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'starts,get-team-performance,get-match-by-date' => ['get'],
                    'create-player,schedule-match,create-team,play' => ['post'],
                    'over'=>['put'],
                    // 'get-team-performance' => ['get'],
                    'get-match-by-date'=>['get']
                ],
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) return false;
        if (Yii::$app->request->getMethod() === 'GET') return true ;

        $authHeader = Yii::$app->request->headers->get('Authorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $token = $matches[1];
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this API.');
        }
        foreach (User::$users as $user) {
           
            if ($user['accessToken'] == (string) $token) {
                return true;
            }
        }
        throw new ForbiddenHttpException('You are not allowed to access this API.');
    }

    public function actionStarts()
    {
        return "Match Started" ;
    }

    public function actionCreateTeam()
    {
        // Begin transaction
        $transaction = Yii::$app->db->beginTransaction();
        try {
        $data = json_decode(file_get_contents('php://input'), true);
        $team = TeamHelper::getTeam() ;
        $team->setAttributes($data);
        $players = $data['players'] ;
        $team->save() ;

        foreach ($players as $key => $player) {
            $createPlayer = PlayerHelper::getPlayer() ;
            $createPlayer->setAttributes($player);
            $createPlayer->team_id = $team->id ;
            $createPlayer->save() ;
        }
            // Commit transaction if all operations succeed
            $transaction->commit();
            return $team->id ;
        } catch (\Exception $e) {
            // Rollback transaction if an exception occurs
            $transaction->rollBack();
            throw $e;
        }
    }

    public function actionCreatePlayer()
    {
        // Begin transaction
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $player = PlayerHelper::getPlayer() ;
            $player->setAttributes($data);
            $player->save() ;
            // Commit transaction if all operations succeed
            $transaction->commit();
            return $player ;
        } catch (\Exception $e) {
            // Rollback transaction if an exception occurs
            $transaction->rollBack();
            throw $e;
        }
    }

    public function actionScheduleMatch()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $match = MatchHelper::getMatch() ;
        $match->setAttributes($data);
        $match->save() ;
        return $match ;
    }

    public function actionPlay()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $gamePlayed = GameHelper::getGame() ;
        $gamePlayed->setAttributes($data) ;
        $gamePlayed->save() ;
        return $gamePlayed ;
    }

    public function actionOver()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $gamePlayed = GamePlayed::find()->where(['m_id'=>$data['m_id']])->one() ;
        $gamePlayed->player_of_the_match = $data['player_of_the_match'] ;
        $gamePlayed->result = $data['result'] ;
        $gamePlayed->update() ;
        return $gamePlayed ;
    }

    public function actionGetTeamPerformance()
    {
        $teams = Teams::find()->select(['wins','losses'])->all() ;
        return $teams ;
    }

    public function actionGetMatchByDate($date)
    {
    //    $matches = Matches::find()
    //    ->alias('matches')
    // //    ->innerJoin(['gamePlayed'=>GamePlayed::tableName()],'gamePlayed.m_id = matches.id ')
    //    ->joinWith('game')
    //    ->select('*')
    // //    ->where(['date'=>$date])
    //    ->all() ;

     $matches =  (new \yii\db\Query)->from(['matches'=>Matches::tableName()])
    ->innerJoin(['game'=>GamePlayed::tableName()],'matches.id = game.m_id') ;
    $dataProvider = new ActiveDataProvider([
        'query' => $matches,
    ]);

       return $dataProvider ;
    }
    
}

?>