<?php

namespace humhub\modules\dropbox\controllers;

use Yii;
use humhub\models\Setting;
use humhub\modules\dropbox\models\CreateDropboxPostForm;
use humhub\modules\dropbox\models\DropboxPost;
use humhub\modules\dropbox\models\DropboxFile;

/**
 * Create Controller
 *
 * @package humhub.modules.dropbox.controllers
 * @author Marjana Pesic
 */
class CreateController extends \humhub\modules\content\components\ContentContainerController
{

    public function actionIndex()
    {
        if (!Setting::Get('apiKey', 'dropbox')) {
            return $this->render('errorMissingKey', array());
        }

        $model = new CreateDropboxPostForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $dropboxPost = new DropboxPost;
            $dropboxPost->message = $model->message;
            $dropboxPost->content->container = $this->contentContainer;
            $dropboxPost->content->visibility = $this->contentContainer->visibility;
            $dropboxPost->save();

            $dropboxFileIds = explode(",", $model->dropboxFileId);
            foreach ($dropboxFileIds as $dropboxFileId) {
                if ($dropboxFileId != null) {
                    $dropboxFile = DropboxFile::findOne(['id' => $dropboxFileId]);
                    if ($dropboxFile->object_model != DropboxPost::className() || $dropboxFile->object_id != $dropboxPost->id) {
                        $dropboxFile->object_model = DropboxPost::className();
                        $dropboxFile->object_id = $dropboxPost->id;
                        $dropboxFile->save();
                    }
                }
            }

            return $this->htmlRedirect($this->contentContainer->createUrl());
        }

        return $this->render('index', array('model' => $model));
    }

}
