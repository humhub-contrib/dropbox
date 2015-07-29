<?php

namespace humhub\modules\dropbox;

use Yii;
use humhub\modules\user\models\User;
use humhub\modules\dropbox\models\DropboxPost;

class Module extends \humhub\components\Module
{

    public function behaviors()
    {
        return [
            \humhub\modules\user\behaviors\UserModule::className(),
            \humhub\modules\space\behaviors\SpaceModule::className(),
        ];
    }

    /**
     * On build of a Profile Navigation, check if this module is enabled.
     * When enabled add a menu item
     *
     * @param type $event
     */
    public static function onProfileMenuInit($event)
    {
        $user = $event->sender->user;
        // Is Module enabled on this workspace?
        if ($user->isModuleEnabled('dropbox')) {
            $event->sender->addItem(array(
                'label' => Yii::t('DropboxModule.base', 'Add Dropbox files'),
                'url' => $user->createUrl('/dropbox/create/index'),
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'dropbox'),
            ));
        }
    }

    public function getConfigUrl()
    {
        return \yii\helpers\Url::to(['/dropbox/admin']);
    }

    /**
     * On build of a Space Navigation, check if this module is enabled.
     * When enabled add a menu item
     *
     * @param type $event
     */
    public static function onSpaceMenuInit($event)
    {
        $space = $event->sender->space;
        if ($space->isModuleEnabled('dropbox')) {
            $event->sender->addItem(array(
                'label' => Yii::t('DropboxModule.base', 'Add Dropbox files'),
                'url' => $space->createUrl('/dropbox/create/index'),
                'icon' => '<i class="fa fa-dropbox"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'dropbox')
            ));
        }
    }

    public function disableSpaceModule(Space $space)
    {
        foreach (DropboxPost::find()->contentContainer($space)->all() as $post) {
            $post->delete();
        }
    }

    public function disableUserModule(User $user)
    {
        foreach (DropboxPost::find()->contentContainer($user)->all() as $post) {
            $post->delete();
        }
    }

    /**
     * Returns the user module config url.
     *
     * @return String
     */
    public function getUserModuleConfigUrl(User $user)
    {
        return $user->createUrl('/dropbox/user');
    }

    public function disable()
    {
        if (parent::disable()) {

            foreach (DropboxPost::find()->all() as $post) {
                $post->delete();
            }

            return true;
        }

        return false;
    }

}

?>