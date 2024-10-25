<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use app\models\Guest;

class GuestController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = \yii\web\Response::FORMAT_JSON;

        return $behaviors;
    }

    public function afterAction($action, $result)
    {
        $memory = memory_get_peak_usage(true) / 1024;
        $time = microtime(true) - YII_BEGIN_TIME;

        Yii::$app->response->headers->set('X-Debug-Time', (int)($time * 1000));
        Yii::$app->response->headers->set('X-Debug-Memory', (int)$memory);

        return parent::afterAction($action, $result);
    }

    public function actionIndex()
    {
        return Guest::find()->all();
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    public function actionCreate()
    {
        $guest = new Guest();
        $guest->load(Yii::$app->request->post(), '');

        if (empty($guest->country)) {
            $guest->validateCountry('phone');
        }

        if ($guest->save()) {
            Yii::$app->response->statusCode = 201;
        
            return $guest;
        }

        return [
            'status' => 'error',
            'errors' => $guest->getErrors(),
        ];
    }


    public function actionUpdate($id)
    {
        $guest = $this->findModel($id);
        $guest->load(Yii::$app->request->post(), '');

        if ($guest->save()) {
            return $guest;
        }

        return [
            'status' => 'error',
            'errors' => $guest->getErrors(),
        ];
    }

    public function actionDelete($id)
    {
        $guest = $this->findModel($id);

        if ($guest->delete()) {
            Yii::$app->response->statusCode = 204;

            return ['status' => 'success'];
        }

        return ['status' => 'error'];
    }

    protected function findModel($id)
    {
        if (($model = Guest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException("Guest not found with ID: $id.");
    }

}