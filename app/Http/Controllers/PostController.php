<?php

namespace App\Http\Controllers;

use App\Models\Post as ModelsPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function store(Request $request)
    {
        // Obtenha o ID do usuário atualmente autenticado
        $userId = Auth::id();

        // Valide os dados do formulário
        $validator = Validator::make($request->all(), [
            'titulo_postagem' => 'required|unique:posts,title',
            'postagem' => 'required',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'O Título :attribute já está em uso.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('posts.index')
                ->with('error', 'Já existe uma postagem com esse nome, por favor, tente outra');
        }

        // Crie uma nova instância do model Post com os dados do formulário
        $post = new ModelsPost();
        $post->title = $request->input('titulo_postagem');
        $post->content = $request->input('postagem');
        $post->user_id = $userId; // Defina o valor do user_id

        // Salve a postagem no banco de dados
        $post->save();

        // Redirecione para a página de exibição da postagem ou para outra rota desejada
        return redirect()->route('posts.index')
            ->with('success', 'Postagem cadastrada com sucesso!');
    }


    public function index()
    {
        // Obtenha o ID do usuário autenticado
        $userId = auth()->id();

        // Busque as postagens feitas pelo usuário autenticado
        $posts = ModelsPost::where('user_id', $userId)->get();


        // Retorne a view de exibição das postagens, passando o objeto $posts para a view
        return view('pages.posts', ['posts' => $posts]);
    }
    public function show($id)
    {
        // Obtenha o ID do usuário autenticado
        $userId = auth()->id();

        // Busque a postagem pelo ID, filtrando pelo usuário autenticado
        $post = ModelsPost::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        // Verifique se a postagem foi encontrada
        if (!$post) {
            // Retorne uma resposta de erro, ou redirecione para outra página
            // ou faça qualquer outra ação desejada
            return redirect()->back()->with('error', 'Postagem não encontrada ou não pertence a você.');
        }

        // Retorne a view com a postagem encontrada
        return view('posts.postagem', ['post' => $post]);
    }
    public function editar($id)
    {
        // Obtenha o ID do usuário autenticado
        $userId = auth()->id();

        // Busque a postagem pelo ID, filtrando pelo usuário autenticado
        $post = ModelsPost::where('id', $id)
            ->where('user_id', $userId)
            ->first();
        // Verifique se a postagem foi encontrada
        if (!$post) {
            // Retorne uma resposta de erro, ou redirecione para outra página
            // ou faça qualquer outra ação desejada
            return redirect()->back()->with('error', 'Postagem não encontrada ou não pertence a você.');
        }
        return view('posts.editarPostagem', ['post' => $post]);
    }
    public function update(Request $request, $id)
    {
        // Validação dos dados do formulário
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Busca a postagem pelo ID
        $post = ModelsPost::findOrFail($id);

        // Atualiza os atributos da postagem com base nos dados do formulário
        $post->title = $request->input('title');
        $post->content = $request->input('content');

        // Salva a postagem atualizada no banco de dados
        $post->save();

        // Redireciona para a página de exibição da postagem
        return redirect()->route('posts.show', ['id' => $post->id]);
    }
    public function destroy($id)
    {
        // Lógica para excluir a postagem do banco de dados com base no ID
        $post = ModelsPost::find($id);
        if ($post) {
            $post->delete();
            // Redirecionar para a página de listagem de postagens ou para outra rota desejada
            return redirect()->route('posts.index')
                ->with('success', 'Postagem excluída com sucesso!');
        } else {
            // Postagem não encontrada, redirecionar para uma página de erro ou retornar uma resposta apropriada
            return redirect()->back()
                ->with('error', 'Postagem não encontrada!');
        }
    }
    public function search(Request $request)
    {
        // Obtenha o termo de busca do formulário
        $searchTerm = $request->input('search');

        // Obtenha o ID do usuário logado
        $userId = Auth::id();

        // Realize a busca no banco de dados com base no termo de busca e no ID do usuário
        $posts = ModelsPost::where('user_id', $userId)
            ->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', "%$searchTerm%")
                    ->orWhere('content', 'LIKE', "%$searchTerm%");
            })
            ->get();

        // Retorne a view com as postagens encontradas
        return view('posts.search', ['posts' => $posts]);
    }
}
