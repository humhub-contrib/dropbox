<?php

Yii::app()->moduleManager->register(array(
    'id' => 'dropbox',
    'class' => 'application.modules.dropbox.DropboxModule',
    'import' => array(
        'application.modules.dropbox.*',
        'application.modules.dropbox.widgets.*',
        'application.modules.dropbox.models.*',
        'application.modules.dropbox.forms.*',
    ),
    // Events to Catch 
    'events' => array(
        array('class' => 'ProfileMenuWidget', 'event' => 'onInit', 'callback' => array('DropboxModule', 'onProfileMenuInit')),
        array('class' => 'SpaceMenuWidget', 'event' => 'onInit', 'callback' => array('DropboxModule', 'onSpaceMenuInit')),
    ),
));
?>
