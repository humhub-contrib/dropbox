<div id="container">
    <div class="panel panel-default">
    
        <div class="panel-heading"><?php echo Yii::t('DropboxModule.views_dropbox_config', '<strong>Dropbox</strong> settings'); ?></div>
		<div class="panel-body">
		
    		<?php 
    		$form = $this->beginWidget('CActiveForm', array(
    		    'id' => 'dropbox-config',
    		    'enableAjaxValidation' => false));
    		?>
    		
    		<div class="checkbox">
                <label>
                    <?php echo $form->checkBox($model, 'warningOnPosting'); ?> <?php echo $model->getAttributeLabel('warningOnPosting'); ?>
                </label>
            </div>

    		<hr/>
    		
    		<div>
                <?php echo CHtml::submitButton( Yii::t('DropboxModule.views_dropbox_config', 'Submit'), array('class'=> 'btn btn-primary'));?>
                <!-- show flash message after saving -->
                <?php $this->widget('application.widgets.DataSavedWidget'); ?>
           </div>
           
           
           <?php $this->endWidget(); ?>
		</div>
	</div>
</div>