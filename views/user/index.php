<?php

use humhub\compat\CActiveForm;
use yii\helpers\Html;
?>

<div id="container">
    <div class="panel panel-default">

        <div class="panel-heading"><?php echo Yii::t('DropboxModule.views_dropbox_config', '<strong>Dropbox</strong> settings'); ?></div>
        <div class="panel-body">

            <?php
            $form = CActiveForm::begin();
            ?>

            <div class="checkbox">
                <label>
                    <?php echo $form->checkBox($model, 'warningOnPosting'); ?> <?php echo $model->getAttributeLabel('warningOnPosting'); ?>
                </label>
            </div>

            <hr/>

            <div>
                <?php echo Html::submitButton(Yii::t('DropboxModule.views_dropbox_config', 'Submit'), array('class' => 'btn btn-primary')); ?>
            </div>


            <?php CActiveForm::end(); ?>
        </div>
    </div>
</div>