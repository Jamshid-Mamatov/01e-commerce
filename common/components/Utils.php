<?php

namespace common\components;

use Exception;
use yii\base\Component;

class Utils extends Component
{


    public static function uploadImage(
        $image,
        $outputFolder = "uploads",
        $generateImageId = null
    )
    {
//        self::printAsError($image);
        if (!$image || !$image->tempName) {
            return false;
        }

        if (!is_dir($outputFolder)) {
            if (!mkdir($outputFolder, 0755, true)) {
                throw new Exception(
                    "Failed to create upload directory: $outputFolder"
                );
            }
        }

        $filename = $generateImageId
            ? $generateImageId($image) . "." . $image->extension
            : $image->baseName . uniqid() . "." . $image->extension;
        $filePath = $outputFolder . "/" . $filename;
//        Utils::printAsError($filePath);
        if (!$image->saveAs($filePath)) {
            throw new Exception("Failed to save uploaded image to $filePath");
        }


        return $filePath;
    }

    public static function printAsError($data, $die = true)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        if ($die) die;
    }
}