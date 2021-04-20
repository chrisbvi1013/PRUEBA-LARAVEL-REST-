<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Listado de libros</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <style>
             nav > div:nth-child(even){
                display: none;
            }
        </style>
    </head>
    <body class="antialiased">

        <div class="container">
            <div class="row">
                <div class="col-lg">
                    <div class="row">
                        <div class="col-lg">
                            <h3 style="text-align: center; margin: 1.2em 0 1em 0; text-transform: uppercase;">Listado de libros</h3>
                        </div>
                    </div>
                    @include('books.table')
                </div>
                {{ $books->links() }}

            </div>
        </div>

        @if(session()->has('ok'))
            <h1>borrado</h1>
        @endif
    </body>
</html>
