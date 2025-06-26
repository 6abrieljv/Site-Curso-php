<?php

namespace App\Services;

class ImageUploader
{
    /**
     * Processa o upload de uma imagem, seja por arquivo ou por dados Base64 do Cropper.js.
     *
     * @param array $postData Dados de $_POST, que podem conter a imagem Base64.
     * @param array $fileData Dados de $_FILES.
     * @param string $subfolder A subpasta dentro de 'public/uploads/'.
     * @param string|null $oldImage O caminho da imagem antiga a ser deletada.
     * @param string|null $desiredName Um nome de arquivo desejado (sem extensão).
     * @return string|null O caminho da nova imagem salva ou null se não houver upload.
     */
    public static function upload(array $postData, array $fileData, string $subfolder, ?string $oldImage = null, ?string $desiredName = null): ?string
    {
        $uploadDir = 'uploads/' . $subfolder . '/';
        $targetDir = ROOT_PATH . '/public/' . $uploadDir;

        // Garante que o diretório de destino exista.
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
                throw new \RuntimeException(sprintf('O diretório "%s" não pôde ser criado. Verifique as permissões da pasta "public".', $targetDir));
            }
        }

        $imagePath = null;
        $filename = '';

        // **CORREÇÃO DEFINITIVA AQUI**:
        // 1. Procura primeiro pela imagem recortada em 'cropped_image_data'.
        if (isset($postData['cropped_image_data']) && !empty($postData['cropped_image_data'])) {
            $data = $postData['cropped_image_data'];
            list(, $data) = explode(',', $data); // Remove o prefixo 'data:image/png;base64,'
            $data = base64_decode($data);

            // Cria um nome de arquivo único para a imagem .png
            $filename = ($desiredName ? $desiredName : uniqid('img_', true)) . '.png';
            
            // Salva o arquivo decodificado
            file_put_contents($targetDir . $filename, $data);
            $imagePath = $uploadDir . $filename;

        // 2. Se não houver imagem recortada, procura por um upload de arquivo tradicional.
        } elseif (isset($fileData['imagem']) && $fileData['imagem']['error'] === UPLOAD_ERR_OK) {
            $file = $fileData['imagem'];
            
            // Usa o nome desejado ou gera um nome único para o arquivo.
            if ($desiredName) {
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = $desiredName . '.' . $extension;
            } else {
                $filename = uniqid() . '_' . basename($file['name']);
            }
            
            // Move o arquivo enviado.
            move_uploaded_file($file['tmp_name'], $targetDir . $filename);
            $imagePath = $uploadDir . $filename;
        }

        // 3. Se uma nova imagem foi salva e uma antiga existia, remove a antiga para não deixar lixo.
        if ($imagePath && $oldImage) {
            self::delete($oldImage);
        }

        return $imagePath;
    }

    /**
     * Deleta um arquivo de imagem do servidor.
     *
     * @param string|null $imagePath O caminho relativo da imagem (ex: 'uploads/atletica/imagem.png').
     */
    public static function delete(?string $imagePath): void
    {
        if ($imagePath && file_exists(ROOT_PATH . '/public/' . $imagePath)) {
            unlink(ROOT_PATH . '/public/' . $imagePath);
        }
    }
}
