@extends('emails/template.index')

@section('subtitle') Reset Password confirmation @endsection

@section('mail-content')

<table class="email-body text-center">
    <tbody>
        <tr>
            <td class="px-3 px-sm-5 pt-3 pt-sm-5 pb-3">
                <h2 class="email-heading">
                    Reset Password
                </h2>
            </td>
        </tr>
        <tr>
            <td class="px-3 px-sm-5 pb-2">
                <p>Hi Ishtiyak,</p>
                <p>
                    Click On The link blow to reset tour
                    password.<!-- $details['code'] -->
                </p>
                <a href="{{ $details['url'] }}" class="email-btn">RESET PASSWORD</a>
            </td>
        </tr>
        <tr>
            <td class="px-3 px-sm-5 pt-4 pb-3 pb-sm-5">
                <p>
                    If you did not make this request,
                    please contact us or ignore this
                    message.
                </p>
                <p class="email-note">
                    This is an automatically generated
                    email please do not reply to this
                    email. If you face any issues, please
                    contact us at help@dashlite.com
                </p>
            </td>
        </tr>
    </tbody>
</table>

@endsection