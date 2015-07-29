<?php

class uninstall extends yii\db\Migration
{

    public function up()
    {
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