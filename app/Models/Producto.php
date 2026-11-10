<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'precio', 'stock', 'categoria_id', 'imagen'];

    protected $appends = ['imagen_url'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function getImagenUrlAttribute(): ?string
    {
        if (! $this->imagen) {
            return null;
        }

        return asset('storage/'.$this->imagen);
    }
}
