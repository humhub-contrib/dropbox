<?php

/**
 * @package humhub.modules.dropbox.forms
 * @since 0.5
 */
class CreateDropboxPostForm extends CFormModel {

    public $dropboxFileId;
    public $message;


    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('message, dropboxFileId', 'required'),
            array('dropboxFileId', 'checkDropboxFileId'),
        );
    }
    

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'message' => Yii::t('DropboxModule.forms_CreateDropboxPostForm', 'Message'),
        );
    }

    /**
     * This validator function checks the dropboxFileId.
     *
     * @param type $attribute
     * @param type $params
     */
    public function checkDropboxFileId($attribute, $params) {
    
        if ($this->dropboxFileId != "") {
    
            foreach (explode(',', $this->dropboxFileId) as $fileId) {
                if ($fileId != "") {
                    $dropboxFile = DropboxFile::model()->findByAttributes(array('id' => $fileId));
                    if ($dropboxFile == null) {
                        $this->addError($attribute, Yii::t('DropboxModule.forms_CreateDropboxPostForm', "Invalid file"));
                    }
                }
            }
        }
    }
}