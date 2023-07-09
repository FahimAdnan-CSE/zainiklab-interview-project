@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-header">Customer Profile</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <img src="{{ asset($customer->avatar) }}" alt="Avatar" class="avatar img-thumbnail">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-title">Name: {{ $customer->name }}</h5>
                                <p class="card-text">Email: {{ $customer->email }}</p>
                                <p class="card-text">About: {{ $customer->about }}</p>
                                <div class="share-profile-box">
                                    <p>Share Profile:</p>
                                    <div class="share-profile-link">
                                        <input id="share-link" type="text" class="form-control"
                                            value="{{ route('customer.profile', ['id' => $customer->id]) }}" readonly>
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-primary mt-2" onclick="copyShareLink()">Copy Link</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function copyShareLink() {
        var shareLink = document.getElementById('share-link');
        shareLink.select();
        shareLink.setSelectionRange(0, 99999);
        document.execCommand('copy');
        alert('Link copied to clipboard!');
    }
</script>
