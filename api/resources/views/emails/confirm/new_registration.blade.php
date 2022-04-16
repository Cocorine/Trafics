@extends('emails.template.index')

@section('subtitle') Welcome to {{strtoupper(config('app.name'))}} @endsection

@section('mail-content')

<table class="email-body text-center">
    <tbody>
        <tr>
            <td class="px-3 px-sm-5 pt-3 pt-sm-5 pb-4">
                <img class="w-100px" src="{{asset('assets/images/kyc-success.png')}}" alt="Verified" />
            </td>
        </tr>
        <tr>
            <!-- 
            <td class="px-3 px-sm-5 pb-3 pb-sm-5">
                <h5 class="text-success mb-3">
                    Your Identity Verified.
                </h5>
                <p class="fs-16px text-base">
                    One fo our team verified your
                    indentity. You are now in whitelisted
                    for token sale.
                </p>

                <p>
                    Hope you'll enjoy the experience,
                    we're here if you have any questions,
                    drop us a line at {{config('mail.mailers.smtp.username')}}
                    anytime.
                </p>
            </td> -->

            <td class="px-3 px-sm-5 pb-3 pb-sm-5">
                <h5 class="text-success mb-3">
                    Your account is activated.
                </h5>

                <p>Hi Ishtiyak,</p>

                <p class="">
                    We are pleased to have you as a member of {{strtoupper(config('app.name'))}} Family.
                </p>
                <p class="mb-4">
                    Your account is now account so you can click the link below to log into your administration panel.
                </p>
                <p>
                    <a href="{{route('welcome').'/auths/login'}}" class="email-btn">Log In</a> 
                </p>
                <p class="email-note">
                    Hope you'll enjoy the experience, we're here if you have any questions, drop us a line at
                    <a href="mailto:{{config('mail.mailers.smtp.username')}}">{{config('mail.mailers.smtp.username')}}</a>
                    anytime.
                </p>
            </td>
        </tr>
    </tbody>
</table>

@endsection