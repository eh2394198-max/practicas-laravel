<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * Procesa y guarda un archivo adjunto individual.
     */
    public function storeAttachment(UploadedFile $file, $postId)
    {
        // Generar nombre único
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // Guardar en la carpeta 'posts/{id}' dentro del disco 'public'
        $path = $file->storeAs('posts/' . $postId, $filename, 'public');

        // Registrar en la base de datos
        return Attachment::create([
            'post_id'       => $postId,
            'filename'      => $filename,
            'original_name' => $file->getClientOriginalName(),
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
            'path'          => $path,
        ]);
    }

    /**
     * PASO 2 (P4): Procesa múltiples archivos adjuntos.
     * Útil para cuando el input de la vista tiene el atributo 'multiple'.
     */
    public function storeMultipleAttachments(array $files, $postId)
    {
        $attachments = [];
        foreach ($files as $file) {
            $attachments[] = $this->storeAttachment($file, $postId);
        }
        return $attachments;
    }

    /**
     * Elimina un archivo físico individual y su registro en la DB.
     */
    public function deleteAttachment(Attachment $attachment)
    {
        Storage::disk('public')->delete($attachment->path);
        return $attachment->delete();
    }

    /**
     * PASO 3 (P4): Elimina físicamente todos los archivos de un post.
     * Se usa al borrar un Post completo para evitar "archivos huérfanos".
     */
    public function deleteAllPostFiles($postId)
    {
        return Storage::disk('public')->deleteDirectory('posts/' . $postId);
    }
}