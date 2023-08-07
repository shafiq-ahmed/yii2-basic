<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\QueryForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Query Details';
$this->params['breadcrumbs'][] = $this->title;

//show query details
echo \yii\widgets\DetailView::widget([
    'model'=>$model,
    'attributes'=>[
        'name',
        'phone_number',
        'email',
        'subject',
        'query',

    ]
]);
?>


