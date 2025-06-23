<?php

namespace App\Services;

class ImageUploader
{

public static function upload(array $postData, array $fileData, string $subfolder, ?string $oldImage = null, ?string $desiredName = null): ?string
    {
        $uploadDir = 'uploads/' . $subfolder . '/';
        $targetDir = ROOT_PATH . '/public/' . $uploadDir;

        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
                throw new \RuntimeException(sprintf('O diretório "%s" não pôde ser criado. Verifique as permissões da pasta "public".', $targetDir));
            }
        }

        $imagePath = null;
        $filename = '';

        // Lógica para imagem enviada como Base64 (JSON)
        if (isset($postData['image']) && !empty($postData['image'])) {
            $data = $postData['image'];
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);

            // Define o nome do arquivo: usa o slug se fornecido, senão, gera um nome único
            $filename = ($desiredName ? $desiredName : uniqid('img_', true)) . '.png';
            
            file_put_contents($targetDir . $filename, $data);
            $imagePath = $uploadDir . $filename;

        // Lógica para upload de arquivo tradicional (formulário)
        } elseif (isset($fileData['imagem']) && $fileData['imagem']['error'] === UPLOAD_ERR_OK) {
            $file = $fileData['imagem'];
            
            // Define o nome do arquivo: usa o slug com a extensão original, senão, gera um nome único
            if ($desiredName) {
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = $desiredName . '.' . $extension;
            } else {
                $filename = uniqid() . '_' . basename($file['name']);
            }
            
            move_uploaded_file($file['tmp_name'], $targetDir . $filename);
            $imagePath = $uploadDir . $filename;
        }

        // Se uma imagem nova foi salva e uma antiga existia, remove a antiga
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
