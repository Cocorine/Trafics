@extends('emails.template.index')

@section('subtitle') Registration email confirmation @endsection

@section('mail-content')

<table class="email-body">
    <tbody>
        <tr>
            <td class="px-3 px-sm-5 pt-3 pt-sm-5 pb-3">
                <h2 class="email-heading">
                    Confirm Your E-Mail Address
                </h2>
            </td>
        </tr>
        <tr>
            <td class="px-3 px-sm-5 pb-2">
                <p>Hi Ishtiyak,</p>
                <p>
                    Welcome! <br />
                    You are receiving this email because
                    you have registered on our site.
                </p>
                <p>
                    Click the link below to active your
                    DashLite account.
                </p>
                <p class="mb-4">
                    This link will expire in 15 minutes
                    and can only be used once.
                </p>
                <a href="#" class="email-btn">Verify Email</a>
            </td>
        </tr>
        <tr>
            <td class="px-3 px-sm-5 pt-4">
                <h4 class="email-heading-s2">or</h4>
                <p>
                    If the button above does not work,
                    paste this link into your web browser:
                </p>
                <a href="#" class="link-block">https://dashlite.com/account?login_token=dacb711d08a0ee7bda83ce1660918c31e8b43c30</a>
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