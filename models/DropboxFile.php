<?php

namespace humhub\modules\dropbox\models;

use humhub\components\ActiveRecord;

/**
 * This is the model class for table "dropbox_file".
 *
 * The followings are the available columns in table 'dropbox_file':
 * @property integer $id
 * @property string $link
 * @property string $name
 * @property string $thumbnail_link
 * @property string $object_model
 * @property integer $object_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @package humhub.modules.dropbox.models
 * @since 0.5
 */
class DropboxFile extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \humhub\components\behaviors\PolymorphicRelation::className(),
                'mustBeInstanceOf' => [
                    ActiveRecord::className(),
                ]
            ]
        ];
    }

    /**
     * Returns all files belongs to a given HActiveRecord Object.
     * 
     * @param HActiveRecord $object
     * @return Array of DropboxImage instances
     */
    public static function getFilesOfObject(HActiveRecord $object)
    {
        return DropboxFile::findAll(array('object_id' => $object->getPrimaryKey(), 'object_model' => get_class($object)));
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'dropbox_file';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name', 'string', 'max' => 128),
        );
    }

    public function beforeSave($insert)
    {

        if ($this->thumbnail_link == "") {
            $this->thumbnail_link = "";
        }

        return parent::beforeSave($insert);
    }

    /**
     * Checks if given file can deleted.
     * 
     * If the file is not an instance of HActiveRecordContent or HActiveRecordContentAddon
     * the file is readable for all unless there is method canWrite or canDelete implemented.
     */
    public function canDelete($userId = "")
    {
        $object = $this->getPolymorphicRelation();
        if ($object !== null && ($object instanceof \humhub\modules\content\components\ContentActiveRecord || $object instanceof \humhub\modules\content\components\ContentAddonActiveRecord)) {
            return $object->content->canWrite($userId);
        }

        // File is not bound to an object
        if ($object == null) {
            return true;
        }

        return false;
    }

}
