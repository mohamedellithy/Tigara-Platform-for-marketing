<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="الكسيبة هو موقع للعمل كتاجر اونلاين عن طريق التسويق لى منتاجات الموقع و تحقيق الارباح من خلال بيعها">
    <meta name="keywords" content="الكسيبة,الكسيبه,alkaseba">
    <meta name="author" content="الكسيبة">
    <link rel="icon" href="{{ asset('assets/landing/icons/el-kasseba-logo-small.png') }}">
    <title>الكسيبة</title>
    <link href="{{ asset('assets/landing/styles/bootstrap-5.0.2/dist/css/bootstrap-grid.rtl.min.css') }}"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/landing/styles.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/landing/styles/header.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/landing/styles/welcome-view.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/landing/styles/process-section.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/styles/why-section.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/styles/last-section.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/styles/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/styles/loader.css') }}">
    <link href="//vjs.zencdn.net/7.10.2/video-js.min.css" rel="stylesheet">
    <script src="//vjs.zencdn.net/7.10.2/video.min.js"></script>
</head>

<body>
    <div id="content-container">
        <header>
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-6 col-md-9 logo-sections">
                        <div style="display: flex; align-items: center; justify-content: center; margin: 4px 0;">
                            <img width="140" height="52" class="logo"
                                src="{{ asset('assets/landing/images/tigara-trans.png') }}" alt="logo-alkseba">
                        </div>
                        <div class="header-sections">
                            <div class="div-FAQ header-section">
                                <a class="FAQ-button" href="#welcome">الرئيسية</a>
                            </div>
                            <div class="div-FAQ header-section">
                                <a class="FAQ-button" href="#steps">الخطوات</a>
                            </div>
                            <div class="div-FAQ header-section">
                                <a class="FAQ-button" href="#why">ليه الكسيبة</a>
                            </div>
                            <div class="div-FAQ header-section ">
                                <a class="FAQ-button" href="{{ asset('assets/landing/Help/Help-page.html') }}">مساعدة
                                    <img class="px-1" src="{{ asset('assets/landing/icons/help-circle.svg') }}"
                                        alt="help-circle"></a>
                            </div>
                        </div>
                    </div>
                    <div class="login-and-social col-5 col-md-3 justify-content-end">
                        <div class="div-login col-12 ">
                            <a class="header-button" href="https://seller.alkaseba.com/">تسجيل الدخول</a>
                            <a class="header-button" href="https://seller.alkaseba.com/">انشاء حساب</a>
                        </div>

                    </div>
                </div>
                <div class="row ">
                    <div class="header-sections-MV">
                        <div class="div-FAQ header-section">
                            <a class="FAQ-button" href="#welcome">الرئيسية</a>
                        </div>
                        <div class="div-FAQ header-section">
                            <a class="FAQ-button" href="#steps">الخطوات</a>
                        </div>
                        <div class="div-FAQ header-section">
                            <a class="FAQ-button" href="#why">ليه الكسيبة</a>
                        </div>
                        <div class="div-FAQ header-section ">
                            <a class="FAQ-button" href="{{ asset('assets/landing/Help/Help-page.html') }}">مساعدة <img
                                    class="px-1" src="{{ asset('assets/landivideosng/icons/help-circle.svg') }}"
                                    alt="help-circle"></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section class="welcome-view tracking-section" id="welcome">
            <div class="custom-shape-divider-bottom">
                {{-- <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
                </svg> --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
                    <path fill="#0099ff" fill-opacity="1"
                        d="M0,32L80,74.7C160,117,320,203,480,250.7C640,299,800,309,960,288C1120,267,1280,213,1360,186.7L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"
                        class="shape-fill"></path>
                </svg>
            </div>
            <div class="container">
                <div class="row">
                    <div class="div-welcome col-12 col-md-6">
                        <h1 class="headline"> منصة تجارة </h1>
                        <h2 id="headline-tab" class="welcome-headline">
                            <span class="TypeOn active">
                                حقق حلمك و ابدأ البيع
                            </span>
                            <span class="TypeOn">
                                حقق حلمك و ابدأ البيع 2
                            </span>
                        </h2>
                        <h4 class="welcome-subtext" data-i18n="landingPage.increaseIncome">
                            اشتغل وزوّد دخلك وانت قاعد فى مكانك
                        </h4>
                    </div>
                    <div class="div-form col-12 col-md-6">
                        <video id="my-player" class="video-js" controls preload="auto"
                            poster="//vjs.zencdn.net/v/oceans.png" data-setup='{}'>
                            <source src="{{ asset('assets/landing/videos/intro.webm') }}" type="video/webm">
                            <source src="{{ asset('assets/landing/videos/intro.Ogg') }}" type="video/ogg">
                            <source src="{{ asset('assets/landing/videos/intro.mp4') }}" type="video/mp4">
                            <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a
                                web browser that
                                <a href="https://videojs.com/html5-video-support/" target="_blank">
                                    supports HTML5 video
                                </a>
                            </p>
                        </video>
                    </div>
                </div>
            </div>
        </section>
        <section class="process-section tracking-section" id="steps">
            <h2 class="text" data-i18n="landingPage.wantToBeKaseeb">عايز تبقى كسيب ؟</h2>
            <div class="process-row">

                <img class="process-img" src="{{ asset('assets/landing/images/Mobile-login-pic.png') }}"
                    alt="Mobile login-bro">
                <img class="process-img-MV" src="{{ asset('assets/landing/images/Mobile-login-pic-MV.png') }}"
                    alt="Mobile login-bro">
                <img class="arrow" src="{{ asset('assets/landing/images/arrow.html') }}" alt="Mobile login-bro">

                <img class="process-img" src="{{ asset('assets/landing/images/choose-product.png') }}"
                    alt="Mobile login-bro">
                <img class="process-img-MV" src="{{ asset('assets/landing/images/choose-product-MV.png') }}"
                    alt="Mobile login-bro">
                <img class="arrow" src="{{ asset('assets/landing/images/arrow.html') }}" alt="Mobile login-bro">

                <img class="process-img" src="{{ asset('assets/landing/images/marketing-product.png') }}"
                    alt="Mobile login-bro">
                <img class="process-img-MV" src="{{ asset('assets/landing/images/marketing-product-MV.png') }}"
                    alt="Mobile login-bro">

            </div>
            <div class="process-row">
                <img class="process-img" src="{{ asset('assets/landing/images/write-customer-details.png') }}"
                    alt="Mobile login-bro">
                <img class="process-img-MV" src="{{ asset('assets/landing/images/write-customer-details-MV.png') }}"
                    alt="Mobile login-bro">
                <img class="arrow" src="{{ asset('assets/landing/images/arrow.html') }}" alt="Mobile login-bro">

                <img class="process-img" src="{{ asset('assets/landing/images/receive-ur-money.png') }}"
                    alt="Mobile login-bro">
                <img class="process-img-MV" src="{{ asset('assets/landing/images/receive-ur-money-MV.png') }}"
                    alt="Mobile login-bro">
                <img class="arrow" src="{{ asset('assets/landing/images/arrow.html') }}" alt="Mobile login-bro">

                <img class="process-gif" src="{{ asset('assets/landing/images/earnings.png') }}"
                    alt="Mobile login-bro">
            </div>

            <a class="signup-btn" href="#last-section" data-i18n="landingPage.startNow">ابدأ الان</a>


        </section>

        <section class="why-section tracking-section" id="why">
            <div class="section">
                <h2 class="text" data-i18n="landingPage.whyWorkWithKaseeba">ليه تشتغل مع الكسيبة ؟</h2>
                <ul class="why-list">
                    <li data-i18n="landingPage.highestSuccessRate">علشان عندنا اعلى معدل نجاح لتوصيل الأوردر و ده
                        هيضمنلك ارباحك</li>
                    <li data-i18n="landingPage.weTeachMarketing">هنعلمك تسوق ازاى علشان تقدر تبيع وتكسب من بيع منتجاتنا
                    </li>
                    <li data-i18n="landingPage.weOfferTechSupport">بنوفرلك دعم فنى متواجد دايما يساعدك على حل مشاكلك
                    </li>
                    <li data-i18n="landingPage.earnHighProfits">تقدر تحقق ارباح كبيرة لانك بتبيع بالسعر المناسب ليك
                    </li>
                </ul>
                <div>
                    <img class="why-img" src="{{ asset('assets/landing/images/line.svg') }}" alt="">
                </div>
            </div>
            <div class="section">
                <img class="why-img" src="{{ asset('assets/landing/images/why-pic.svg') }}" alt="why-pic">
            </div>

        </section>
        <div class="last-section tracking-section" id="last-section">
            <div class="text-area">
                <h2 class="text" data-i18n="landingPage.increaseIncome">اشتغل وزوّد دخلك وانت قاعد فى مكانك</h2>
            </div>
            <div style="display: flex; padding: 5%; justify-content: center;">
                <div class="form-signup col-12">
                    <h2 class="form-headline" data-i18n="landingPage.startNow">ابدأ دلوقتى</h2>
                    <div class="form-social-buttons">
                        <button type="button" class="button-1 facebookBTN" id="#facebookBTN-1">سجل عن طريق
                            فيسبوك<img class="px-1" src="{{ asset('assets/landing/icons/roundFacbook.svg') }}"
                                alt="roundFacbooklogo"></button>
                        <button type="button" class="button-1 gmailBTN">سجل عن طريق جوجل<img class="px-1"
                                src="{{ asset('assets/landing/icons/logos_google-gmail.svg') }}"
                                alt="logos_google-gmail"></button>
                    </div>
                    <form class="normal-signup" id="form-signup-2">
                        <h6 class="form-headline align-items-center " style="color: red; margin:0;">أو</h6>
                        <input class="form-input" type="text" name="name" placeholder="الاسم*">
                        <div id="name_error" class="error-hint-container"></div>
                        <input class="form-input" type="text" inputmode="tel" name="phone_number"
                            data-i18n="landingPage.phoneAsterisk" placeholder="الموبيل*">
                        <div id="phone_number_error" class="error-hint-container"></div>
                        <input class="form-input" type="text" inputmode="email" name="email"
                            data-i18n="landingPage.emailAsterisk" placeholder="الايميل*">
                        <div id="email_error" class="error-hint-container"></div>
                        <input class="form-input" type="password" name="password" placeholder="كلمة السر*">
                        <div id="password_error" class="error-hint-container"></div>
                        <input class="form-input" type="password" name="repassword"
                            data-i18n=landingPage.reEnterPasswordAsterisk placeholder="اعادة كتابة كلمة السر*">
                        <div id="repassword_error" class="error-hint-container"></div>
                        <button style="cursor: pointer;" class="normal-signup-button" type="submit"
                            data-i18n="landingPage.startNow" value="ابدأ دلوقتى">ابدأ دلوقتى</button>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <section class="logo-section col-m-12">
                <h2 class="footer-logo">الكسيبة</h2>
                <div class="text-section">
                    <a class="privacy-policy" id="privacy-policy">سياسة الخصوصية</a>
                </div>

            </section>
            <div class="login-and-social">
                <div class="div-social">
                    <a href="https://www.instagram.com/alkaseba/" class="social instagram-icon"><img
                            src="{{ asset('assets/landing/icons/logos_instagram.svg') }}" alt=""></a>
                    <a href="https://www.youtube.com/channel/UC9MSkyaE5xASpQ8GbdehqRg"
                        class="social youtube-icon"><img
                            src="{{ asset('assets/landing/icons/logos_youtube-icon.svg') }}" alt=""></a>
                    <a href="https://www.facebook.com/Alkaseba" class="social facebook-icon"><img
                            src="{{ asset('assets/landing/icons/logos_facebook.svg') }}" alt=""></a>
                </div>
                <div class="div-login">
                    <a class="header-button" href="https://seller.alkaseba.com/">تسجيل الدخول</a>
                </div>
            </div>
        </footer>
    </div>
    <script type="module" src="{{ asset('assets/landing/JS/main.js') }}"></script>
    <script>
        var player = videojs('my-player', {
            fluid: true,
            responsive: true,
            aspectRatio: "16:9",

        });
        player.userActive(false);
        // document.querySelectorAll('#headline-tab span').forEach(async function(ele){
        //     ele.classList.toggle('active');
        // });
        (async function(){
            await setInterval(async () => {
                await document.querySelector('#headline-tab span.active').classList.toggle('TypeOut');
                await document.querySelector('#headline-tab span.active').classList.toggle('TypeOn');
                // await document.querySelectorAll('#headline-tab span').forEach(async function(ele){
                //     await ele.classList.toggle('active');
                // });
            }, 5000);

            await setInterval(async () => {
                await document.querySelectorAll('#headline-tab span').forEach(async function(ele){
                    await ele.classList.toggle('active');
                });
            }, 10000);
        })();
    </script>
    <style>
        .vjs-has-started .vjs-control-bar {
            display: none !important;
        }

        .vjs-poster {
            background-position: 0 !important;
            background-size: cover !important;
        }

        .video-js .vjs-tech {
            object-fit: cover;
        }

        .video-js .vjs-big-play-button {
            text-align: center;
            background-color: #f37115;
            border-radius: 55px;
            height: 70px;
            margin: auto;
            border: 1px solid #f37115;
            font-size: 49px;
            width: 70px;
            box-shadow: 0px 0px 24px 0px gray;
        }
        .welcome-headline span{
            width: auto;
            white-space: nowrap;
            overflow: hidden;
            display: inline-flex;
            /* border-left: 4px solid orange; */

        }
        .welcome-headline span:not(.active){
           display: none;
        }

        .welcome-headline span.active.TypeOn{
            animation: TypeOn 2.5s forwards ease-in,TypeStop .5s step-end infinite;
             /* steps(30, end) */
        }

        .welcome-headline span.active.TypeOut{
            animation: TypeOut 1s forwards ease-in,TypeStop .5s step-end infinite;
            /* TypeStop .5s step-end infinite */
            /* steps(30, end) */
        }

        @keyframes TypeOn{
            from{
                width:0%;
                border-left: 4px solid orange;
            }
             to {
                width: 70%;
                border-left: 0px solid orange;
            }
        }

        @keyframes TypeOut{
            from{
                width:70%;
                border-left: 0px solid orange;
            }
            to {
                width: 0%;
                border-left: 4px solid orange;
            }
        }

        /* The typewriter cursor effect */
        @keyframes TypeStop {
            from, to { border-color: transparent }
            50% { border-color: orange }
        }

    </style>
</body>

<!-- Mirrored from alkaseba.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 25 Mar 2023 18:59:09 GMT -->

</html>
