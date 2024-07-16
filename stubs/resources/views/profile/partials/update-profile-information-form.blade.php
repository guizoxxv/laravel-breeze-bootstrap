<div class="card">
    <div class="card-header">{{ __('Profile Information') }}</div>

    <div class="card-body">
        <form
            id="send-verification"
            class="d-none"
            method="post"
            action="{{ route('verification.send') }}"
        >
            @csrf
        </form>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">
                    {{ __('Name') }}
                </label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">
                    {{ __('Email') }}
                </label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="mb-0">
                                {{ __('Your email address is unverified.') }}

                                <button form="send-verification" class="btn btn-link p-0">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <div class="alert alert-success mt-3 mb-0" role="alert">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save') }}
                    </button>
                    @if (session('status') === 'profile-updated')
                        <span class="m-1 fade-out">{{ __('Saved.') }}</span>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
