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
        <div class="col-xl-8">
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
                                    'template' => '{view}  {update}  {delete}  {download}',
                                    'buttons'  => [
                                          'download' => function ($url, $data) {     
                                                return Html::a(
                                                    '<span class="glyphicon glyphicon-download"></span>',
                                                    Url::to(['test-case/downloads','id'=>$data->id]),
                                                    ['title' => Yii::t('yii', 'Download')]
                                                );                                
                                            }
                                        ]
                                ],
                                [
                                    'class'    => 'yii\grid\ActionColumn',
                                    'template' => '{predictive}',
                                    'buttons'  => [
                                          'predictive' => function ($url, $data) {     
                                                /*return Html::span(
                                                    '<span id="show_result" class="glyphicon glyphicon-arrow-right"></span>',
                                                    Url::to(['/data-model/API','id'=>$data->id]),
                                                    ['title' => Yii::t('yii', 'Predictive')]
                                                ); */  
                                                return Html::tag('span', Html::encode(''), [
                                                    'class'=>'glyphicon glyphicon-arrow-right',
                                                    'id'=>'show_result'
                                                ]);                             
                                            }
                                        ]
                                ]
                            ],
                        ]); ?>
                    </div>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <!--begin:: Widgets/Audit Log-->
            <div class="m-portlet m-portlet--full-height ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">                            
                            <h3 class="m-portlet__head-text">
                                <?php if(isset($xls_data)){echo count($xls_data)-1;}?> Result 
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
                                            if(isset($xls_data)){   foreach ($xls_data as $item) {
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
                                            }}  
                                            else{
                                                echo 'No results found.';
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
    </div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#show_result').on('click', function(){          
            alert('hello');   
            // $.ajax({
            //     type: 'GET',
            //     url: '<?php echo Yii::$app->urlManager->createAbsoluteUrl('user/deleteall'); ?>',
            //     data : {'id' : key},
            //     success:function(data){
            //         location.reload();
            //     },
            //     error: function(data) {
            //         alert("Error occured. Please try again.");
            //     }
            // });
        });
    });
</script>