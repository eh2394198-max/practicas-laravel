<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * Procesa y guarda un archivo adjunto[cite: 326].
     */
    public function storeAttachment(UploadedFile $file, $postId)
    {
        // Generar nombre único con uniqid() y tiempo [cite: 327, 328, 329]
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // Guardar en la carpeta 'posts/' dentro del disco 'public' [cite: 331]
        $path = $file->storeAs('posts/' . $postId, $filename, 'public');

        // Registrar en la base de datos [cite: 332, 333]
        return Attachment::create([
            'post_id'       => $postId, // [cite: 334]
            'filename'      => $filename, // [cite: 335]
            'original_name' => $file->getClientOriginalName(), // [cite: 336]
            'mime_type'     => $file->getMimeType(), // [cite: 338]
            'size'          => $file->getSize(), // [cite: 339]
            'path'          => $path, // [cite: 342]
        ]);
    }

    /**
     * Elimina el archivo físico y el registro de la DB[cite: 345].
     */
    public function deleteAttachment(Attachment $attachment)
    {
        Storage::disk('public')->delete($attachment->path); // [cite: 346]
        return $attachment->delete(); // [cite: 346]
    }
}