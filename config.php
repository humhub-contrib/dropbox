<?php

return [
    'id' => 'dropbox',
    'class' => 'humhub\modules\dropbox\Module',
    'namespace' => 'humhub\modules\dropbox',
    'events' => array(
        array('class' => humhub\modules\user\widgets\ProfileMenu::className(), 'event' => humhub\modules\user\widgets\ProfileMenu::EVENT_INIT, 'callback' => array('humhub\modules\dropbox\Module', 'onProfileMenuInit')),
        array('class' => \humhub\modules\space\widgets\Menu::className(), 'event' => \humhub\modules\space\widgets\Menu::EVENT_INIT, 'callback' => array('humhub\modules\dropbox\Module', 'onSpaceMenuInit')),
    ),
];
?>
