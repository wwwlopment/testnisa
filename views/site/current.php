<?php

use yii\helpers\Html;

?>


<?= '<div class="item-contain">' ?>
<?= '<h1>' . $shownews['title'] . '</h1>' ?>
<?= '<div class="item-image">' . Html::img('/web/uploads/' . $shownews['picture']) . '</div>' ?>
<?= '<div class="item-content">' . $shownews['content'] . '</div>' ?>



