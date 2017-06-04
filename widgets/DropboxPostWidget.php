<?php

namespace humhub\modules\dropbox\widgets;

/**
 * This widget is used to show a dropbox post wall entry
 *
 * @package humhub.modules.dropbox.widgets
 * @since 0.10
 */
class DropboxPostWidget extends \humhub\modules\content\widgets\WallEntry
{

    public $editRoute = "/dropbox/index/edit";

    public function run()
    {

        return $this->render('dropboxPost', array(
                    'object' => $this->contentObject,
        ));
    }

}

?>