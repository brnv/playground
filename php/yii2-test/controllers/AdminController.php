<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Category;
use app\models\News;
use app\models\ImageUploadForm;
use yii\web\UploadedFile;

class AdminController extends Controller
{
    //@TODO:remove
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    //@TODO:remove
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCategories()
    {
        $category = new Category();

        return $this->render('categories', [
            'categories' => $category->getAll()
        ]);
    }

    public function actionAddcategory()
    {
        if (Yii::$app->request->post() != NULL) {
            $category = new Category();

            $category->name = Yii::$app->request->post()["name"];
            $category->description = Yii::$app->request->post()["description"];
            $category->parent_id = Yii::$app->request->post()["parent_id"];

            if ($category->parent_id == 0)  {
                $category->parent_id = NULL;
            }

            $category->is_active = 0;
            if (Yii::$app->request->post()["is_active"] == "on") {
                $category->is_active = 1;
            }

            $category->save();

            $this->redirect('?r=admin/categories',302);
        }

        $category = new Category();

        return $this->render('form-category', [
            'categories' => $category->getAll()
        ]);
    }

    public function actionEditcategory()
    {
        $category = Category::find()
            ->where(['id' => Yii::$app->request->get()['id']])
            ->one();

        if (Yii::$app->request->post() != NULL) {
            $category->name = Yii::$app->request->post()["name"];
            $category->description = Yii::$app->request->post()["description"];
            $category->parent_id = Yii::$app->request->post()["parent_id"];

            if ($category->parent_id == 0)  {
                $category->parent_id = NULL;
            }

            $category->is_active = 0;
            if (Yii::$app->request->post()["is_active"] == "on") {
                $category->is_active = 1;
            }

            $category->save();

            $this->redirect('?r=admin/categories', 302);
        }

        return $this->render('form-category', [
            'categoryItem' => $category,
            'categories' => $category->getAll()
        ]);
    }

    public function actionNews()
    {
        $news = new News();

        return $this->render('news', [
            'news' => $news->getAll()
        ]);
    }

    public function actionAddnews()
    {
        if (Yii::$app->request->post() != NULL) {
            $newsItem = new News();

            $newsItem->name = Yii::$app->request->post()["name"];
            $newsItem->description_short = Yii::$app->request->post()["description_short"];
            $newsItem->date = Yii::$app->request->post()["date"];
            $newsItem->content = Yii::$app->request->post()["content"];

            if ($category->date == "")  {
                unset($newsItem->date);
            } else {
                $newsItem->date = Yii::$app->request->post()["date"];
            }

            if (Yii::$app->request->post()["is_active"] == "on") {
                $newsItem->is_active = 1;
            }

            $newsItem->category_id = Yii::$app->request->post()["category_id"];

            $imageUploadModel = new ImageUploadForm();
            $imageUploadModel->imageFile = UploadedFile::getInstance($imageUploadModel, 'imageFile');
            if ($imageUploadModel->upload()) {
                $newsItem->image = "files/" . $imageUploadModel->imageFile->baseName . '.'
                    . $imageUploadModel->imageFile->extension;
            }

            $newsItem->save();

            $this->redirect('?r=admin/news', 302);
        }

        $category = new Category();

        return $this->render('form-news', [
            'categories' => $category->getAll()
        ]);
    }

    public function actionEditnews()
    {
        $newsItem = News::find()
            ->where(['id' => Yii::$app->request->get()['id']])
            ->one();;

        if (Yii::$app->request->isPost) {
            $newsItem->name = Yii::$app->request->post()["name"];
            $newsItem->description_short = Yii::$app->request->post()["description_short"];
            $newsItem->date = Yii::$app->request->post()["date"];
            $newsItem->content = Yii::$app->request->post()["content"];

            if (Yii::$app->request->post()["is_active"] == "on") {
                $newsItem->is_active = 1;
            }

            $newsItem->category_id = Yii::$app->request->post()["category_id"];

            $imageUploadModel = new ImageUploadForm();
            $imageUploadModel->imageFile = UploadedFile::getInstance($imageUploadModel, 'imageFile');
            if ($imageUploadModel->upload()) {
                $newsItem->image = "files/" . $imageUploadModel->imageFile->baseName . '.'
                    . $imageUploadModel->imageFile->extension;
            }

            $newsItem->save();

            //$this->redirect('?r=admin/news', 302);
        }

        $category = new Category();

        return $this->render('form-news', [
            'newsItem' => $newsItem,
            'categories' => $category->getAll()
        ]);

    }


    //@TODO:remove
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    //@TODO:remove
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    //@TODO:remove
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
}
