<?php

/** @var yii\web\View $this */
/** @var array $data */

?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">price_in</th>
                    <th scope="col">price_out</th>
                    <th scope="col">percent</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $item): ?>
                    <tr>
                        <td><?=$item['price_in']?></td>
                        <td><?=$item['price_out']?></td>
                        <td><?=$item['percent']?>%</td>
                        <td><?=Yii::$app->formatter->asDatetime($item['start'])?></td>
                        <td><?=Yii::$app->formatter->asDatetime($item['end'])?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
