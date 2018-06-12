<?php

namespace app\controllers;

use app\models\Clicks;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\News;
use yii\data\Pagination;

class SiteController extends Controller {
  /**
   * {@inheritdoc}
   */
  public function behaviors() {
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

  /**
   * {@inheritdoc}
   */
  public function actions() {
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


  public function actionIndex() {
    $this->layout = 'main';
    $this->view->title = 'Всі новини';
    $news = News::find();
    $countQuery = clone $news;

    // paginations - 5 items per page
    $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);

    $pages->pageSizeParam = false;

    $models = $news->offset($pages->offset)
      ->limit($pages->limit)
      ->all();

    return $this->render('basic', [
      'models' => $models,
      'pages' => $pages,
    ]);

  }


  /**
   * Show current news action.
   *
   * @return string
   */

  public function actionShow($id) {
    $shownews = News::findOne(['id' => $id]);

    $clicks = Clicks::findOne(['clientId' => $this->getClientId()]);
    if (!$clicks) {
      $model = new Clicks();
      $model->news_id = $id;
      $clientId = $this->generateClientId();
      $model->clientId = $clientId;
      $model->country_code = $this->getByIP($this->getIP(), 'country');
      $model->date = date('Y-m-d');
      $model->unique_clicks = 1;
      $model->clicks = 1;
      $model->save();

      Yii::$app->response->cookies->add(new \yii\web\Cookie([
        'name' => 'clicks',
        'value' => $clientId,
        'expire' => time() + 60 * 60 * 24 * 30,
      ]));

    } elseif ($clicks = Clicks::findOne(['clientId' => $this->getClientId(), 'news_id' => $id])) {
      $clicks->clicks = $clicks->clicks + 1;
      $clicks->update(false);
    } elseif (!Clicks::findOne(['clientId' => $this->getClientId(), 'news_id' => $id])) {
      $model = new Clicks();
      $model->news_id = $id;
      $model->clientId = $this->getClientId();
      $model->country_code = $this->getByIP($this->getIP(), 'country');
      $model->date = date('Y-m-d');
      $model->unique_clicks = 1;
      $model->clicks = 1;
      $model->save();
    }


    return $this->render('current', ['shownews' => $shownews]);

  }

  private function getClientId() {
    return Yii::$app->getRequest()->getCookies()->get('clicks')->value;
  }

  private function generateClientId() {

    return strtolower(md5(uniqid($this->getByIP($this->getIP(), 'country') . '.'
      . $this->getByIP($this->getIP(), 'timestamp') . '.' . $this->getIP())));
  }

  private function getIP() {
    return Yii::$app->request->userIP;
  }

  private function getByIP($IP, $parameter) {

    $geo = file_get_contents('http://api.sypexgeo.net/json/' . $this->getIP());
    $geo = json_decode($geo);

    return $geo->$parameter;
  }


  /**
   * Show clicks statistic.
   *
   * @return string
   */

  public function actionStatistic() {

    $clicks = Clicks::find();
    $countQuery = clone $clicks;


    // paginations - 5 items per page
    $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);

    $pages->pageSizeParam = false;

    $models = $clicks->offset($pages->offset)
      ->limit($pages->limit)
      ->all();

    return $this->render('statistic', ['models' => $models, 'pages' => $pages]);

  }

  /**
   * Login action.
   *
   * @return Response|string
   */
  public function actionLogin() {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    }

    $model->password = '';
    return $this->render('login', [
      'model' => $model,
    ]);
  }

  /**
   * Logout action.
   *
   * @return Response
   */
  public function actionLogout() {
    Yii::$app->user->logout();

    return $this->goHome();
  }

  /**
   * Displays contact page.
   *
   * @return Response|string
   */
  public function actionContact() {
    $model = new ContactForm();
    if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
      Yii::$app->session->setFlash('contactFormSubmitted');

      return $this->refresh();
    }
    return $this->render('contact', [
      'model' => $model,
    ]);
  }

  /**
   * Displays about page.
   *
   * @return string
   */
  public function actionAbout() {
    return $this->render('about');
  }
}
