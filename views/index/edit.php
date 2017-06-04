<?php

use humhub\compat\CActiveForm;

$form = CActiveForm::begin();
?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'message'); ?>
    <?php echo $form->textArea($model, 'message', array('class' => 'form-control autosize', 'placeholder' => Yii::t('DropboxModule.views_dropbox_index', 'Describe your files'))); ?>
    <?php echo $form->error($model, 'message'); ?>
</div>

<div class="form-group">
    <span id="dropbox-open_<?php echo $id; ?>" class="pull-right btn btn-primary"><i
            class="fa fa-folder-open"></i></span>
    <ul class="tag_input" id="dropbox_file_tags" style="margin-right:60px;">
        <li>
            <?php echo $form->textField($model, 'dropboxFileId', array('id' => 'dropbox_files_list_' . $id, 'placeholder' => Yii::t('DropboxModule.views_dropbox_index', 'Select files from dropbox'), 'class' => 'tag_input_field')); ?>
        </li>
        <?php
        echo humhub\modules\dropbox\widgets\DropboxFileListerWidget::widget(array(
            'inputId' => 'dropbox_files_list_' . $id,
            'model' => $model,
            'attribute' => 'dropboxFileId',
            'openIcon' => 'dropbox-open_' . $id
        ));
        ?>
    </ul>

</div>


</div>


<div>
    <?php
    echo \humhub\widgets\AjaxButton::widget([
        'label' => "Save",
        'ajaxOptions' => [
            'type' => 'POST',
            'success' => 'function(html){ $(".wall_' . $dropboxPost->getUniqueId() . '").replaceWith(html); }',
            'url' => \yii\helpers\Url::to(['/dropbox/index/edit', 'id' => $id]),
        ],
        'htmlOptions' => [
            'class' => 'btn btn-primary', 'id' => 'post_edit_post_' . $id
        ]
    ]);
    ?>
</div>

<?php CActiveForm::end(); ?>

<script type="text/javascript">
    // set the size for one row (Firefox)
    $('#CreateDropboxPostForm_message').css({height: '36px'});

    // add autosize function to input
    $('.autosize').autosize();

</script>