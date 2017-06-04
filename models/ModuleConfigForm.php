<?php

namespace humhub\modules\dropbox\models;

use Yii;

class ModuleConfigForm extends \yii\base\Model
{

    public $apiKey;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('apiKey', 'required'),
            array('apiKey', 'string', 'max' => 250),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'apiKey' => Yii::t('DropboxModule.forms_ModuleConfigForm', 'Dropbox API Key'),
        );
    }

}
