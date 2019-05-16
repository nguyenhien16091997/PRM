<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DataModel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Data Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- display success message -->
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
         <h4><i class="icon fa fa-check"></i>Saved!</h4>
         <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<!-- display error message -->
<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h4><i class="icon fa fa-check"></i>Saved!</h4>
         <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>
<div class="row">
        <div class="col-xl-12">
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
                    <div class="data-model-view">                        
                        <p>
                            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </p>

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                'name',
                                'file_name',
                                'userName',
                                'run_time',
                                'note',
                                'create_at',
                                'update_at',
                                'update_end_by',
                            ],
                        ]) ?>

                    </div>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>    
        <?php foreach ($arrXls_data as $xls_data) { ?>
        <div class="col-xl-12">
            <!--begin:: Widgets/Audit Log-->
            <div class="m-portlet m-portlet--full-height ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">                            
                            <h3 class="m-portlet__head-text">
                                <?php
                                    switch ($xls_data['type']) {
                                        case '1':
                                           echo "Loại bỏ missing </br>";
                                            break;
                                        case '2':
                                            echo "Thay thế missing bằng value 0 </br>";
                                            break;
                                        case '3':
                                            echo "Thay thế bằng số xuất hiện nhiều </br>";
                                            break;
                                        case '4':
                                            echo "Thay thế bằng giá trị lân cận </br>";
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                ?>
                                Time Run File: <?= $xls_data['time'] ?></br>
                                <?= count($xls_data['file'])-1?> Result 
                            
                            </h3>
                        </div>
                    </div>                                       
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_widget4_tab1_content">
                            <div class="m-scrollable" data-scrollable="true" data-max-height="400" style=" overflow: hidden;">
                                <div class="m-list-timeline m-list-timeline--skin-light">
                                    <div class="m-list-timeline__items">
                                        <?php                                           
                                            foreach ($xls_data['file'] as $item) {
                                                echo ('
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                    <span class="m-list-timeline__text nameE">'.
                                                        $item['A'].'
                                                    </span>
                                                    <span class="m-list-timeline__text valueE">'.
                                                        $item['B'].'
                                                    </span>
                                                    <span class="m-list-timeline__text">'.
                                                        $item['C'].'
                                                    </span>
                                                    <span class="m-list-timeline__time lapaceE">'.
                                                        $item['D'] .' %
                                                    </span>
                                                </div>');
                                            }                                            
                                        ?>
                                       
                                                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <!--end:: Widgets/Audit Log-->
        </div>
        <?php  } ?>                        
    </div>

