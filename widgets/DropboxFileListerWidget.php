<?php

namespace humhub\modules\dropbox\widgets;

use Yii;

/**
 * @package humhub.modules.dropbox.widgets
 * @since 0.5
 * @author Luke
 */
class DropboxFileListerWidget extends \yii\base\Widget
{

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
     * Displays / Run the Widgets
     */
    public function run()
    {

        // Try to get current field value, when model & attribute attributes are specified.
        $currentValue = "";
        $user = Yii::$app->user->getIdentity();

        if ($this->model != null && $this->attribute != null) {
            $attribute = $this->attribute;
            $currentValue = $this->model->$attribute;
        }

        return $this->render('filelister', array(
                    'currentValue' => $currentValue,
                    'inputId' => $this->inputId,
                    'user' => $user
        ));
    }

}

?>