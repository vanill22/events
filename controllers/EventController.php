<?php

namespace app\controllers;

namespace app\controllers;

use app\models\Organizer;
use Yii;
use app\models\Event;
use app\models\EventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class EventController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Event();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $organizerIds = Yii::$app->request->post('Event')['organizers'];
            foreach ($organizerIds as $organizerId) {
                Yii::$app->db->createCommand()->insert('event_organizer', [
                    'event_id' => $model->id,
                    'organizer_id' => $organizerId,
                ])->execute();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->db->createCommand()->delete('event_organizer', ['event_id' => $model->id])->execute();
            $organizerIds = Yii::$app->request->post('Event')['organizers'];
            foreach ($organizerIds as $organizerId) {
                Yii::$app->db->createCommand()->insert('event_organizer', [
                    'event_id' => $model->id,
                    'organizer_id' => $organizerId,
                ])->execute();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->organizers = $model->getOrganizers()->select('id')->column();

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function saveOrganizers($model)
    {
        $organizerIds = Yii::$app->request->post('organizers', []);
        $model->unlinkAll('organizers', true);
        foreach ($organizerIds as $organizerId) {
            $organizer = Organizer::findOne($organizerId);
            $model->link('organizers', $organizer);
        }
    }
}

