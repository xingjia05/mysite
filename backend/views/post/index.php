<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Poststatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute'=>'id',
                'contentOptions'=>['width'=>'30px'],
            ],
            'title',
            ['attribute'=>'authorName',
                'label'=>'作者',
                'value'=>'author.nickname',
            ],
            'tags:ntext',
            ['attribute'=>'status',
                'value'=>'postStatus.name',
                'filter'=>Poststatus::find()
                    ->select(['name','id'])
                    ->orderBy('position')
                    ->indexBy('id')
                    ->column(),
            ],
            ['attribute'=>'update_time',
                'format'=>['date','php:Y-m-d H:i:s'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
