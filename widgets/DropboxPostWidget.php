<?php

/**
 * This widget is used to show a dropbox post wall entry
 *
 * @package humhub.modules.dropbox.widgets
 * @since 0.10
 */
class DropboxPostWidget extends HWidget
{

    /**
     * The dropbox post object
     *
     * @var DropboxPost
     */
    public $object;

    /**
     * Executes the widget.
     */
    public function run()
    {

        $this->render('dropboxPost', array(
            'object' => $this->object,
        ));
    }

}
?>