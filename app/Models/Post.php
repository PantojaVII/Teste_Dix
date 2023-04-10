<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts'; // Nome da tabela no banco de dados
    protected $fillable = ['title', 'content']; // Atributos preenchíveis em massa
    //use HasFactory;
}
