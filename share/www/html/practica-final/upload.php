<?php

require('vendor/autoload.php');

$storeFolder = 'uploads';

if (!empty($_FILES)) {

    /** @var string $tempFile */
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname( __FILE__ ) . '/'. $storeFolder . '/';
    $targetFile =  $targetPath. $_FILES['file']['name'];
    move_uploaded_file($tempFile,$targetFile);

    // EXAMPLE OF USAGE OF GUMLET/IMAGERESIZE
    /*try {
        $path_parts = pathinfo($targetFile);
        $image = new \Gumlet\ImageResize($targetFile);
        $image->scale(1);
        $image->save($targetPath . $path_parts['filename'] . '_resize.' . $path_parts['extension']);
    } catch (\Gumlet\ImageResizeException $e) {
        error_log($e->getMessage());
    }*/
}

?>