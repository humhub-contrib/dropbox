<?php

use yii\db\Schema;
use humhub\components\Migration;
use humhub\modules\dropbox\models\DropboxPost;

class m150729_113947_namespace extends Migration
{

    public function up()
    {
        $this->renameClass('DropboxPost', DropboxPost::className());
        $this->update('dropbox_file', ['object_model' => DropboxPost::className()]);

        foreach (\humhub\modules\activity\models\Activity::findAll(['module' => 'dropbox']) as $activity) {
            $activity->delete();
        }
    }

    public function down()
    {
        echo "m150729_113947_namespace cannot be reverted.\n";

        return false;
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
