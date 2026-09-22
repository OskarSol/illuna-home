@if (session('status'))
    <div class="notice success" role="status">
        @switch(session('status'))
            @case('verification-link-sent') A new verification link has been sent to your email address. @break
            @case('profile-information-updated') Your profile has been saved. @break
            @case('password-updated') Your password has been updated. Other sessions have been signed out. @break
            @default {{ session('status') }}
        @endswitch
    </div>
@endif
@if ($errors->any() || $errors->getBag('updateProfileInformation')->any() || $errors->getBag('updatePassword')->any())
    <div class="notice error" role="alert" tabindex="-1" id="form-errors">
        <strong>Please check the following:</strong>
        <ul>
            @foreach ($errors->getBags() as $bag)
                @foreach ($bag->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endforeach
        </ul>
    </div>
@endif
