<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Guest $model */

$this->title = 'Create Guest';
$this->params['breadcrumbs'][] = ['label' => 'Guests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
