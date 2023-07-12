<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefas extends Model
{
    use HasFactory;
    protected $table;
    protected $fillable = ['user_id', 'nome_tarefa', 'desc', 'tempo_tarefa', 'tempo_tarefa_finalizada', 'status'];
}
