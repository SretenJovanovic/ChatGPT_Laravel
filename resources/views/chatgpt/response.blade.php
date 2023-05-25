@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ url()->previous() }}" class="button">Go back</a>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ChatGPT answer</div>

                    <div class="card-body">
                        <p>{{ $response }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
