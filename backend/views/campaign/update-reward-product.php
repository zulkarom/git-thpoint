<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use backend\models\Product;


/* @var $this yii\web\View */
/* @var $model backend\models\Campaign */

$this->title = $model->campaign_name . ': Product Reward';
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="campaign-update">


<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.product-item',
        'limit' => 100,
        'min' => 1,
        'insertButton' => '.add-product',
        'deleteButton' => '.remove-product',
        'model' => $products[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>Product</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($products as $i => $product): ?>
            <tr class="product-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows-alt"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $product->isNewRecord) {
                            echo Html::activeHiddenInput($product, "[{$i}]id");
                        }
                    ?>
					
                    <?= $form->field($product, "[{$i}]product_id")->dropDownList(ArrayHelper::map(Product::find()->orderBY('product_name ASC')->all(), 'id', 'productAndPrice'), ['prompt' => 'Select Product'])->label(false) ?>
                </td>
                
  

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-product btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="1">
                <button type="button" class="add-product btn btn-default btn-sm"><span class="fa fa-plus"></span> New Product</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>
    
    <br />
    <div class="form-group">
        <?= Html::submitButton('Save Promoted Products', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>



</div></div>
</div>



<?php

$js = <<<'EOD'

var fixHelperSortable = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};

$(".container-items").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    axis: "y",
    handle: ".sortable-handle",
    helper: fixHelperSortable,
    update: function(ev){
        $(".dynamicform_wrapper").yiiDynamicForm("updateContainer");
    }
}).disableSelection();

EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>

