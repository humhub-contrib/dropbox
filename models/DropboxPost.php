<?php

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

class DropboxPost extends HActiveRecordContent
{

    public $autoAddToWall = true;
    public $wallEditRoute = '//dropbox/index/edit';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DropboxPost the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dropbox_post';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('message', 'required'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('message, created_at, updated_at', 'safe'),
        );
    }

    public function relations() {
        return array(
            'files' => array(self::HAS_MANY, 'DropboxFile', 'object_id', 'condition'=>'object_model="DropboxPost"'),
            'user' => array(self::BELONGS_TO, 'User', 'created_by'),
        );
    }
    
    /**
     * Before Delete, remove LikeCount (Cache) of target object.
     * Remove activity
     */
    protected function beforeDelete()
    {

        Notification::remove('DropboxPost', $this->id);

        return parent::beforeDelete();
    }

    /**
     * Before Save Addons
     *
     * @return type
     */
    public function afterSave()
    {

        parent::afterSave();

        if ($this->isNewRecord) {
            $activity = Activity::CreateForContent($this);
            $activity->type = "DropboxPostCreated";
            $activity->module = "dropbox";
            $activity->save();
            $activity->fire();
        }

        // Handle mentioned users
        //UserMentioning::parse($this, $this->message);
        
        return true;
    }
    
    public function getWallOut()
    {
        return Yii::app()->getController()->widget('application.modules.dropbox.widgets.DropboxPostWidget', array('object' => $this), true);
    }


    /**
     * Returns a title/text which identifies this IContent.
     *
     * e.g. Post: foo bar 123...
     *
     * @return String
     */
    public function getContentTitle()
    {
        return Yii::t('DropboxModule.models_DropboxPost', 'Dropbox post') . " \"" . Helpers::truncateText($this->message, 60) . "\"";
    }

}
