@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Disable') }}</div>

                    <div class="card-body">
                        <div class="alert alert-danger">
                            Your account has been disable.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
