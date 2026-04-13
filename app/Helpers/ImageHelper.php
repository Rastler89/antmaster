<?php

class ImageHelper {
    /**
     * Resizes and compresses an uploaded image.
     * 
     * @param array $file The $_FILES element
     * @param string $destinationFolder Path to the uploads directory
     * @param int $maxWidth Max width/height to resize to
     * @param int $quality Compression quality (0-100)
     * @return string|false Filename of the saved image or false on failure
     */
    public static function compress($file, $destinationFolder, $maxWidth = 1200, $quality = 80) {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return false;
        }

        $tmpName = $file['tmp_name'];
        $imageInfo = getimagesize($tmpName);
        
        if (!$imageInfo) {
            return false;
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $mime = $imageInfo['mime'];

        // Create image source based on mime type
        $srcImage = null;
        switch ($mime) {
            case 'image/jpeg':
                if (function_exists('imagecreatefromjpeg')) {
                    $srcImage = imagecreatefromjpeg($tmpName);
                }
                break;
            case 'image/png':
                if (function_exists('imagecreatefrompng')) {
                    $srcImage = imagecreatefrompng($tmpName);
                }
                if ($srcImage) {
                    imagepalettetotruecolor($srcImage);
                    imagealphablending($srcImage, true);
                    imagesavealpha($srcImage, true);
                }
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $srcImage = imagecreatefromwebp($tmpName);
                }
                break;
        }

        // FALLBACK: If GD is missing or image creation failed, just move the file
        if (!$srcImage) {
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('raw_', true) . '.' . $extension;
            $destination = rtrim($destinationFolder, '/') . '/' . $filename;
            if (!is_dir($destinationFolder)) mkdir($destinationFolder, 0777, true);
            return move_uploaded_file($tmpName, $destination) ? $filename : false;
        }

        // Calculate new dimensions maintain ratio
        $newWidth = $width;
        $newHeight = $height;

        if ($width > $maxWidth || $height > $maxWidth) {
            if ($width > $height) {
                $newWidth = $maxWidth;
                $newHeight = floor($height * ($maxWidth / $width));
            } else {
                $newHeight = $maxWidth;
                $newWidth = floor($width * ($maxWidth / $height));
            }
        }

        // Create destination image
        $dstImage = imagecreatetruecolor($newWidth, $newHeight);

        // Resample
        imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Generate filename
        // Change compression default to WEBP to save massive bandwidth and maintain transparency.
        $extension = 'webp';
        $filename = uniqid('img_', true) . '.' . $extension;
        $destination = rtrim($destinationFolder, '/') . '/' . $filename;

        // Ensure folder exists
        if (!is_dir($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }

        // Save as WEBP with compression
        if (function_exists('imagewebp')) {
             $result = imagewebp($dstImage, $destination, $quality);
        } else {
             // Fallback if webp is not compiled in GD
             $result = imagejpeg($dstImage, str_replace('.webp', '.jpg', $destination), $quality);
             if ($result) $filename = str_replace('.webp', '.jpg', $filename);
        }

        // Cleanup
        imagedestroy($srcImage);
        imagedestroy($dstImage);

        return $result ? $filename : false;
    }

    /**
     * Returns a user-friendly error message for PHP upload errors.
     */
    public static function getUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return "The file is too large (server limit).";
            case UPLOAD_ERR_FORM_SIZE:
                return "The file is too large (form limit).";
            case UPLOAD_ERR_PARTIAL:
                return "The file was only partially uploaded.";
            case UPLOAD_ERR_NO_FILE:
                return "No file was uploaded.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Missing a temporary folder.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Failed to write file to disk.";
            case UPLOAD_ERR_EXTENSION:
                return "A PHP extension stopped the file upload.";
            default:
                return "Unknown upload error.";
        }
    }
}
