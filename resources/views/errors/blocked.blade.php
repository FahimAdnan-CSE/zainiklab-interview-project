@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Blocked') }}</div>

                    <div class="card-body">
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
