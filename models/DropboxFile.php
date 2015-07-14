<?php

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
class DropboxFile extends HActiveRecord
{


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DropboxImage the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns all files belongs to a given HActiveRecord Object.
     * 
     * @param HActiveRecord $object
     * @return Array of DropboxImage instances
     */
    public static function getFilesOfObject(HActiveRecord $object)
    {
        return DropboxFile::model()->findAllByAttributes(array('object_id' => $object->getPrimaryKey(), 'object_model' => get_class($object)));
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dropbox_file';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('created_at, updated_at', 'safe'),
        );
    }

    /**
     * Add mix-ins to this model
     *
     * @return type
     */
    public function behaviors()
    {
        return array(
            'HUnderlyingObjectBehavior' => array(
                'class' => 'application.behaviors.HUnderlyingObjectBehavior',
                'mustBeInstanceOf' => array('HActiveRecord'),
            ),
        );
    }


    /**
     * Checks if given file can deleted.
     * 
     * If the file is not an instance of HActiveRecordContent or HActiveRecordContentAddon
     * the file is readable for all unless there is method canWrite or canDelete implemented.
     */
    public function canDelete($userId = "")
    {
        $object = $this->getUnderlyingObject();
        if ($object !== null && ($object instanceof HActiveRecordContent || $object instanceof HActiveRecordContentAddon)) {
            return $object->content->canWrite($userId);
        }

        // File is not bound to an object
        if ($object == null) {
            return true;
        }

        return false;
    }

}