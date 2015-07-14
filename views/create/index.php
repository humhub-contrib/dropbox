<div id="container">
    <div class="panel panel-default">
		<div class="panel-body">
         
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'dropbox-create-post-from',
                'enableAjaxValidation' => false,
                'action' => $this->createContainerUrl('//dropbox/create/index')));
            ?>


            <div class="form-group">
                <?php echo $form->textArea($model, 'message', array('class' => 'form-control autosize', 'placeholder' => Yii::t('DropboxModule.views_dropbox_create', 'Describe your images'))); ?>
                <?php echo $form->error($model, 'message'); ?>
            </div>
            
            <div class="form-group">
                <span id="dropbox-open" class="pull-right btn btn-primary"><i class="fa fa-folder-open"></i></span>
                <ul class="tag_input <?php $errors = $model->getErrors(); if(!empty($errors['dropboxFileId'])) echo "error"?>"
                     id="dropbox_file_tags" style="margin-right:60px;" >
                    <li>
                        <?php echo $form->textField($model, 'dropboxFileId', array('id' => 'dropbox_files_list', 'readonly'=>'readonly',  'placeholder' => Yii::t('DropboxModule.views_dropbox_index', 'Select files from dropbox'), 'class'=> 'tag_input_field')); ?>
                    </li>
                    <?php
                    $this->widget('application.modules.dropbox.widgets.DropboxFileListerWidget', array(
                        'inputId' => 'dropbox_files_list',
                        'model' => $model,
                        'attribute' => 'dropboxFileId',
                        'openIcon' => 'dropbox-open'
                    ));
                    ?>
                </ul>
            
            </div>

           <hr>
           <div>
                <?php echo CHtml::submitButton( Yii::t('DropboxModule.views_dropbox_index', 'Submit'), array('class' => 'btn btn-info'));?>
           </div>
            
            <?php $this->endWidget(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
    // set the size for one row (Firefox)
    $('#CreateDropboxPostForm_message').css({height: '36px'});

    // add autosize function to input
    $('.autosize').autosize();

</script>