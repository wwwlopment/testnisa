<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;


if (isset ($models)) {
  echo '<h1>Всі новини :</h1>';
  foreach ($models as $model) {
    echo '<div class="item-contain">';
    echo '<h2>' . Html::a($model->title, ['show', 'id' => $model->id]) . '</h2>';
    //echo '<h2>' . $model->title . '</h2>';
    echo '<div class="item-image">' . Html::img('/web/uploads/' . $model->picture) . '</div>';
    echo '<div class="item-teaser">' . $model->teaser . '</div>';
    // echo Html::a('Читати...', ['show', 'id' => $model->id], ['class' => 'btn btn-primary']);
    echo '</div> </br>';
  }
}

if (isset ($pages)) {
  echo LinkPager::widget([
    'pagination' => $pages,
  ]);
}


