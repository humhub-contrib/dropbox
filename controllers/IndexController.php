<?php

namespace humhub\modules\dropbox\controllers;

use Yii;
use humhub\modules\dropbox\models\DropboxFile;
use humhub\modules\dropbox\models\DropboxPost;
use humhub\models\Setting;
use yii\web\HttpException;

/**
 * Index Controller
 *
 * @package humhub.modules.dropbox.controllers
 * @author Marjana Pesic
 */
class IndexController extends \humhub\components\Controller
{

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');

        $dropboxPost = DropboxPost::findOne(['id' => $id]);
        $form = new \humhub\modules\dropbox\models\CreateDropboxPostForm();
        $form->message = $dropboxPost->message;
        $fileIds = "";
        foreach ($dropboxPost->files as $file) {
            $fileIds .= $file->id . ",";
        }
        $form->dropboxFileId = $fileIds;

        if (!$dropboxPost->content->canWrite()) {
            throw new HttpException(403, Yii::t('DropboxModule.controllers_DropboxController', 'Access denied!'));
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $dropboxPost->message = $form->message;
            $dropboxPost->save();
            $dropboxPost = DropboxPost::findOne(['id' => $id]);

            $dropboxFileIds = explode(",", $form->dropboxFileId);
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

            return $dropboxPost->getWallOut();
        }

        return $this->renderAjax('edit', array(
                    'model' => $form,
                    'dropboxPost' => $dropboxPost,
                    'id' => $dropboxPost->id
        ));
    }

    public function actionAddFile()
    {
        Yii::$app->response->format = 'json';

        $this->forcePostRequest();

        $dropboxFile = new DropboxFile();
        $dropboxFile->link = Yii::$app->request->post('link');
        $dropboxFile->name = Yii::$app->request->post('name');
        $dropboxFile->thumbnail_link = Yii::$app->request->post('thumbnailLink');

// Json Array
        $json = array();
        $json['success'] = false;
        if ($dropboxFile->validate() && $dropboxFile->save()) {
            $json['success'] = true;
            $json['id'] = $dropboxFile->id;
            $json['name'] = $dropboxFile->name;
        }
        return $json;
    }

    public function actionDeleteFile()
    {
        Yii::$app->response->format = 'json';
        $this->forcePostRequest();

        $dropboxFile = DropboxFile::findOne(['id' => Yii::$app->request->post('id')]);

// Json Array
        $json = array();
        $json['success'] = false;

        if ($dropboxFile && $dropboxFile->canDelete() && $dropboxFile->delete()) {
            $json['success'] = true;
        }

        return $json;
    }

    public function actionSkipWarning()
    {
        Yii::$app->response->format = 'json';
        $this->forcePostRequest();

        $warningSetting = Yii::$app->request->post('warningOnPosting');
        $user = Yii::$app->user->getIdentity();

        $json = array();
        $user->setSetting('warningOnPosting', ($warningSetting) ? "0" : "1", 'dropbox');
        $json['success'] = true;

        return $json;
    }

}
