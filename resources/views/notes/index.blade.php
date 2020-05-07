@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Last update</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notes as $note)
                        <tr>
                        <th scope="row">{{ $note->id }}</th>
                            <td><a href="{{ route('notes.show', $note->id) }}" class="text-primary">{{ $note->title }}</a></td>
                            <td>{{ $note->created_at->format('d/m/Y - H:i') }}</td>
                            <td>
                                <form action="{{ route('notes.destroy', $note->id) }}" method="post" class="form-inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('notes.edit', $note->id)}}" class="btn btn-primary mr-4">Edit</a>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $notes->appends(request()->input())->links() }}
@endsection
