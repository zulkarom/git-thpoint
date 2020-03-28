<?php

namespace backend\controllers;

use Yii;
use backend\models\Campaign;
use backend\models\CampaignPromotedProduct;
use backend\models\CampaignRewardProduct;
use backend\models\CampaignSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Model;
use yii\helpers\ArrayHelper;
use yii\db\Expression;


/**
 * CampaignController implements the CRUD actions for Campaign model.
 */
class CampaignController extends Controller
{
    /**
     * {@inheritdoc}
     */
        

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Campaign models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CampaignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Campaign model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Campaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Campaign();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Campaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	public function actionUpdatePromoteProduct($id)
    {
        $model = $this->findModel($id);
		$products = $model->promotedProducts;
       
        if ($model->load(Yii::$app->request->post())) {
           
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($products, 'id', 'id');
            
            
            $products = Model::createMultiple(CampaignPromotedProduct::classname(), $products);
            
            Model::loadMultiple($products, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($products, 'id', 'id')));
            
            foreach ($products as $i => $product) {
                $product->product_order = $i;
            }
            
            
            $valid = $model->validate();
			
            
            $valid = Model::validateMultiple($products) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            CampaignPromotedProduct::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($products as $i => $product) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $product->campaign_id = $model->id;
							$product->updated_at = new Expression('NOW()');

                            if (!($flag = $product->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Promoted products updated");
                            return $this->redirect(['update-promote-product','id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

    }
    
     return $this->render('update-promote-product', [
            'model' => $model,
            'products' => (empty($products)) ? [new CampaignPromotedProduct] : $products
        ]);

    }
	
	public function actionUpdateRewardProduct($id)
    {
        $model = $this->findModel($id);
		$products = $model->rewardProducts;
       
        if ($model->load(Yii::$app->request->post())) {
           
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($products, 'id', 'id');
            
            
            $products = Model::createMultiple(CampaignRewardProduct::classname(), $products);
            
            Model::loadMultiple($products, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($products, 'id', 'id')));
            
            foreach ($products as $i => $product) {
                $product->product_order = $i;
            }
            
            
            $valid = $model->validate();
			
            
            $valid = Model::validateMultiple($products) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            CampaignRewardProduct::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($products as $i => $product) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $product->campaign_id = $model->id;
							$product->updated_at = new Expression('NOW()');

                            if (!($flag = $product->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Product Reward updated");
                            return $this->redirect(['update-reward-product','id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

    }
    
     return $this->render('update-reward-product', [
            'model' => $model,
            'products' => (empty($products)) ? [new CampaignRewardProduct] : $products
        ]);

    }

    /**
     * Deletes an existing Campaign model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Campaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Campaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
