@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-3">{{ __('Profile') }}</h2>
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>
</div>
@endsection
