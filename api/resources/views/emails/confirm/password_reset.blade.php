@extends('emails.template.index')

@section('subtitle') Password reset @endsection

@section('mail-content')

<table class="email-body text-center">
    <tbody>
        <tr>
            <td class="px-3 px-sm-5 pt-3 pt-sm-5 pb-3">
                <h2 class="email-heading text-success">
                    Password Successfully Changed
                </h2>
            </td>
        </tr>
        <tr>
            <td class="px-3 px-sm-5">
                <p>Hi Ishtiyak,</p>
                <p>
                    You have successfully reseted your
                    password. Thanks for being with us.
                </p>
            </td>
        </tr>
        <tr>
            <td class="px-3 px-sm-5 pt-4 pb-3 pb-sm-5">
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