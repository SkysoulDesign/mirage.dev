@include('auth.emails.css')
<div class="mailLayout">
    @include('auth.emails.header')
    <div class="mailContent">
        <h3>Dear {{ $user->username }},</h3>
        <p>You have requested to reset your account password.</p>
        <p>Please follow below link:<br/>
            <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">Reset Password</a>
        </p>
    </div>
    @include('auth.emails.footer')
</div>
