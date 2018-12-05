<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DataModel */

$this->title = 'Update Data Model: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Data Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="row">
                            <div class="col-xl-8">
                                <div class="m-portlet m-portlet--mobile ">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text">
                                                   <?= Html::encode($this->title) ?>
                                                </h3>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="m-portlet__body">
                                        <!--begin: Datatable -->
                                        <div class="data-model-update">
										    <?= $this->render('_form', [
										        'model' => $model,
										    ]) ?>

										</div>
                                        <!--end: Datatable -->
                                    </div>
                                </div>
                            </div>
                            
    </div>


