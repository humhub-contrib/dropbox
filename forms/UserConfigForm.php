<?php 

class UserConfigForm extends CFormModel {

    public $warningOnPosting;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('warningOnPosting', 'required'),
        );
    }
    

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'warningOnPosting' => Yii::t('DropboxModule.forms_UserConfigForm', 'Show warning on posting'),
        );
    }

    
}