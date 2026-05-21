<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostWithAttachmentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Obtenemos el ID del post si estamos en una edición
        $postId = $this->route('post') ? $this->route('post')->id : null;

        return [
            'name' => 'required|string|min:5|max:200',
            
            // MEJORA: Ignora el slug del post actual para que permita guardar cambios
            'slug' => [
                'required',
                'string',
                Rule::unique('posts', 'slug')->ignore($postId),
            ],
            
            'extract' => 'required|string|min:50',
            
            // Validaciones de archivos
            'attachments' => 'nullable|array|max:5', 
            'attachments.*' => 'file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El título es obligatorio.',
            'slug.unique' => 'Esta URL ya está en uso por otro post.',
            'extract.min' => 'El extracto debe tener al menos 50 caracteres para una mejor lectura.',
            'attachments.max' => 'No puedes subir más de 5 archivos por post.',
            'attachments.*.max' => 'Cada archivo es demasiado pesado (Máximo 5MB).',
            'attachments.*.mimes' => 'Tipo de archivo no permitido. Solo JPG, PNG, PDF y Word.',
        ];
    }
}