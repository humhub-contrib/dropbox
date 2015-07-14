<?php

/**
 * Create Controller
 *
 * @package humhub.modules.dropbox.controllers
 * @author Marjana Pesic
 */
class CreateController extends ContentContainerController
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

    public function actionIndex()
    {
        if(!HSetting::Get('apiKey', 'dropbox')){
            return $this->render('errorMissingKey', array());
        }
        
        $this->checkContainerAccess();
        $model = new CreateDropboxPostForm;
        
        if (isset($_POST['CreateDropboxPostForm'])) {
            $_POST['CreateDropboxPostForm'] = Yii::app()->input->stripClean($_POST['CreateDropboxPostForm']);
            $model->attributes = $_POST["CreateDropboxPostForm"];

            if ($model->validate()) {      
                $dropboxPost = new DropboxPost;
                $dropboxPost->message = $model->message;
                $dropboxPost->content->container = $this->contentContainer;
                $dropboxPost->content->visibility = $this->contentContainer->visibility;
                
                $dropboxPost->save();
                
                $dropboxFileIds = explode(",", $model->dropboxFileId);
                foreach($dropboxFileIds as $dropboxFileId){
                    if($dropboxFileId != null){
                        $dropboxFile = DropboxFile::model()->findByPk($dropboxFileId);
                        if($dropboxFile->object_model != "DropboxPost" || $dropboxFile->object_id != $dropboxPost->id){
                            $dropboxFile->object_model = "DropboxPost";
                            $dropboxFile->object_id = $dropboxPost->id;
                            $dropboxFile->save();
                        }
                    }
                }

                $uguid = $id = (int)Yii::app()->request->getParam('uguid');

                if ($uguid != null) {
                    return $this->htmlRedirect(Yii::app()->createUrl('//user/profile', array('uguid' => Yii::app()->user->guid)));
                } else {
                    return $this->htmlRedirect(Yii::app()->createUrl('//space/space', array('sguid' => $this->contentContainer->guid)));
                }
            }
        }
        
        $this->render('index', array('model' => $model));    
    }
        
}