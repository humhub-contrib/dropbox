<?php
humhub\modules\dropbox\Assets::register($this);

use humhub\modules\dropbox\models\DropboxFile;
use humhub\models\Setting;

//setting javascript variables
$this->registerJsVar('file_delete_url', yii\helpers\Url::to(['/dropbox/index/delete-file']));
$this->registerJsVar('dropbox_add_image', yii\helpers\Url::to(['/dropbox/index/add-file']));
$this->registerJsVar('dropbox_warning_setting_url', yii\helpers\Url::to(['/dropbox/index/skip-warning']));
$this->registerJsVar('showWarning', $user->getSetting("warningOnPosting", 'dropbox', Setting::Get('warningOnPosting', 'dropbox')));
$this->registerJsVar('appKey', Setting::Get('apiKey', 'dropbox'));
$this->registerJsVar('listId', $this->context->inputId);
$this->registerJsVar('openIcon', $this->context->openIcon);

//setting text values for sharing private files modal
$this->registerJsVar('warning_on_posting_modal_title', Yii::t('DropboxModule.widgets_DropboxFileListerWidget', '<strong>Attention!</strong> You are sharing private files'));
$this->registerJsVar('warning_on_posting_modal_message', Yii::t('DropboxModule.widgets_DropboxFileListerWidget', 'The files you want to share are private. In order to share files in your space we have generated a shared link. Everyone with the link can see the file.<br/>Are you sure you want to share?'));
$this->registerJsVar('unset_warning_on_posting_checkbox_label', Yii::t('DropboxModule.widgets_DropboxFileListerWidget', 'Do not show this warning in future'));
$this->registerJsVar('warning_on_posting_modal_confirm', Yii::t('DropboxModule.widgets_DropboxFileListerWidget', "Yes, I'm sure"));
$this->registerJsVar('warning_on_posting_modal_cancel', Yii::t('DropboxModule.widgets_DropboxFileListerWidget', 'Cancel'));
?>
<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="<?php echo Setting::Get('apiKey', 'dropbox'); ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        init();
<?php
foreach (explode(",", $currentValue) as $id) :
    $dropboxFile = DropboxFile::findOne(['dropbox_file.id' => trim($id)]);
    if ($dropboxFile != null) :
        ?>
                addToFileList("<?php echo $dropboxFile->id; ?>", "<?php echo $dropboxFile->name; ?>");
        <?php
    endif;
endforeach;
?>
    });
</script>