@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                  Edit a note
                </div>
                <div class="card-body">
                    <form action="{{ route('notes.update', $note->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Enter the title" name="title" value="{{ $note->title }}">
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea class="form-control" id="note" name="note">{{ $note->note }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
