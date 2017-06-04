<?php

use humhub\compat\CActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('DropboxModule.views_config_index', 'Dropbox Module Configuration'); ?></div>
    <div class="panel-body">

        <p><?php echo Yii::t('DropboxModule.views_config_index', 'The dropbox module needs active dropbox application created! Please go to this <a href="%link%" target="_blank"><strong>site</strong></a>, choose "Drop-ins app" and provide an app name to get your API key.', array('%link%' => 'https://www.dropbox.com/developers/apps/create')); ?></p>

        <br/>

        <?php $form = CActiveForm::begin(); ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'apiKey'); ?>
            <?php echo $form->textField($model, 'apiKey', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'apiKey'); ?>
        </div>


        <hr>
        <?php echo Html::submitButton(Yii::t('DropboxModule.views_config_index', 'Save'), array('class' => 'btn btn-primary')); ?>
        <a class="btn btn-default" href="<?php echo Url::to(['/admin/module']); ?>"><?php echo Yii::t('DropboxModule.views_config_index', 'Back to modules'); ?></a>

        <?php CActiveForm::end(); ?>
    </div>
</div>