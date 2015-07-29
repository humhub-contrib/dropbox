<?php
humhub\modules\dropbox\Assets::register($this);

use yii\helpers\Html;
?>

<?php $this->beginContent('@humhub/modules/content/views/layouts/wallLayout.php', array('object' => $object)); ?>

<div class="media">
    <span id="dropbox-post-content-<?php echo $object->id; ?>"
          style="overflow: hidden; margin-bottom: 5px;">
<?php print \humhub\widgets\RichText::widget(['text' => $object->message]); ?>
    </span>
    <br><br>
<?php foreach ($object->files as $file): ?>

        <table style="margin-bottom: 8px; margin-left: 15px;">
            <tr>
                <!-- File or photo icon -->
                <td style="vertical-align: top;">
                    <?php if (!$file->thumbnail_link): ?>
                        <i class="fa fa-file"></i<
                    <?php else: ?>
                        <i class="fa fa-photo"></i>
    <?php endif; ?>
                </td>


                <!-- File links and thumbnail if exists -->
                <td style="padding-left: 15px; padding-right: 15px;">
    <?php echo Html::a($file->name, $file->link, array('target' => '_blank')); ?>

                    <!-- Thumbnail -->
    <?php if ($file->thumbnail_link): ?>

                        <br /> <a href="<?php echo $file->link; ?>"><img class="img-rounded" src="<?php echo $file->thumbnail_link; ?>" />
                        </a>
    <?php endif; ?>
                    <br />
                </td>


            </tr>
        </table>

<?php endforeach; ?>


</div>

<?php $this->endContent(); ?>

