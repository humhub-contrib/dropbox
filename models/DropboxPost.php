<?php

namespace humhub\modules\dropbox\models;

use Yii;
use humhub\modules\search\interfaces\Searchable;

/**
 * This is the model class for table "dropbox_post".
 *
 * The followings are the available columns in table 'dropbox_post':
 * @property integer $id
 * @property string $message
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @package humhub.modules.dropbox.models
 * @since 0.5
 */
class DropboxPost extends \humhub\modules\content\components\ContentActiveRecord implements Searchable
{

    public $autoAddToWall = true;
    public $wallEntryClass = "humhub\modules\dropbox\widgets\DropboxPostWidget";

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'dropbox_post';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('message', 'required'),
            array('message', 'safe'),
        );
    }

    public function getFiles()
    {
        return $this->hasMany(DropboxFile::className(), ['object_id' => 'id'])->andWhere(['dropbox_file.object_model' => DropboxPost::className()]);
    }

    public function getContentName()
    {
        return Yii::t('DropboxModule.models_DropboxPost', 'Dropbox post');
    }

    public function getContentDescription()
    {
        return$this->message;
    }

    /**
     * @inheritdoc
     */
    public function getSearchAttributes()
    {
        $fileNames = "";

        foreach($this->files as $file) {
            $fileNames .= $file->name;
        }

        return array(
            'message' => $this->message,
            'fileNames' => $fileNames
        );
    }

}
