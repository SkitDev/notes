@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $note->title }} - {{ $note->created_at->format('Y/m/d - H:i') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @markdown($note->note)
                </div>
            </div>
        </div>
    </div>
@endsection
