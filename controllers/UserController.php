<?php

namespace humhub\modules\dropbox\controllers;

use Yii;
use humhub\models\Setting;
use humhub\modules\dropbox\models\UserConfigForm;

/**
 * Config Controller
 *
 * @package humhub.modules.dropbox.controllers
 * @author Marjana Pesic
 */
class UserController extends \humhub\modules\content\components\ContentContainerController
{

    public function actionIndex()
    {
        $model = new UserConfigForm;

        $model->warningOnPosting = Yii::$app->user->getIdentity()->getSetting("warningOnPosting", 'dropbox', Setting::Get('warningOnPosting', 'dropbox'));

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->user->getIdentity()->setSetting('warningOnPosting', ($model->warningOnPosting) ? "1" : "0", 'dropbox');
        }
        return $this->render('index', array('model' => $model));
    }

}
