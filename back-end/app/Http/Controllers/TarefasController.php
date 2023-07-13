<?php

namespace App\Http\Controllers;

use App\Models\Tarefas;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Facades\Session as FacadesSession;

class TarefasController extends Controller
{
    public function store(Request $request)
    {
        Tarefas::create([
            'user_id' => Auth::user()->id,
            'nome_tarefa' => $request->nome,
            'tempo_tarefa' => $request->tempo,
            'desc' => $request->descricao,
            'status' => 0,
            
        ]);
    }
    
    public function index($id) 
    {
        $tarefas = Tarefas::whereStatus($id)->where('user_id', Auth::user()->id)->get();
        return response()->json($tarefas);
    }

    public function update(Request $request, Tarefas $id) 
    {
        if(!$request->tempo){
            $id->update(['status' => $request->status]);
            
        } else {
            $id->update(['status' => $request->status, 'tempo_tarefa_finalizada' => $request->tempo]);

        }
        
    }
    
    public function token() 
    {
        return response()->json(['_token' => csrf_token()]);
    }
}
