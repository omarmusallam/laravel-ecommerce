<!DOCTYPE html>
<html class="no-js" lang="{{ App::currentLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>{{ $title }}</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $settings->invoice_stamp) }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- ========================= CSS here ========================= -->

    @if (LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.rtl.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.3.0.rtl.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.rtl.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.rtl.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/main.rtl.css') }}" />
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.3.0.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    @endif
    @stack('styles')
</head>

<body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
    <header class="header navbar-area">
        <!-- Start Topbar -->
        <div class="topbar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-left">
                            <ul class="menu-top-link">
                                <li>
                                    <div class="select-position">
                                        <form action="{{ route('currency.store') }}" method="post">
                                            @csrf
                                            <select name="currency_code" onchange="this.form.submit()">
                                                <option value="USD" @selected('USD' == session('currency_code'))>$ USD</option>
                                                <option value="EUR" @selected('EUR' == session('currency_code'))>€ EURO</option>
                                                <option value="ILS" @selected('ILS' == session('currency_code'))>₪ ILS</option>
                                                <option value="JOD" @selected('JOD' == session('currency_code'))>₹ JOD</option>
                                                <option value="SAR" @selected('SAR' == session('currency_code'))>¥ SAR</option>
                                                <option value="QAR" @selected('QAR' == session('currency_code'))>৳ QAR</option>
                                            </select>
                                        </form>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <form action="{{ URL::current() }}" method="get">
                                            {{-- <select name="locale" onchange="this.form.submit()">
                                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                    <option value="{{ $localeCode }}" @selected($localeCode == App::currentLocale())>
                                                        {{ $properties['native'] }}</option>
                                                @endforeach
                                            </select> --}}
                                            <ul>
                                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                    <li>
                                                        <a style="color: #fff" rel="alternate"
                                                            hreflang="{{ $localeCode }}"
                                                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                            {{ $properties['native'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-middle">
                            <ul class="useful-links">
                                <li><a href="{{ route('home') }}">{{ trans('app.home') }}</a></li>
                                <li><a href="{{ route('about-us') }}">@lang('app.about')</a></li>
                                <li><a href="{{ route('contact-us') }}">{{ __('Contact Us') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-end">
                            @auth
                                <div class="user">
                                    <i class="lni lni-user"></i>
                                    <a href="{{ route('user-profile.edit') }}"
                                        style="color: #fff">{{ Auth::user()->name }}</a>

                                </div>
                                <ul class="user-login">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout').submit()">@lang('app.signout')</a>
                                    </li>
                                    <form action="{{ route('logout') }}" id="logout" method="post"
                                        style="display:none">
                                        @csrf
                                    </form>
                                </ul>
                            @else
                                <div class="user">
                                    <i class="lni lni-user"></i>
                                    {{ __('Hello') }}
                                </div>
                                <ul class="user-login">
                                    <li>
                                        <a href="{{ route('login') }}">{{ Lang::get('Sign In') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.register') }}">{{ __('Register') }}</a>
                                    </li>
                                </ul>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Topbar -->
        <!-- Start Header Middle -->
        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">
                        <!-- Start Header Logo -->
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img src="{{ asset('storage/' . $settings->website_logo) }}" alt="Logo">
                        </a>
                        <!-- End Header Logo -->
                    </div>
                    <div class="col-lg-5 col-md-7 d-xs-none">
                        <!-- Start Main Menu Search -->
                        <form action="{{ route('list-products.index') }}" method="get">
                            <div class="main-menu-search">
                                <!-- navbar search start -->
                                <div class="navbar-search search-style-5">
                                    <div class="search-input">
                                        <x-form.input name="slug" placeholder="{{ __('Search') }}"
                                            :value="request('slug')" />
                                    </div>
                                    <div class="search-btn">
                                        <button><i class="lni lni-search-alt"></i></button>
                                    </div>
                                </div>
                                <!-- navbar search Ends -->
                            </div>
                        </form>

                        <!-- End Main Menu Search -->
                    </div>
                    <div class="col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area">
                            <div class="nav-hotline">
                                <i class="lni lni-phone"></i>
                                <h3>{{ __('Phone') }} :
                                    <span>{{ $settings->phone ?? '+097 123456789' }}</span>
                                </h3>
                            </div>
                            <div class="navbar-cart">
                                {{-- <div class="wishlist">
                                    <a href="javascript:void(0)">
                                        <i class="lni lni-heart"></i>
                                        <span class="total-items">0</span>
                                    </a>
                                </div> --}}
                                <x-cart-menu />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Middle -->
        <!-- Start Header Bottom -->
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="nav-inner">
                        <!-- Start Mega Category Menu -->
                        <div class="mega-category-menu">
                            <span class="cat-button"><i class="lni lni-menu"></i>{{ __('All Categories') }}</span>
                            <ul class="sub-category">
                                @if ($categories->count())
                                    @foreach ($categories as $category)
                                        <li><a
                                                href="{{ route('list-products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <!-- End Mega Category Menu -->
                        <!-- Start Navbar -->
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="{{ route('home') }}"
                                            aria-label="Toggle navigation">{{ __('Home') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)"
                                            data-bs-toggle="collapse" data-bs-target="#submenu-1-2"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="Toggle navigation">{{ __('Pages') }}</a>
                                        <ul class="sub-menu collapse" id="submenu-1-2">
                                            <li class="nav-item"><a
                                                    href="{{ route('about-us') }}">{{ __('About Us') }}</a></li>
                                            <li class="nav-item"><a
                                                    href="{{ route('faq') }}">{{ __('Faq') }}</a></li>
                                            <li class="nav-item"><a
                                                    href="{{ route('login') }}">{{ __('Sign In') }}</a></li>
                                            <li class="nav-item"><a
                                                    href="{{ route('register') }}">{{ __('Register') }}</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)"
                                            data-bs-toggle="collapse" data-bs-target="#submenu-1-3"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="Toggle navigation">{{ __('Shop') }}</a>
                                        <ul class="sub-menu collapse" id="submenu-1-3">
                                            {{-- <li class="nav-item"><a href="#">Shop Grid</a></li> --}}
                                            <li class="nav-item"><a
                                                    href="{{ route('list-products.index') }}">{{ __('Products page') }}</a>
                                            </li>
                                            {{-- <li class="nav-item"><a href="#">shop Single</a></li> --}}
                                            <li class="nav-item"><a
                                                    href="{{ route('cart.index') }}">{{ __('Cart') }}</a></li>
                                            <li class="nav-item"><a
                                                    href="{{ route('checkout') }}">{{ __('Checkout') }}</a></li>
                                        </ul>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)"
                                            data-bs-toggle="collapse" data-bs-target="#submenu-1-4"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="Toggle navigation">Blog</a>
                                        <ul class="sub-menu collapse" id="submenu-1-4">
                                            <li class="nav-item"><a href="#">Blog Grid
                                                    Sidebar</a>
                                            </li>
                                            <li class="nav-item"><a href="#">Blog Single</a></li>
                                            <li class="nav-item"><a href="#">Blog Single
                                                    Sibebar</a></li>
                                        </ul>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a href="{{ route('contact-us') }}"
                                            aria-label="Toggle navigation">{{ __('Contact Us') }}</a>
                                    </li>
                                </ul>
                            </div> <!-- navbar collapse -->
                        </nav>
                        <!-- End Navbar -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Nav Social -->
                    <div class="nav-social">
                        <h5 class="title">{{ __('Follow Us') }} :</h5>
                        <ul>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-instagram"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-skype"></i></a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Nav Social -->
                </div>
            </div>
        </div>
        <!-- End Header Bottom -->
    </header>
    <!-- End Header Area -->

    <!-- Start Breadcrumbs -->
    {{ $breadcrumb ?? '' }}
    <!-- End Breadcrumbs -->

    {{ $slot }}

    <!-- Start Footer Area -->
    <footer class="footer">
        <!-- Start Footer Top -->
        {{-- <div class="footer-top">
            <div class="container">
                <div class="inner-content">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="footer-logo">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('assets/images/logo/logo1.png') }}" alt="#">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-12">
                            <div class="footer-newsletter">
                                <h4 class="title">
                                    {{ __('Subscribe to our Newsletter') }}
                                    <span>{{ __('Get all the latest information, Sales and Offers') }}.</span>
                                </h4>
                                <div class="newsletter-form-head">
                                    <form action="#" method="get" target="_blank" class="newsletter-form">
                                        <input name="EMAIL" placeholder="{{ __('Email address here') }}..."
                                            type="email">
                                        <div class="button">
                                            <button type="button" class="btn">{{ __('Subscribe') }}<span
                                                    class="dir-part"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- End Footer Top -->
        <!-- Start Footer Middle -->
        <div class="footer-middle">
            <div class="container">
                <div class="bottom-inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-contact">
                                <h3>{{ __('Get In Touch With Us') }}</h3>
                                <p class="phone">{{ __('Phone') }} : {{ $settings->phone ?? '+097 123456789' }}
                                </p>
                                <ul>
                                    <li><span>{{ __('Monday - Friday') }} : </span> 9.00 am - 8.00 pm</li>
                                    <li><span>{{ __('Saturday') }} : </span> 10.00 am - 6.00 pm</li>
                                </ul>
                                <p class="mail">
                                    <a href="mailto:{{ $settings->email }}">{{ $settings->email ?? 'email@gmail.com'}}</a>
                                </p>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>{{ __('Information') }}</h3>
                                <ul>
                                    <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                                    <li><a href="{{ route('login') }}">{{ __('Sign In') }}</a></li>
                                    <li><a href="{{ route('about-us') }}">{{ __('About Us') }}</a></li>
                                    <li><a href="{{ route('contact-us') }}">{{ __('Contact Us') }}</a></li>
                                    <li><a href="{{ route('faq') }}">{{ __('FAQs Page') }}</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>{{ __('Shop Departments') }}</h3>
                                <ul>
                                    @if ($categories->count())
                                        @foreach ($categories as $category)
                                            <li><a
                                                    href="{{ route('list-products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Middle -->
        <!-- Start Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="inner-content">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-12">
                            <div class="payment-gateway">
                                <span>{{ __('We Accept') }} :</span>
                                <img src="{{ asset('assets/images/footer/credit-cards-footer.png') }}"
                                    alt="#">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="copyright">
                                <p>{{ __('Designed and Developed by') }} :<a href="{{ route('home') }}"
                                        rel="nofollow" target="_blank">{{ $settings->name }}</a></p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <ul class="socila">
                                <li>
                                    <span>{{ __('Follow Us') }} :</span>
                                </li>
                                <li><a href="#"><i class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="#"><i class="lni lni-twitter-original"></i></a></li>
                                <li><a href="#"><i class="lni lni-instagram"></i></a></li>
                                <li><a href="#"><i class="lni lni-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Bottom -->
    </footer>
    <!--/ End Footer Area -->

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @stack('scripts')

</body>

</html>
