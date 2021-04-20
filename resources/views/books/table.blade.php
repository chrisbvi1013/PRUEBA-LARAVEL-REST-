<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>ISBN</th>
            <th>Titulo</th>
            <th>Caratula</th>
            <th>Nro. autores</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
    @foreach($books as $book)
        <tr>
            <td>{{ $book->ISBN }}</td>
            <td>{{ $book->title }}</td>
            <td>{{ $book->cover_large ? $book->cover_large : 'N/A' }}</td>
            <td>{{ $book->authors->count() }}</td>
            <td>
                <form method="POST" action="{{ route('deleteBook', $book->ISBN) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <div class="form-group">
                        <input type="submit" class="material-icons deleteOption tooltipped"
                            value="borrar" data-position="right" data-tooltip="Eliminar">
                    </div>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>