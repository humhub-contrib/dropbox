<?php

namespace humhub\modules\dropbox;

use Yii;
use humhub\modules\user\models\User;
use humhub\modules\space\models\Space;
use humhub\modules\dropbox\models\DropboxPost;
use humhub\modules\content\components\ContentContainerModule;
use humhub\modules\content\components\ContentContainerActiveRecord;

class Module extends ContentContainerModule
{

    /**
     * @inheritdoc
     */
    public function getContentContainerTypes()
    {
        return [
            User::className(),
            Space::className(),
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

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function disableContentContainer(ContentContainerActiveRecord $container)
    {
        foreach (DropboxPost::find()->contentContainer($container)->all() as $post) {
            $post->delete();
        }
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerConfigUrl(ContentContainerActiveRecord $container)
    {
        if ($container instanceof User) {
            return $container->createUrl('/dropbox/user');
        }

        return "";
    }

    /**
     * @inheritdoc
     */
    public function disable()
    {
        foreach (DropboxPost::find()->all() as $post) {
            $post->delete();
        }
        
        parent::disable();
    }

}

?>