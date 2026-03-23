<?php

return [
    'accepted'        => 'El campo :attribute debe ser aceptado.',
    'active_url'      => 'El campo :attribute no es una URL válida.',
    'after'           => 'El campo :attribute debe ser una fecha posterior a :date.',
    'attributes'      => [
        'nombre'           => 'nombre',
        'apellido'         => 'apellido',
        'cedula'           => 'cédula',
        'ciudad'           => 'ciudad',
        'fecha_nacimiento' => 'fecha de nacimiento',
        'codigo_unico'     => 'código del lote',
        'foto_codigo'      => 'foto del código',
        'foto_empaque'     => 'foto del empaque',
        'email'            => 'correo electrónico',
        'password'         => 'contraseña',
    ],
    'before'          => 'El campo :attribute debe ser una fecha anterior a :date.',
    'between'         => [
        'numeric' => 'El campo :attribute debe estar entre :min y :max.',
        'file'    => 'El archivo :attribute debe pesar entre :min y :max kilobytes.',
        'string'  => 'El campo :attribute debe tener entre :min y :max caracteres.',
    ],
    'confirmed'       => 'La confirmación de :attribute no coincide.',
    'date'            => 'El campo :attribute no es una fecha válida.',
    'email'           => 'El campo :attribute debe ser una dirección de correo válida.',
    'image'           => 'El campo :attribute debe ser una imagen.',
    'max'             => [
        'numeric' => 'El campo :attribute no debe ser mayor a :max.',
        'file'    => 'El campo :attribute no debe pesar más de :max kilobytes (2MB).',
        'string'  => 'El campo :attribute no debe tener más de :max caracteres.',
    ],
    'mimes'           => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'numeric'         => 'El campo :attribute debe ser un número.',
    'required'        => 'El campo :attribute es obligatorio.',
    'unique'          => 'El campo :attribute ya ha sido registrado.',
];