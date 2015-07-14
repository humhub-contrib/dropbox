<?php

/**
 * Config Controller
 *
 * @package humhub.modules.dropbox.controllers
 * @author Marjana Pesic
 */
class ConfigController extends Controller
{
    
    public $subLayout;
    
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
            array('allow',
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionModuleConfig(){

        $this->subLayout = "application.modules_core.admin.views._layout";
        $form = new ModuleConfigForm;
        
        //ajax based validation
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dropbox-configure-form') {
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }
        
        if (isset($_POST['ModuleConfigForm'])) {          
            $_POST['ModuleConfigForm'] = Yii::app()->input->stripClean($_POST['ModuleConfigForm']);
            $form->attributes = $_POST['ModuleConfigForm'];
        
            if ($form->validate()) {
                HSetting::Set('apiKey', $form->apiKey, 'dropbox');
                Yii::app()->user->setFlash('data-saved', Yii::t('DropboxModule.controllers_DropboxController', 'Saved'));
            }
        } else {
            $form->apiKey = HSetting::Get('apiKey', 'dropbox');
        }


        $this->render('moduleConfig', array('model' => $form));
    }
    
    
    
    public function actionUserConfig(){
    
        $this->subLayout = "application.modules_core.user.views.account._layout";
        $user = Yii::app()->user->getModel();
    
        $model = new UserConfigForm;
    
        if (isset($_POST['UserConfigForm'])) {
            $_POST['UserConfigForm'] = Yii::app()->input->stripClean($_POST['UserConfigForm']);
            $model->attributes = $_POST["UserConfigForm"];
    
            if ($model->validate()) {
    
                if($model->warningOnPosting != $user->getSetting("warningOnPosting", 'dropbox', HSetting::Get('warningOnPosting', 'dropbox'))){
    
                    $userSetting = UserSetting::model()->findByAttributes(array('name' => 'warningOnPosting', 'module_id'=>'dropbox', 'user_id'=>$user->id));
    
                    if($userSetting == null){
                        $userSetting = new UserSetting;
                        $userSetting->user_id = $user->id;
                        $userSetting->module_id = "dropbox";
                        $userSetting->name = "warningOnPosting";
                    }
    
                    $userSetting->value = $model->warningOnPosting;
                    $userSetting->save();
    
                    Yii::app()->user->setFlash('data-saved', Yii::t('DropboxModule.controllers_DropboxController', 'Saved'));
                }
    
            }
        }
    
        $model->warningOnPosting = $user->getSetting("warningOnPosting", 'dropbox', HSetting::Get('warningOnPosting', 'dropbox'));
    
        return $this->render('userConfig', array('model' => $model));
    }
}