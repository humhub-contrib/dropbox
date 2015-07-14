<?php

class DropboxModule extends HWebModule
{

    private $assetsUrl;

    public function getAssetsUrl()
    {
        if ($this->assetsUrl === null)
            $this->assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('dropbox.assets'));
        return $this->assetsUrl;
    }
    
    public function behaviors()
    {
        return array(
            'SpaceModuleBehavior' => array(
                'class' => 'application.modules_core.space.behaviors.SpaceModuleBehavior',
            ),
            'UserModuleBehavior' => array(
                'class' => 'application.modules_core.user.behaviors.UserModuleBehavior',
            ),
        );
    }
    
    
    /**
     * On build of a Profile Navigation, check if this module is enabled.
     * When enabled add a menu item
     *
     * @param type $event
     */
    public static function onProfileMenuInit($event)
    {
        $user = Yii::app()->getController()->getUser();
    
        // Is Module enabled on this workspace?
        if ($user->isModuleEnabled('dropbox')) {
            $event->sender->addItem(array(
                'label' => Yii::t('DropboxModule.base', 'Add Dropbox files'),
                'url' => Yii::app()->createUrl('/dropbox/create/index', array('uguid' => $user->guid)),
                'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'dropbox'),
            ));
        }
    }
    
    
    public function getConfigUrl()
    {
        return Yii::app()->createUrl('//dropbox/config/moduleConfig');
    }

    
    /**
     * On build of a Space Navigation, check if this module is enabled.
     * When enabled add a menu item
     *
     * @param type $event
     */
    public static function onSpaceMenuInit($event)
    {
        $space = Yii::app()->getController()->getSpace();
        if ($space->isModuleEnabled('dropbox')) {
            $event->sender->addItem(array(
                'label' => Yii::t('DropboxModule.base', 'Add Dropbox files'),
                'url' => Yii::app()->createUrl('/dropbox/create/index', array('sguid' => $space->guid)),
                'icon' => '<i class="fa fa-dropbox"></i>',
                'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'dropbox')
            ));
    
        }
    }
    
    public function disableSpaceModule(Space $space)
    {
        foreach (Content::model()->findAllByAttributes(array('space_id' => $space->id, 'object_model' => 'DropboxPost')) as $content) {
            $content->delete();
        }
    }
    
    public function disableUserModule(User $user)
    {
        foreach (Content::model()->findAllByAttributes(array('created_by' => $user->id, 'object_model' => 'DropboxPost')) as $content) {
            $content->delete();
        }
    }
    
    /**
     * Returns the user module config url.
     *
     * @return String
     */
    public function getUserModuleConfigUrl(User $user)
    {
        return Yii::app()->createUrl('//dropbox/config/userConfig', array(
            'uguid' => $user->guid,
        ));
    }

    
    public function disable()
    {
        if (parent::disable()) {
            foreach (Content::model()->findAll(array(
                'condition' => 'object_model=:dropbox_post',
                'params' => array(':dropbox_post' => 'DropboxPost'))) as $content) {
                $content->delete();
            }
            return true;
        }
        throw new CHttpException(404);
        return false;
    }
}
?>