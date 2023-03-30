<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="تجارة هو موقع للعمل كتاجر اونلاين عن طريق التسويق لى منتاجات الموقع و تحقيق الارباح من خلال بيعها">
    <meta name="keywords" content="تجارة,تجارة,tigara">
    <meta name="author" content="تجارة">
    <link rel="icon" href="{{ asset('assets/landing/images/favicon.ico') }}">
    <title>تجارة</title>
    <link href="{{ asset('assets/landing/styles/bootstrap-5.0.2/dist/css/bootstrap-grid.rtl.min.css') }}"
        rel="stylesheet">
    <link href="//vjs.zencdn.net/7.10.2/video-js.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/landing/styles.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>

<body>
    {{-- <div id="content-container"> --}}
        <header>
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-4 col-md-9 logo-sections">
                        <div class="row">
                            <div class="col-md-2 col-12">
                                <div style="display: inline-block; align-items: center; justify-content: center; margin: 4px 0;">
                                    <img width="140" height="52" class="logo"
                                        src="{{ asset('assets/landing/images/tigara-trans.png') }}" alt="logo-alkseba">
                                </div>
                            </div>
                            <div class="col-md-10 col-1">
                                <div class="header-sections">
                                    <div class="div-FAQ header-section">
                                        <a class="FAQ-button" href="#welcome">الرئيسية</a>
                                    </div>
                                    <div class="div-FAQ header-section">
                                        <a class="FAQ-button" href="#steps">الخطوات</a>
                                    </div>
                                    <div class="div-FAQ header-section">
                                        <a class="FAQ-button" href="#why">لماذا تجارة ؟</a>
                                    </div>
                                    <div class="div-FAQ header-section">
                                        <a class="FAQ-button" href="#testominail">أراء المسوقين</a>
                                    </div>
                                    <div class="div-FAQ header-section ">
                                        <a class="FAQ-button" href="{{ asset('assets/landing/Help/Help-page.html') }}">مساعدة
                                            <img class="px-1" src="{{ asset('assets/landing/icons/help-circle.svg') }}"
                                                alt="help-circle"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="login-and-social col-md-3 col-8 justify-content-end">
                        <div class="div-login">
                            <a class="header-button" href="{{ '//marketer.'.env('MAIN_DOMAIN').'/login' }}">تسجيل الدخول</a>
                            <a class="header-button" href="{{ '//marketer.'.env('MAIN_DOMAIN').'/register' }}">انشاء حساب</a>
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
                            <a class="FAQ-button" href="#why">لماذا تجارة ؟</a>
                        </div>
                        <div class="div-FAQ header-section">
                            <a class="FAQ-button" href="#testominail">أراء المسوقين</a>
                        </div>
                        {{-- <div class="div-FAQ header-section ">
                            <a class="FAQ-button" href="{{ asset('assets/landing/Help/Help-page.html') }}">مساعدة <img
                                    class="px-1" src="{{ asset('assets/landing/icons/help-circle.svg') }}"
                                    alt="help-circle"></a>
                        </div> --}}
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
                        <h1 class="headline">
                            للمسوقين و الباحثين عن منتجات رائجة يمكنكم
                        </h1>
                        {{-- <h2 class="welcome-headline">
                                أكسب اعلى نسبة عمولة
                        </h2> --}}
                        <h4 id="headline-tab"  class="welcome-subtext" data-i18n="landingPage.increaseIncome">
                            <span class="TypeOn active">
                               تحقيق أرباح جيدة مع شركة تجارة شوب
                            </span>
                            <span class="TypeOn">
                                تحقيق عمولة كبيرة و أختيار طريقة الترويج المناسبة لكم
                            </span>
                        </h4>
                        <p class="some-features">
                            أعلى معدل طلبات مكتملة و التى ستنعكس بشكل ايجابي على معدل أرباحك بالاضافة للدعم المباشر و تعليم استراتيجيات التسويق الالكترونى
                        </p>
                        <a href="{{ url('login') }}" class="btn btn-go">
                            انضم الينا الأن
                        </a>
                    </div>
                    <div class="div-form col-12 col-md-6">
                        <video id="my-player" class="video-js" controls preload="auto"
                            poster="{{ asset('assets/landing/images/portrait-smiling-handsome-man-eyeglasses-removebg-preview.png') }}" data-setup='{}'>
                            <source src="{{ asset('assets/landing/videos/intro.webm') }}" type="video/webm">
                            <source src="{{ asset('assets/landing/videos/intro.Ogg') }}" type="video/ogg">
                            <source src="{{ asset('assets/landing/videos/intro.mp4') }}" type="video/mp4">
                            <p class="vjs-no-js"></p>
                        </video>
                    </div>
                </div>
            </div>
        </section>
        <section class="container" id="steps">
            <div class="row" style="text-align: center">
                <h2 class="howtojoin-title" >طريقة الانضمام و البدء ؟</h2>
                <div class="col-md-4 ">
                    <img class="img-responsive howtojoin-img" src="{{ asset('assets/landing/images/Mobile-login-pic.png') }}">
                    <span class="dash-no">1</span>
                    <p class="howtojoin-heading">
                        انشاء حساب على منصة tigara.shop
                    </p>
                    <p class="howtojoin-desc">
                        سجل اسمك و رقم هاتفك و انضم الينا
                    </p>
                </div>
                <div class="col-md-4 ">
                    <img class="img-responsive howtojoin-img" src="{{ asset('assets/landing/images/choose-product.png') }}">
                    <span class="dash-no">2</span>
                    <p class="howtojoin-heading">
                        اختار المنتج المطلوب بيعه و تسويقه
                    </p>
                    <p class="howtojoin-desc">
                        تصفح منتجاتنا و قم باختيار المنتجات التى تريد بيعها و قم بحملاتك
                    </p>
                </div>
                <div class="col-md-4 ">
                    <img class="img-responsive howtojoin-img" src="{{ asset('assets/landing/images/marketing-product.png') }}">
                    <span class="dash-no">3</span>
                    <p class="howtojoin-heading">
                        سوق منتجاتك
                    </p>
                    <p class="howtojoin-desc">
                        سوق منتجاتك على منصات تسويقية مختلفة و ابدأ أربح من البيع
                    </p>
                </div>
                <div class="col-md-4 ">
                    <img class="img-responsive howtojoin-img" src="{{ asset('assets/landing/images/write-customer-details.png') }}">
                    <span class="dash-no">4</span>
                    <p class="howtojoin-heading">
                        أكتب معلومات الزبون
                    </p>
                    <p class="howtojoin-desc">
                        بعد اضافة الطلب الى سلة التسوق قم باضافة بيانات الزبون لاستكمال باقي الخطوات
                    </p>
                </div>
                <div class="col-md-4 ">
                    <img class="img-responsive howtojoin-img" src="{{ asset('assets/landing/images/receive-ur-money.png') }}">
                    <span class="dash-no">5</span>
                    <p class="howtojoin-heading">
                        أستلم أرباحك بعد تسليم الطلب
                    </p>
                    <p class="howtojoin-desc">
                        بمجرد توصيل الطلب الزبون يتم ايداع أرباحك في حسابك
                    </p>
                </div>
                <div class="col-md-4 ">
                    <p class="overflow-howtojoin">
                        تمنحك منصة تجارة أعلى نسبة عمولة على مبيعاتك مهما زادت أو قلت تبقي دائما رابح على منصتنا
                    </p>
                    <a href="{{ url('register') }}" class="btn btn-howtojoin">أبدأ الان و اجني أرباحك</a>
                </div>
            </div>

        </section>

        <section class="container-fluid why-section" id="why">
            <div class="row">
                <div class="section col-md-6">
                    <h2 class="text" data-i18n="landingPage.whyWorkWithKaseeba">لماذا تختار منصة تجارة ؟</h2>
                    <ul class="why-list">
                        <li data-i18n="landingPage.highestSuccessRate">
                            <i class="fas fa-layer-group"></i>
                            أول منصة محلية تتيح لك الربح من منتجات دون امتلاكها
                        </li>
                        <li data-i18n="landingPage.weTeachMarketing">
                            <i class="fas fa-layer-group"></i>
                            سنعلمك كل استراتيحيات التسويق لكى تحقق أعلى نسبة مبيعات
                        </li>
                        <li data-i18n="landingPage.weOfferTechSupport">
                            <i class="fas fa-layer-group"></i>
                             دعم فنى متواجد دايما يساعدك على حل مشاكلك
                        </li>
                        <li data-i18n="landingPage.earnHighProfits">
                            <i class="fas fa-layer-group"></i>
                            عمولة مناسبة على كل طلبية مكتملة تتم من خلالك
                        </li>
                    </ul>
                    <div>
                        <img class="why-img" src="{{ asset('assets/landing/images/line.svg') }}" alt="">
                    </div>
                </div>
                <div class="section col-md-6">
                    <img class="img-responsive" style="width: 100%;" src="{{ asset('assets/landing/images/Happy_man_holding_five_rating_stars-removebg-preview.png') }}" alt="why-pic">
                </div>
            </div>
        </section>
        <section class="container testominail" id="testominail">
            <div class="row">
                <h4 class="testominail-title">أراء المسوقين</h4>
                <p class="testominail-desc">
                    أطلع على أراء المسوقين فى منصتنا
                </p>
                <div class="col-md-4 card">
                    <div class="card-testominail">
                        <p style="text-align: center">
                            <i class="fas fa-user icon-user-card"></i>
                        </p>
                        <p class="card-desc">
                            منصة تجارة منصة رائعة فلقد حققت اكثر من 10000 الاف دولار فى خلال فترة قصيرة بدون تأخير فى تسليم الطلبات
                        </p>
                        <strong class="card-author" style="text-align: center">محمد الليثي</strong>
                        <p class="card-marketer-active">مسوق نشط</p>
                        <i class="fas fa-quote-right card-quote"></i>
                        <i class="fas fa-quote-right card-quote-last"></i>
                    </div>
                </div>
                <div class="col-md-4 card">
                    <div class="card-testominail">
                        <p style="text-align: center">
                            <i class="fas fa-user icon-user-card"></i>
                        </p>
                        <p class="card-desc">
                            منصة تجارة منصة رائعة فلقد حققت اكثر من 10000 الاف دولار فى خلال فترة قصيرة بدون تأخير فى تسليم الطلبات
                        </p>
                        <strong class="card-author" style="text-align: center">محمد الليثي</strong>
                        <p class="card-marketer-active">مسوق نشط</p>
                        <i class="fas fa-quote-right card-quote"></i>
                        <i class="fas fa-quote-right card-quote-last"></i>
                    </div>
                </div>
                <div class="col-md-4 card">
                    <div class="card-testominail">
                        <p style="text-align: center">
                            <i class="fas fa-user icon-user-card"></i>
                        </p>
                        <p class="card-desc">
                            منصة تجارة منصة رائعة فلقد حققت اكثر من 10000 الاف دولار فى خلال فترة قصيرة بدون تأخير فى تسليم الطلبات
                        </p>
                        <strong class="card-author" style="text-align: center">محمد الليثي</strong>
                        <p class="card-marketer-active">مسوق نشط</p>
                        <i class="fas fa-quote-right card-quote"></i>
                        <i class="fas fa-quote-right card-quote-last"></i>
                    </div>
                </div>

                <div class="col-md-4 card">
                    <div class="card-testominail">
                        <p style="text-align: center">
                            <i class="fas fa-user icon-user-card"></i>
                        </p>
                        <p class="card-desc">
                            منصة تجارة منصة رائعة فلقد حققت اكثر من 10000 الاف دولار فى خلال فترة قصيرة بدون تأخير فى تسليم الطلبات
                        </p>
                        <strong class="card-author" style="text-align: center">محمد الليثي</strong>
                        <p class="card-marketer-active">مسوق نشط</p>
                        <i class="fas fa-quote-right card-quote"></i>
                        <i class="fas fa-quote-right card-quote-last"></i>
                    </div>
                </div>

                <div class="col-md-4 card">
                    <div class="card-testominail">
                        <p style="text-align: center">
                            <i class="fas fa-user icon-user-card"></i>
                        </p>
                        <p class="card-desc">
                            منصة تجارة منصة رائعة فلقد حققت اكثر من 10000 الاف دولار فى خلال فترة قصيرة بدون تأخير فى تسليم الطلبات
                        </p>
                        <strong class="card-author" style="text-align: center">محمد الليثي</strong>
                        <p class="card-marketer-active">مسوق نشط</p>
                        <i class="fas fa-quote-right card-quote"></i>
                        <i class="fas fa-quote-right card-quote-last"></i>
                    </div>
                </div>

                <div class="col-md-4 card">
                    <div class="card-testominail">
                        <p style="text-align: center">
                            <i class="fas fa-user icon-user-card"></i>
                        </p>
                        <p class="card-desc">
                            منصة تجارة منصة رائعة فلقد حققت اكثر من 10000 الاف دولار فى خلال فترة قصيرة بدون تأخير فى تسليم الطلبات
                        </p>
                        <strong class="card-author" style="text-align: center">محمد الليثي</strong>
                        <p class="card-marketer-active">مسوق نشط</p>
                        <i class="fas fa-quote-right card-quote"></i>
                        <i class="fas fa-quote-right card-quote-last"></i>
                    </div>
                </div>
            </div>
        </section>
        {{-- <div class="last-section tracking-section" id="last-section">
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
        </div> --}}
        <footer style="background-color: black;">
            <section class="logo-section col-m-12">
                <h2 class="footer-logo">
                    <img width="140" height="52" class="logo"
                                src="{{ asset('assets/landing/images/tigara-trans.png') }}" alt="logo-alkseba">
                </h2>
            </section>
            <div class="login-and-social">
                <div class="div-social">
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-youtube"></i>
                    <i class="fab fa-twitter-square"></i>
                </div>
                <div class="div-login">
                    <a class="header-button" href="{{ url('login') }}" style="    background-color: #f37115;
                    color: black;
                    font-style: normal;
                    font-size: 13px;
                    font-weight: 700;
                    border: 1px solid #000000;
                    border-radius: 6px;
                    padding: 4% 3%;
                    text-align: center;
                    margin: 3px;">تسجيل الدخول</a>
                </div>
            </div>
        </footer>
    {{-- </div> --}}
    <script type="module" src="{{ asset('assets/landing/JS/main.js') }}"></script>
    <script src="//vjs.zencdn.net/7.10.2/video.min.js"></script>
    <script>
        var player = videojs('my-player', {
            fluid: true,
            responsive: true,
            aspectRatio: "16:9",

        });
        player.userActive(false);
        player.on("pause", function () {
            player.bigPlayButton.show();
        });
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
            }, 4000);

            await setInterval(async () => {
                await document.querySelectorAll('#headline-tab span').forEach(async function(ele){
                    await ele.classList.toggle('active');
                });
            }, 8000);
        })();
    </script>
    <style>
    </style>
</body>

<!-- Mirrored from alkaseba.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 25 Mar 2023 18:59:09 GMT -->

</html>
