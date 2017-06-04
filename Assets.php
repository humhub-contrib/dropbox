<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\dropbox;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }

    public $css = [
        'filelist.css'
    ];
    public $js = [
        'filelister.js'
    ];

}
