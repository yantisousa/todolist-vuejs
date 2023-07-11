<?php

namespace App\Http\Controllers;

use App\Models\Tarefas;
use Illuminate\Http\Request;

class TarefasController extends Controller
{
    public function store(Request $request)
    {
        Tarefas::create([
            'nome_tarefa' => $request->nome,
            'tempo_tarefa' => $request->tempo,
            'desc' => $request->descricao,
            'status' => 0,
            
        ]);
    }
    
    public function index($id) 
    {
        $tarefas = Tarefas::whereStatus($id)->get();
        return response()->json($tarefas);
    }

    public function update(Request $request, $id) 
    {
        $tarefas = Tarefas::find($id)->update(['status' => $request->status]);
        
    }
}
