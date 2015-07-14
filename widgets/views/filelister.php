<script type="text/javascript">

init();

<?php 
foreach (explode(",", $currentValue) as $id) :
    $dropboxFile = DropboxFile::model()->findByPk(trim($id));
    if ($dropboxFile != null) :?>
        addToFileList("<?php echo $dropboxFile->id; ?>", "<?php echo $dropboxFile->name; ?>");
    <?php 
    endif;
endforeach; ?>
</script>