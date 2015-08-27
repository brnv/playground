<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Category;
use app\models\News;

class NewsController extends Controller
{
    public function actionIndex()
    {
        return $this->actionList();
    }

    public function actionList()
    {
        $news = new News();

        if (Yii::$app->request->get()['catid']) {
            $newsList = $news->getAllForCategory(Yii::$app->request->get()['catid']);
        } else {
            $newsList = $news->getAllActive();
        }

        $category = new Category();

        return $this->render('list', [
            'categories' => $category->getAllActive(),
            'news' => $newsList,
        ]);
    }

    public function actionShow()
    {
        $newsItem= News::find()
            ->where(['id' => Yii::$app->request->get()['id']])
            ->one();

        return $this->render('show', [
            'newsItem' => $newsItem,
        ]);
    }
}
