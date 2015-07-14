<?php

class uninstall extends ZDbMigration
{

    public function up()
    {
        $this->delete('notification', 'source_object_model=:dropboxPost', array(':dropboxPost' => 'DropboxPost'));
        
        foreach (Content::model()->findAll(array(
            'object_model' => 'DropboxPost')) as $content) 
            $content->delete();
   
        $this->delete('setting', array('module_id' => 'dropbox'));
        $this->delete('user_setting', array('module_id' => 'dropbox'));
        
        $this->dropTable('dropbox_post');
        $this->dropTable('dropbox_file');
    }

    public function down()
    {
        echo "m150317_131255_initial does not support migration down.\n";
        return false;
    }
}
?>