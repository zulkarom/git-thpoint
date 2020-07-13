<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\Campaign;
use backend\models\DashboardForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
						'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		$form = new DashboardForm;
		$form->action = ['site/index'];
		
		if(Yii::$app->getRequest()->getQueryParam('DashboardForm')){
			$data = Yii::$app->getRequest()->getQueryParam('DashboardForm');
			$form->year = $data['year'];
			$form->month = $data['month'];
			$cam = $data['campaign'];
			$form->campaign = $cam;
			$campaign = Campaign::findOne($cam);
		}else{
			$form->year = date('Y');
			$form->month = date('n');
			$campaign = Campaign::find()->where(['is_default' => 1])->one();
			$form->campaign = $campaign->id;
		}
		
		
		//$campaigns = Campaign::find()->where(['is_active' => 1])->all();
		
        return $this->render('index', [
		'campaign' => $campaign,
		'form' => $form,
		]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
			$this->layout = "//main-login";
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
