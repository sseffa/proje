<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        Eğitim Platformu - Kayıt Ol
    </title>
    <meta name="description" content="Login">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="/assets/css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="/assets/css/app.bundle.css">
    <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
    <link id="myskin" rel="stylesheet" media="screen, print" href="/assets/css/skins/skin-master.css">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
    <link rel="mask-icon" href="/assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="stylesheet" media="screen, print" href="/assets/css/fa-brands.css">
</head>
<!-- BEGIN Body -->
<!-- Possible Classes

    * 'header-function-fixed'         - header is in a fixed at all times
    * 'nav-function-fixed'            - left panel is fixed
    * 'nav-function-minify'			  - skew nav to maximize space
    * 'nav-function-hidden'           - roll mouse on edge to reveal
    * 'nav-function-top'              - relocate left pane to top
    * 'mod-main-boxed'                - encapsulates to a container
    * 'nav-mobile-push'               - content pushed on menu reveal
    * 'nav-mobile-no-overlay'         - removes mesh on menu reveal
    * 'nav-mobile-slide-out'          - content overlaps menu
    * 'mod-bigger-font'               - content fonts are bigger for readability
    * 'mod-high-contrast'             - 4.5:1 text contrast ratio
    * 'mod-color-blind'               - color vision deficiency
    * 'mod-pace-custom'               - preloader will be inside content
    * 'mod-clean-page-bg'             - adds more whitespace
    * 'mod-hide-nav-icons'            - invisible navigation icons
    * 'mod-disable-animation'         - disables css based animations
    * 'mod-hide-info-card'            - hides info card from left panel
    * 'mod-lean-subheader'            - distinguished page header
    * 'mod-nav-link'                  - clear breakdown of nav links

    >>> more settings are described inside documentation page >>>
-->
<body class="mod-skin-dark">
<!-- DOC: script to save and load page settings -->
<script>
    /**
     *	This script should be placed right after the body tag for fast execution
     *	Note: the script is written in pure javascript and does not depend on thirdparty library
     **/
    'use strict';

    var classHolder = document.getElementsByTagName("BODY")[0],
        /**
         * Load from localstorage
         **/
        themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {},
        themeURL = themeSettings.themeURL || '',
        themeOptions = themeSettings.themeOptions || '';
    /**
     * Load theme options
     **/
    if (themeSettings.themeOptions)
    {
        classHolder.className = themeSettings.themeOptions;
        console.log("%c✔ Theme settings loaded", "color: #148f32");
    }
    else
    {
        console.log("%c✔ Heads up! Theme settings is empty or does not exist, loading default settings...", "color: #ed1c24");
    }
    if (themeSettings.themeURL && !document.getElementById('mytheme'))
    {
        var cssfile = document.createElement('link');
        cssfile.id = 'mytheme';
        cssfile.rel = 'stylesheet';
        cssfile.href = themeURL;
        document.getElementsByTagName('head')[0].appendChild(cssfile);

    }
    else if (themeSettings.themeURL && document.getElementById('mytheme'))
    {
        document.getElementById('mytheme').href = themeSettings.themeURL;
    }
    /**
     * Save to localstorage
     **/
    var saveSettings = function()
    {
        themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
        {
            return /^(nav|header|footer|mod|display)-/i.test(item);
        }).join(' ');
        if (document.getElementById('mytheme'))
        {
            themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
        };
        localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
    }
    /**
     * Reset settings
     **/
    var resetSettings = function()
    {
        localStorage.setItem("themeSettings", "");
    }

</script>
<div class="page-wrapper auth">
    <div class="page-inner bg-brand-gradient">
        <div style="padding-left: 0" class="page-content-wrapper bg-transparent m-0">
            <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                <div class="d-flex align-items-center container p-0">
                    <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                            <img src="/assets/img/logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                            <span class="page-logo-text mr-1">Eğitim Platformu</span>
                        </a>
                    </div>
                    <span class="text-white opacity-50 ml-auto mr-2 hidden-sm-down">
                                Zaten Üyeyim?
                            </span>
                    <a href="{{ route('login') }}" class="btn-link text-white ml-auto ml-sm-0">
                        Oturum Aç
                    </a>
                </div>
            </div>
            <div class="flex-1" style="background: url(/assets/img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                    <div class="row">
                        <div class="col-xl-12">
                            <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
                                Kaydolmak tamamen ücretsiz!
                                <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60 hidden-sm-down">
                                    Kaydınız sonsuza dek ücretsizdir. Platformun keyfini cep telefonunuzda, masaüstünüzde veya tabletinizde çıkarın.
                                    <br>Siz nerede olursanız olun, biz de oradayız!
                                </small>
                            </h2>
                        </div>
                        <div class="col-xl-6 ml-auto mr-auto">
                            <div class="card p-4 rounded-plus bg-faded">

                                <form method="POST" action="{{ route('register') }}" id="js-login">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-xl-12 form-label" for="first_name">Adınız</label>
                                        <div class="col-6 pr-1">
                                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Adınız" required>
                                            <div class="invalid-feedback">No, you missed this one.</div>
                                        </div>
                                        <div class="col-6 pl-1">
                                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Soyadınız" required>
                                            <div class="invalid-feedback">No, you missed this one.</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="emailverify">E-posta Adresiniz</label>
                                        <input type="email" id="emailverify" name="email" class="form-control" placeholder="E-posta Adresiniz" required>
                                        <div class="invalid-feedback">No, you missed this one.</div>
                                        <div class="help-block">Sisteme giriş için kullanılacak olan adresiniz</div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="emailverify">Kullanıcı Adınız</label>
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Kullanıcı Adınız" required>
                                        <div class="invalid-feedback">No, you missed this one.</div>
                                        <div class="help-block">Sistemde gözükecek bir takma ad belirleyiniz.</div>
                                    </div>


                                    <div class="form-group">
                                        <label class="form-label" for="password">Parolanızı belirleyin: <br>Tekrarlı rakamlar ve tahmin edilebilir parolalar kullanmayınız</label>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="En az 8 karakter" required>
                                        <div class="invalid-feedback">Sorry, you missed this one.</div>
                                        <div class="help-block">Parolanız en az 8 karakter olmalı, büyük-küçük harf, rakam ve özel karakterlerden oluşmalı</div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="password_confirmation">Parolanızı onaylayın: <br>Lütfen girdiğiniz parolayı tekrar girin.</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="En az 8 karakter" required>
                                        <div class="invalid-feedback">Sorry, you missed this one.</div>
                                    </div>

                                    <div class="form-group demo">

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="instructor" name="type" id="instructor">
                                            <label class="custom-control-label" for="instructor">Eğitmen olarak kaydol</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row no-gutters">
                                        <div class="col-md-4 ml-auto text-right">
                                            <button id="js-login-btn" type="submit" class="btn btn-block btn-danger btn-lg mt-3">Kayıt Ol</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                    {{ date('Y') }} © &nbsp;<a href='#' class='text-white opacity-40 fw-500' title='#' target='_blank'>127.0.0.1</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN Color profile -->
<!-- this area is hidden and will not be seen on screens or screen readers -->
<!-- we use this only for CSS color refernce for JS stuff -->
<p id="js-color-profile" class="d-none">
    <span class="color-primary-50"></span>
    <span class="color-primary-100"></span>
    <span class="color-primary-200"></span>
    <span class="color-primary-300"></span>
    <span class="color-primary-400"></span>
    <span class="color-primary-500"></span>
    <span class="color-primary-600"></span>
    <span class="color-primary-700"></span>
    <span class="color-primary-800"></span>
    <span class="color-primary-900"></span>
    <span class="color-info-50"></span>
    <span class="color-info-100"></span>
    <span class="color-info-200"></span>
    <span class="color-info-300"></span>
    <span class="color-info-400"></span>
    <span class="color-info-500"></span>
    <span class="color-info-600"></span>
    <span class="color-info-700"></span>
    <span class="color-info-800"></span>
    <span class="color-info-900"></span>
    <span class="color-danger-50"></span>
    <span class="color-danger-100"></span>
    <span class="color-danger-200"></span>
    <span class="color-danger-300"></span>
    <span class="color-danger-400"></span>
    <span class="color-danger-500"></span>
    <span class="color-danger-600"></span>
    <span class="color-danger-700"></span>
    <span class="color-danger-800"></span>
    <span class="color-danger-900"></span>
    <span class="color-warning-50"></span>
    <span class="color-warning-100"></span>
    <span class="color-warning-200"></span>
    <span class="color-warning-300"></span>
    <span class="color-warning-400"></span>
    <span class="color-warning-500"></span>
    <span class="color-warning-600"></span>
    <span class="color-warning-700"></span>
    <span class="color-warning-800"></span>
    <span class="color-warning-900"></span>
    <span class="color-success-50"></span>
    <span class="color-success-100"></span>
    <span class="color-success-200"></span>
    <span class="color-success-300"></span>
    <span class="color-success-400"></span>
    <span class="color-success-500"></span>
    <span class="color-success-600"></span>
    <span class="color-success-700"></span>
    <span class="color-success-800"></span>
    <span class="color-success-900"></span>
    <span class="color-fusion-50"></span>
    <span class="color-fusion-100"></span>
    <span class="color-fusion-200"></span>
    <span class="color-fusion-300"></span>
    <span class="color-fusion-400"></span>
    <span class="color-fusion-500"></span>
    <span class="color-fusion-600"></span>
    <span class="color-fusion-700"></span>
    <span class="color-fusion-800"></span>
    <span class="color-fusion-900"></span>
</p>
<!-- END Color profile -->
<!-- base vendor bundle:
     DOC: if you remove pace.js from core please note on Internet Explorer some CSS animations may execute before a page is fully loaded, resulting 'jump' animations
                + pace.js (recommended)
                + jquery.js (core)
                + jquery-ui-cust.js (core)
                + popper.js (core)
                + bootstrap.js (core)
                + slimscroll.js (extension)
                + app.navigation.js (core)
                + ba-throttle-debounce.js (core)
                + waves.js (extension)
                + smartpanels.js (extension)
                + src/../jquery-snippets.js (core) -->
<script src="/assets/js/vendors.bundle.js"></script>
<script src="/assets/js/app.bundle.js"></script>
<script>
    $("#js-login-btn").click(function(event)
    {

        // Fetch form to apply custom Bootstrap validation
        var form = $("#js-login")

        if (form[0].checkValidity() === false)
        {
            event.preventDefault()
            event.stopPropagation()
        }

        form.addClass('was-validated');
        // Perform ajax submit here...
    });

</script>
</body>
<!-- END Body -->
</html>
