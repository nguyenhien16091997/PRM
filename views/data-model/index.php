<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Models';
$this->params['breadcrumbs'][] = $this->title;
?>


    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Exclusive Datatable Plugin
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                                    <?= Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'm-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle']) ?>                                                                                          
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin: Datatable -->
                    <div class="data-model-index">                                           

                        <?= GridView::widget([
                            'id' => 'selectRow',
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'header' =>'',
                                    'class' => 'yii\grid\SerialColumn'],
                                'name',
                                'file_name',
                                'userName',                                                    
                                'create_at',                                                   
                                [
                                    'header'   => 'Action',
                                    'class'    => 'yii\grid\ActionColumn',
                                    'template' => '{view} {delete}  {download}',
                                    'buttons'  => [
                                          'download' => function ($url, $data) {     
                                                return Html::a(
                                                    '<span class="glyphicon glyphicon-download"></span>',
                                                    Url::to(['data-model/getData','id'=>$data->id]),
                                                    ['title' => Yii::t('yii', 'Download')]
                                                );                                
                                            }
                                        ]
                                ],
                            
                            ],
                        ]); ?>
                    </div>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
        
    </div>
<script type="text/javascript">
    var k = -1;
    showResult(null);

     function showResult(xls_data){
        if(xls_data == null){
            $('#count_result').empty();
            $("#list-preditive").empty();
            $( "#list-preditive" ).append('please chose to show result');
            $('#count_result').append('Result');
            return
        }
        else{
            $("#list-preditive").empty();
            $('#count_result').empty();
        }
        
        for (var item in xls_data){
            x = xls_data[item][1];
            $( "#list-preditive" ).append( ''
                +'<div class="m-list-timeline__item">'
                    +'<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>'
                    +'<span class="m-list-timeline__text nameE">'+x.A+''
                    +'</span>'
                    +'<span class="m-list-timeline__text valueE">'
                        +x.B+''
                    +'</span>'
                    +'<span class="m-list-timeline__text">'+x.C+''
                    +'</span>'
                    +'<span class="m-list-timeline__time lapaceE">'+x.D +' %'
                    +'</span>'
                +'</div>' );
        
        }
        $('#count_result').append(xls_data.length-1 +' Result');
    }
</script>