@extends('layouts.app', ['page' => __('Icons'), 'pageSlug' => 'icons'])

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="padding: 8px">

                <hr>
                <h1>Postagem </h1>
                <a href="{{ route('posts.index') }}">Voltar</a>
                <div style="padding: 24px">

                    @if (!is_null($post))
                        <h3>{{ $post->title }}</h3>
                        <p>{{ $post->content }}</p>
                    @else
                        <p>Postagem não encontrada.</p>
                    @endif

                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
@endsection
