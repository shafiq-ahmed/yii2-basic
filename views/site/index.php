<?php

/** @var yii\web\View $this */
/** @var yii\grid\GridView $gridview */

$this->title = 'Queries';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="https://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

<?php
    //show list of queries in gridview
    echo $gridview;

?>


    </div>
</div>
