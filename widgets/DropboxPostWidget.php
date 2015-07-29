<?php

namespace humhub\modules\dropbox\widgets;

/**
 * This widget is used to show a dropbox post wall entry
 *
 * @package humhub.modules.dropbox.widgets
 * @since 0.10
 */
class DropboxPostWidget extends \humhub\components\Widget
{

    /**
     * The dropbox post 
     * object
     *
     * @var DropboxPost
     */
    public $object;

    /**
     * Executes the widget.
     */
    public function run()
    {

        return $this->render('dropboxPost', array(
                    'object' => $this->object,
        ));
    }

}

?>