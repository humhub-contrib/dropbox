<?php

/**
 * @package humhub.modules.dropbox.widgets
 * @since 0.5
 * @author Luke
 */
class DropboxFileListerWidget extends HWidget {

    /**
     * Id of input element which should replaced
     *
     * @var type
     */
    public $inputId = "";

    /**
     * @var CModel the data model associated with this widget.
     */
    public $model = null;


    /**
     * @var string the attribute associated with this widget.
     * The name can contain square brackets (e.g. 'name[1]') which is used to collect tabular data input.
     */
    public $attribute = null;

    /**
     * Id of input element which opens dropbox chooser
     */
    public $openIcon = null;
    
    /**
     * Inits the File Lister
     *
     */
    public function init() {

        $assetPrefix = Yii::app()->assetManager->publish(dirname(__FILE__) . '/../resources', true, 0, defined('YII_DEBUG'));
        $user = Yii::app()->user->getModel();


        Yii::app()->clientScript->registerHtml('dropbox', '<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="'.HSetting::Get('apiKey', 'dropbox').'"></script>');

        //setting javascript variables
        Yii::app()->clientScript->setJavascriptVariable('file_delete_url', $this->createUrl('//dropbox/index/deleteFile'));
        Yii::app()->clientScript->setJavascriptVariable('dropbox_add_image', $this->createUrl('//dropbox/index/addFile'));
        Yii::app()->clientScript->setJavascriptVariable('dropbox_warning_setting_url', $this->createUrl('//dropbox/index/skipWarning'));
        Yii::app()->clientScript->setJavascriptVariable('showWarning', $user->getSetting("warningOnPosting", 'dropbox', HSetting::Get('warningOnPosting', 'dropbox')));
        Yii::app()->clientScript->setJavascriptVariable('appKey', HSetting::Get('apiKey', 'dropbox'));
        Yii::app()->clientScript->setJavascriptVariable('listId', $this->inputId);
        Yii::app()->clientScript->setJavascriptVariable('openIcon', $this->openIcon);

        //setting text values for sharing private files modal
        Yii::app()->clientScript->setJavascriptVariable('warning_on_posting_modal_title', Yii::t('DropboxModule.widgets_DropboxFileListerWidget', '<strong>Attention!</strong> You are sharing private files'));
        Yii::app()->clientScript->setJavascriptVariable('warning_on_posting_modal_message', Yii::t('DropboxModule.widgets_DropboxFileListerWidget', 'The files you want to share are private. In order to share files in your space we have generated a shared link. Everyone with the link can see the file.<br/>Are you sure you want to share?'));
        Yii::app()->clientScript->setJavascriptVariable('unset_warning_on_posting_checkbox_label', Yii::t('DropboxModule.widgets_DropboxFileListerWidget', 'Do not show this warning in future'));
        Yii::app()->clientScript->setJavascriptVariable('warning_on_posting_modal_confirm', Yii::t('DropboxModule.widgets_DropboxFileListerWidget', "Yes, I'm sure"));
        Yii::app()->clientScript->setJavascriptVariable('warning_on_posting_modal_cancel', Yii::t('DropboxModule.widgets_DropboxFileListerWidget', 'Cancel'));
        
        Yii::app()->clientScript->registerscriptFile($assetPrefix . '/filelister.js');
        Yii::app()->clientScript->registerCssFile( $assetPrefix . '/filelist.css' );
        
    }

    /**
     * Displays / Run the Widgets
     */
    public function run() {

        // Try to get current field value, when model & attribute attributes are specified.
        $currentValue = "";
        $user = Yii::app()->user->getModel();

        if ($this->model != null && $this->attribute != null) {
            $attribute = $this->attribute;
            $currentValue = $this->model->$attribute;
        }

        $this->render('filelister', array(
            'currentValue' => $currentValue,
            'inputId' => $this->inputId,
        ));
    }

}

?>