<?php
namespace App\Services;

class ImageUploader
{
    
    public static function upload(array $postData, array $fileData, string $subfolder, ?string $oldImage = null): ?string
    {
        $uploadDir = 'uploads/' . $subfolder . '/';
        $targetDir = ROOT_PATH . '/public/' . $uploadDir;

        // echo "<pre>";
        // var_dump($postData);
        // echo "</pre>";
        // exit;
        
        if (!is_dir($targetDir)) {
            //echo 'criando pasta';
            mkdir($targetDir, 0775, true);
        }

        $imagePath = null;

        if (isset($postData['cropped_image_data']) && !empty($postData['cropped_image_data'])) {
            $data = $postData['cropped_image_data'];
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);

            $filename = uniqid('img_', true) . '.png';
            file_put_contents($targetDir . $filename, $data);
            $imagePath = $uploadDir . $filename;
        }
        elseif (isset($fileData['imagem']) && $fileData['imagem']['error'] === UPLOAD_ERR_OK) {
            $file = $fileData['imagem'];
            $filename = uniqid() . '_' . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $targetDir . $filename);
            $imagePath = $uploadDir . $filename;
        }

        if ($imagePath && $oldImage) {
            self::delete($oldImage);
        }
        
        return $imagePath;
    }

    public static function delete(?string $imagePath): void
    {
        if ($imagePath && file_exists(ROOT_PATH . '/public/' . $imagePath)) {
            unlink(ROOT_PATH . '/public/' . $imagePath);
        }
    }
}