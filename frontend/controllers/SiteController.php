<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use frontend\models\PointForm;
use backend\models\Customer;
use yii\web\ForbiddenHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
	public $layout = 'website';

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
	

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['site/dashboard']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
			return $this->redirect(['site/dashboard']);
        } else {
			//$this->layout = "//main";
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
	


    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/dashboard/index']);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
	
	public function actionMypoint($phone = null)
    {
		$model = new PointForm();
		
		if ($model->load(Yii::$app->request->post())){
			$phone = $model->phone;
			return $this->redirect(['site/mypoint', 'phone' => $phone]);
		}
		
        if ($phone) {
			$customer = Customer::findOne(['customer_phone' => $phone]);
			if(!$customer){
				Yii::$app->session->setFlash('error', 'Customer not found');
				return $this->redirect(['mypoint']);
			}
            return $this->render('show-point', [
                'model' => $model,
				'customer' => $customer
            ]);
			
        } else {
			
            return $this->render('mypoint', [
                'model' => $model,
            ]);
        }
    }
	
	protected function findCustomer($phone)
    {
        if (($model = Customer::findOne($phone)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
