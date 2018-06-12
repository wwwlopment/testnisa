<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */

$this->title = 'Статистика кліків';
?>
<table class="table">
  <thead>
  <tr>
    <th>news_id</th>
    <th>unique_clicks</th>
    <th>clicks</th>
    <th>country code</th>
    <th>date</th>
  </tr>
  </thead>
  <tbody>

  <?php foreach ($models as $item):?>
  <tr>
  <td><?=$item->news_id?></td>
  <td><?=$item->unique_clicks?></td>
  <td><?=$item->clicks?></td>
  <td><?=$item->country_code?></td>
  <td><?=$item->date?></td>

  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php
if (isset ($pages)) {
echo LinkPager::widget([
'pagination' => $pages,
]);
}
?>
