<?php

namespace humhub\modules\dropbox\controllers;

use Yii;
use humhub\modules\dropbox\models\ModuleConfigForm;
use humhub\models\Setting;

/**
 * Config Controller
 *
 * @package humhub.modules.dropbox.controllers
 * @author Marjana Pesic
 */
class AdminController extends \humhub\modules\admin\components\Controller
{

    public function actionIndex()
    {

        $form = new ModuleConfigForm;
        $form->apiKey = Setting::Get('apiKey', 'dropbox');

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            Setting::Set('apiKey', $form->apiKey, 'dropbox');
        }

        return $this->render('index', array('model' => $form));
    }

}
