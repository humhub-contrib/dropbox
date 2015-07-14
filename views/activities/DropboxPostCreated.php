<?php $this->beginContent('application.modules_core.activity.views.activityLayout', array('activity' => $activity)); ?>

<?php echo Yii::t('DropboxModule.views_activities_DropboxPostCreated', '{userDisplayName} has created a new dropbox post', array(
    '{userDisplayName}' => '<strong>' . CHtml::encode($user->displayName) . '</strong>',
)); ?>

<?php $this->endContent(); ?>
