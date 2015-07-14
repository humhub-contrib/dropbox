<?php

/**
 * Index Controller
 *
 * @package humhub.modules.dropbox.controllers
 * @author Marjana Pesic
 */
class IndexController extends Controller
{
    
    /**
     *
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl'
        );
    }
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     *
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('@')
            ),
            array(
                'deny', // deny all users
                'users' => array('*')
            )
        );
    }

    public function actionEdit()
    {
        $id = Yii::app()->request->getParam('id');
        
        $dropboxPost = DropboxPost::model()->findByPk($id);
        $form = new CreateDropboxPostForm();
        
        if (! $dropboxPost->content->canWrite()) {
            throw new CHttpException(403, Yii::t('DropboxModule.controllers_DropboxController', 'Access denied!'));
        }
         
        else {
            
            if (isset($_POST['CreateDropboxPostForm'])) {
                $_POST['CreateDropboxPostForm'] = Yii::app()->input->stripClean($_POST['CreateDropboxPostForm']);
                $form->attributes = $_POST['CreateDropboxPostForm'];
                
                if ($form->validate()) {
                    $dropboxPost->message = $form->message;
                    $dropboxPost->save();
                    
                    $dropboxPost = DropboxPost::model()->findByPk($id);
                    
                    $dropboxFileIds = explode(",", $form->dropboxFileId);
                    foreach ($dropboxFileIds as $dropboxFileId) {
                        if ($dropboxFileId != null) {
                            $dropboxFile = DropboxFile::model()->findByPk($dropboxFileId);
                            if ($dropboxFile->object_model != "DropboxPost" || $dropboxFile->object_id != $dropboxPost->id) {
                                $dropboxFile->object_model = "DropboxPost";
                                $dropboxFile->object_id = $dropboxPost->id;
                                $dropboxFile->save();
                            }
                        }
                    }
                }
                
                $output = $this->widget('application.modules.dropbox.widgets.DropboxPostWidget', array(
                    'object' => $dropboxPost
                ), true);
                Yii::app()->clientScript->render($output);
                echo $output;
                return;
            } 

            else {
                $form->message = $dropboxPost->message;
                $fileIds = "";
                foreach ($dropboxPost->files as $file) {
                    $fileIds .= $file->id . ",";
                }
                $form->dropboxFileId = $fileIds;
            }
            
            return $this->renderPartial('edit', array(
                'model' => $form,
                'id' => $dropboxPost->id
            ), false, true);
        }
    }

    public function actionAddFile()
    {
        $this->forcePostRequest();
        
        $dropboxFile = new DropboxFile();
        $dropboxFile->link = Yii::app()->input->stripClean($_POST['link']);
        $dropboxFile->name = Yii::app()->input->stripClean($_POST['name']);
        $dropboxFile->thumbnail_link = isset($_POST['thumbnailLink']) ? Yii::app()->input->stripClean($_POST['thumbnailLink']) : "";
        
        // Json Array
        $json = array();
        $json['success'] = false;
        
        if ($dropboxFile->validate()) {
            $dropboxFile->save();
            $json['success'] = true;
            $json['id'] = $dropboxFile->id;
            $json['name'] = $dropboxFile->name;
        }
        
        echo CJSON::encode($json);
        Yii::app()->end();
    }

    public function actionDeleteFile()
    {
        $this->forcePostRequest();
        
        $id = Yii::app()->input->stripClean($_POST['id']);
        $dropboxFile = DropboxFile::model()->findByPk($id);
        
        // Json Array
        $json = array();
        $json['success'] = false;
        
        if ($dropboxFile && $dropboxFile->canDelete()) {
            $dropboxFile->delete();
            $json['success'] = true;
        }
        
        echo CJSON::encode($json);
        Yii::app()->end();
    }

    public function actionSkipWarning()
    {
        $this->forcePostRequest();
        
        $warningSetting = Yii::app()->input->stripClean($_POST['warningOnPosting']);
        $user = Yii::app()->user->getModel();
        
        // Json Array
        $json = array();
        $json['success'] = false;
        
        if ((int) $warningSetting != $user->getSetting("warningOnPosting", 'dropbox', HSetting::Get('warningOnPosting', 'dropbox'))) {
            
            $userSetting = UserSetting::model()->findByAttributes(array(
                'name' => 'warningOnPosting',
                'module_id' => 'dropbox',
                'user_id' => $user->id
            ));
            
            if ($userSetting == null) {
                $userSetting = new UserSetting();
                $userSetting->user_id = $user->id;
                $userSetting->module_id = "dropbox";
                $userSetting->name = "warningOnPosting";
            }
            
            $userSetting->value = (int) $warningSetting;
            $userSetting->save();
            
            $json['success'] = true;
        }
        
        echo CJSON::encode($json);
        Yii::app()->end();
    }
}