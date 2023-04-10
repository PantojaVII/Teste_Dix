@extends('layouts.app', ['page' => __('Icons'), 'pageSlug' => 'icons'])

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="padding: 8px">
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                    aria-expanded="false" aria-controls="collapseExample">
                    Cadastrar uma nova postagem
                </button>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <form method="post" action="{{ route('posts.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Título da postagem</label>
                                <input type="text" class="form-control" name="titulo_postagem" id="email_user"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Postagem</label>
                                <textarea class="form-control" rows="15" name="postagem"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </form>
                    </div>
                </div>
                <hr>
                <h1>Resultado</h1>
                @if (count($posts) > 0)
                    <table style="margin-left: 46px">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Conteúdo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->content }}</td>
                                    <td>
                                        <a href="{{ route('posts.show', ['id' => $post->id]) }}">Ver</a>
                                        <a href="{{ route('posts.editar', ['id' => $post->id]) }}">Editar</a>
                                        <form action="{{ route('posts.destroy', ['id' => $post->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger" type="submit">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Nenhuma postagem encontrada.</p>
                @endif

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
@endsection
