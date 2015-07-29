<div id="container">
    <div class="panel panel-default">
        <div class="panel-body">

            <?php
            if (Yii::$app->user->isAdmin()) {
                echo Yii::t('DropboxModule.views_dropbox_errorMissingKey', 'The Dropbox module is not configured yet! Please configure it <a href="%link%"><strong>here</strong></a>.', array('%link%' => \yii\helpers\Url::to(['/dropbox/admin'])));
            } else {
                echo Yii::t('DropboxModule.views_dropbox_errorMissingKey', 'Sorry, the Dropbox module is not configured yet! Please get in touch with the administrator.');
            }
            ?>

        </div>
    </div>
</div>