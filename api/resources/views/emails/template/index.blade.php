<!DOCTYPE html>

<html lang="zxx" class="js">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Softnio" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta
      name="description"
      content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers."
    />
    <link
      rel="shortcut icon"
      href="https://dashlite.net/demo6/images/favicon.png"
    />
    <title>Email Templates | DashLite Admin Template</title>

    <link rel="stylesheet" href="../../../../public/assets/css/dashlite.css">
    <link rel="stylesheet" href="../../../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../../../public/assets/css/style-email.css">

  </head>
  <body class="nk-body npc-invest bg-lighter no-touch nk-nio-theme">
    <div class="nk-app-root">
      <div class="nk-wrap">
        <div class="nk-content nk-content-fluid">
          <div class="container-xl wide-xl">
            <div class="nk-content-inner">
              <div class="nk-content-body">
                <div class="content-page wide-md m-auto">
                    
                  <div class="nk-block">
                    <div class="card card-bordered">
                      <div class="card-inner">
                        <h4 class="title text-soft mb-4 overline-title">
                          Notification - Password Reset Template
                        </h4>
                        <table class="email-wraper">
                          <tbody>
                            <tr>
                              <td class="py-5">
                                <table class="email-header">
                                  <tbody>
                                    <tr>
                                      <td class="text-center pb-4">
                                        <a
                                          href="{{route('welcome')}}"
                                          ><img
                                            class="email-logo"
                                            src="{{asset('assets/images/logo/logo-dark2x.png')}}"
                                            alt="logo"
                                        /></a>
                                        <p class="email-title">
                                          @yield('subtitle')
                                        </p>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                @yield('mail-content')
                                <table class="email-footer">
                                  <tbody>
                                    <tr>
                                      <td class="text-center pt-4">
                                        <p class="email-copyright-text">
                                          Copyright © 2022 {{config('app.name')}}. All rights
                                          reserved. 
                                          <a
                                            href="#"
                                            >Invora</a
                                          >.
                                        </p>
                                        <ul class="email-social">
                                          <li>
                                            <a
                                              href="https://dashlite.net/demo6/email-templates.html#"
                                              ><img
                                                src="{{asset('assets/images/icons/facebook.png')}}"
                                                alt=""
                                            /></a>
                                          </li>
                                          <li>
                                            <a
                                              href="https://dashlite.net/demo6/email-templates.html#"
                                              ><img
                                                src="{{asset('assets/images/icons/twitter.png')}}"
                                                alt=""
                                            /></a>
                                          </li>
                                          <li>
                                            <a
                                              href="https://dashlite.net/demo6/email-templates.html#"
                                              ><img
                                                src="{{asset('assets/images/icons/youtube.png')}}"
                                                alt=""
                                            /></a>
                                          </li>
                                          <li>
                                            <a
                                              href="https://dashlite.net/demo6/email-templates.html#"
                                              ><img
                                                src="{{asset('assets/images/icons/medium.png')}}"
                                                alt=""
                                            /></a>
                                          </li>
                                        </ul>
                                        <p class="fs-12px pt-4">
                                          This email was sent to you as a
                                          registered member of
                                          <a href="{{route('welcome')}}"
                                            >{{config('app.url')}}</a
                                          >. To update your emails preferences
                                          <a
                                            href="{{route('welcome').'/forget-password'}}"
                                            >click here</a
                                          >.
                                        </p>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>

    <script src="../../../../public/assets/js/bundle.js"></script>
    <script src="../../../../public/assets/js/scripts.js"></script>
    <script src="../../../../public/assets/js/demo-settings.js"></script>
    
  </body>
</html>
