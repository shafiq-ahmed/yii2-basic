<?php

namespace app\controllers;

use app\models\QueryForm;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use function PHPUnit\Framework\isEmpty;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays Query index page.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => \app\models\QueryForm::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $gridview= GridView::widget([
            'dataProvider' => $dataProvider,
        ]);
        return $this->render('index',[
            'gridview'=>$gridview
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
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
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
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
    public function actionAbout()
    {
        return $this->render('about');
    }
    /**
     * Displays Query form
     * Saves form data after submission
     * @return string
     * */
    public function actionCustomerQuery()
    {
        $model= new QueryForm();

        //$data = Yii::$app->request->post();
        $data=(Yii::$app->request->post());
        //if data is retrieved from post request
        //load data to model
        //save data to database
        if ($data){
            $model->load($data);

            //if error occurs while data insertion
            //user stays on same page and shown flash error message
            try {
                //get instance of the uploaded file
                $model->attachment = UploadedFile::getInstance($model, 'attachment');
                //check if a file has been uploaded
                if ($model->attachment != null) {

                    //set a unique name for the file and set the file path
                    $attachmentFilePath = 'uploads/' . uniqid() . '.' . $model->attachment->extension;
                    //save the file to local storage using the unique name
                    $model->attachment->saveAs($attachmentFilePath);
                    //set the local filepath to the model attribute
                    $model->attachment = $attachmentFilePath;
                }
                $model->save();
                //show view page after successful database insertion
                return $this->render('view',[
                    'model'=>$model
                ]);
            }catch(\Throwable $modelSaveError)
            {
                //$message = $model->errors;
                $message = $modelSaveError->getMessage();
                Yii::$app->session->setFlash('danger', $message);
            }

        }

        //if there is no post request show user query form
        return $this->render('customer-query',[
            'model'=>$model
        ]);
    }


}
