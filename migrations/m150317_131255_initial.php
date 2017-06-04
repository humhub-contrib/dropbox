<?php

class m150317_131255_initial extends humhub\components\Migration
{

    public function up()
    {

        try {

            $this->createTable('dropbox_post', array(
                'id' => 'pk',
                'message' => 'text NOT NULL',
                'created_at' => 'datetime DEFAULT NULL',
                'created_by' => 'int(11) DEFAULT NULL',
                'updated_at' => 'datetime DEFAULT NULL',
                'updated_by' => 'int(11) DEFAULT NULL',
                    ), '');


            $this->createTable('dropbox_file', array(
                'id' => 'pk',
                'link' => 'varchar(512) NOT NULL',
                'name' => 'varchar(128) NOT NULL',
                'thumbnail_link' => 'varchar(512) NOT NULL',
                'object_model' => 'varchar(128) DEFAULT ""',
                'object_id' => 'varchar(128) DEFAULT ""',
                'created_at' => 'datetime DEFAULT NULL',
                'created_by' => 'int(11) DEFAULT NULL',
                'updated_at' => 'datetime DEFAULT NULL',
                'updated_by' => 'int(11) DEFAULT NULL',
                    ), '');


            $this->insert('setting', array('name' => 'warningOnPosting', 'value' => '1', 'module_id' => 'dropbox', 'created_at' => new yii\db\Expression('NOW()'), 'updated_at' => new yii\db\Expression('NOW()')));
        } catch (Exception $ex) {
            
        }
    }

    public function down()
    {
        echo "m150317_131255_initial does not support migration down.\n";
        return false;
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
