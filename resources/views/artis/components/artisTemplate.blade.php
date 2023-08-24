<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ $title }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="/assets/vendors/jvectormap/jquery-jvectormap.css" />
    <link rel="stylesheet" href="/assets/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.carousel.min.css" />
    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.theme.default.min.css" />
    <link rel="stylesheet" href="/assets/css/style.css" />
    <link rel="shortcut icon" href="/assets/images/favicon.png" />

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .datakiri {
            position: relative;
            overflow-y: scroll;
            height: 68vh;
        }

        .datakanan {
            position: relative;
            overflow-y: scroll;
            height: 40vh;
        }

        .scrollbar-dusty-grass::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            border-radius: 10px;
        }

        .scrollbar-dusty-grass::-webkit-scrollbar {
            width: 12px;
            background-color: #f5f5f5;
        }

        .scrollbar-dusty-grass::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #957dad;
            /* background-image: -webkit-linear-gradient(330deg, #d4fc79 0%, #96e6a1 100%);
      background-image: linear-gradient(120deg, #d4fc79 0%, #96e6a1 100%); */
        }

        .thin::-webkit-scrollbar {
            width: 6px;
        }

        .bottom-left {
            position: absolute;
            bottom: 8px;
            left: 16px;
        }

        .bottom-right {
            position: absolute;
            bottom: 8px;
            right: 16px;
        }

        /* css kolaborasi */

        .table {
            border-collapse: collapse;
        }

        .table td {
            border: none;
        }

        .table thead th,
        .jsgrid .jsgrid-table thead th {
            border-top: 0;
            border: none;
            font-weight: 500;
            color: #ffffff;
            background-color: #957dad;
        }

        .table th,
        .jsgrid .jsgrid-table th,
        .table td,
        .jsgrid .jsgrid-table td {
            vertical-align: middle;
            font-size: 0.875rem;
            line-height: 1;
            white-space: nowrap;
            border: none;
            background-color: #ececec;
        }

        .modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 1rem 1rem;
            border-bottom: none;
            border-top-left-radius: calc(0.3rem - 1px);
            border-top-right-radius: calc(0.3rem - 1px);
        }

        .modal-footer {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-end;
            padding: 0.6875rem;
            border-top: none;
            border-bottom-right-radius: calc(0.3rem - 1px);
            border-bottom-left-radius: calc(0.3rem - 1px);
        }

        .btn-unstyled {
            border: none;
            background-color: transparent;
            color: inherit;
            padding: 0;
        }

        .btn-icon {
            font-size: 24px;
        }

        /* css kolaborasi2 */
        .input-judul {
            width: 100%;
            border-radius: 7px;
            border: none;
            outline: none;
        }

        .note-editor .dropdown-toggle::after {
            all: unset;
        }

        .note-editor .note-dropdown-menu {
            box-sizing: content-box;
        }

        .note-editor .note-modal-footer {
            box-sizing: content-box;
        }

        .note-editable {
            background-color: #ffffff;
        }

        .kirim {
            width: 100%;
        }

        .chat .card {
            background-color: #ffffff;
            height: 72vh;
        }


        .input-with-icon {
            position: relative;
        }

        .input-with-icon input {
            padding-right: 40px;
            width: 100%;
        }

        .input-with-icon i {
            display: block;
            text-align: center;
            position: absolute;
            right: 10px;
            /* Jarak dari kiri */
            top: 50%;
            /* Tengah vertikal */
            transform: translateY(-50%);
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <nav class="sidebar sidebar-offcanvas" id="sidebar"
            style="
          z-index: 100;
          box-shadow: rgba(17, 17, 26, 0.1) 0px 8px 24px,
            rgba(17, 17, 26, 0.1) 0px 16px 56px,
            rgba(17, 17, 26, 0.1) 0px 24px 80px;
        ">
            <div style="background-color: white"
                class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="/artis/dashboard"><img src="/assets/images/logo.svg"
                        alt="logo" /></a>
            </div>
            <ul class="nav">
                <li class="nav-item menu-items">
                    <a style="{{ $title === 'Beranda' ? 'background-color: #957dad; color: #fff' : 'background-color: #fff; color: #957dad' }}"
                        class="nav-link" style="border-radius: 15px" href="/artis/dashboard">
                        @if ($title === 'Beranda')
                            <span class=" mr-2">
                                <svg width="35" height="35" viewBox="0 0 35 35" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14 35H5.25V17.5H0L17.5 0L35 17.5H29.75V35H21V24.5H14V35Z"
                                        fill="white" />
                                </svg>

                            </span>
                        @else
                            <span class=" mr-2">
                                <svg width="35" height="35" viewBox="0 0 35 35" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14 35H5.25V17.5H0L17.5 0L35 17.5H29.75V35H21V24.5H14V35Z"
                                        fill="#957DAD" />
                                </svg>
                            </span>
                        @endif
                        <span><strong>Beranda</strong></span>
                    </a>
                </li>
                <li class="nav-item menu-items mt-3">
                    <a style="{{ $title === 'Kolaborasi' ? 'background-color: #957dad; color: #fff' : 'background-color: #fff; color: #957dad' }}"
                        class="nav-link" href="{{ route('kolaborasi') }}">
                        @if ($title === 'Beranda')
                            <span class="menu-icon">
                                <svg width="43" height="43" viewBox="0 0 43 43" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.08022 27.312V27.062H6.83022H3.91504H3.66504V27.312V28.7738C3.66504 31.5537 4.76617 34.2198 6.72643 36.1857C8.68672 38.1516 11.3456 39.2562 14.1182 39.2562H18.4909H18.7409V39.0062V36.0827V35.8327H18.4909H14.1182C12.2518 35.8327 10.4618 35.0891 9.14184 33.7654C7.82189 32.4417 7.08022 30.6461 7.08022 28.7738V27.312Z"
                                        fill="#957DAD" stroke="#957DAD" stroke-width="0.5" />
                                    <path
                                        d="M32.817 15.6173V15.8673H33.067H35.9821H36.2321V15.6173V14.1555C36.2321 11.3756 35.131 8.70947 33.1707 6.74358C31.2105 4.77767 28.5516 3.6731 25.779 3.6731H21.4062H21.1562V3.9231V6.84665V7.09665H21.4062H25.779C26.7032 7.09665 27.6183 7.27919 28.4721 7.63388C29.3259 7.98856 30.1018 8.50845 30.7553 9.16389C31.4089 9.81934 31.9274 10.5975 32.2811 11.454C32.6349 12.3105 32.817 13.2284 32.817 14.1555V15.6173Z"
                                        fill="#957DAD" stroke="#957DAD" stroke-width="0.5" />
                                    <path
                                        d="M0.75 21.4649V21.7149H1H3.91518H4.16518V21.4649V18.5413C4.16518 18.2197 4.29258 17.9114 4.51913 17.6842C4.74565 17.4571 5.05273 17.3296 5.37277 17.3296H14.1183C14.4383 17.3296 14.7454 17.4571 14.9719 17.6842C15.1985 17.9114 15.3259 18.2197 15.3259 18.5413V21.4649V21.7149H15.5759H18.4911H18.7411V21.4649V18.5413C18.7411 17.3122 18.2542 16.1333 17.3873 15.2639C16.5205 14.3945 15.3446 13.906 14.1183 13.906H5.37277C4.1465 13.906 2.97061 14.3945 2.10372 15.2639C1.23687 16.1333 0.75 17.3122 0.75 18.5413V21.4649Z"
                                        fill="#957DAD" stroke="#957DAD" stroke-width="0.5" />
                                    <path
                                        d="M9.7454 12.9442C10.9481 12.9442 12.1238 12.5865 13.1237 11.9165C14.1237 11.2464 14.9029 10.2942 15.363 9.18013C15.8231 8.06612 15.9435 6.84034 15.7089 5.65775C15.4744 4.47517 14.8954 3.3888 14.0451 2.53606C13.1948 1.68331 12.1114 1.1025 10.9317 0.867184C9.75213 0.63187 8.52944 0.752648 7.41831 1.21421C6.30719 1.67578 5.35761 2.45736 4.68958 3.46001C4.02155 4.46266 3.66504 5.64137 3.66504 6.84711C3.66504 8.46393 4.30547 10.0147 5.44568 11.1582C6.58591 12.3017 8.13255 12.9442 9.7454 12.9442ZM9.7454 4.17355C10.2724 4.17355 10.7875 4.33026 11.2258 4.62394C11.6641 4.91763 12.0058 5.33514 12.2076 5.82375C12.4094 6.31236 12.4622 6.85006 12.3593 7.36882C12.2564 7.88758 12.0025 8.36399 11.6297 8.73785C11.2569 9.1117 10.7821 9.36621 10.2652 9.46931C9.74836 9.57242 9.21262 9.51951 8.72571 9.31724C8.23879 9.11498 7.8225 8.7724 7.52957 8.33273C7.23662 7.89304 7.08022 7.37604 7.08022 6.84711C7.08022 6.1378 7.36119 5.4577 7.86108 4.95637C8.36096 4.45506 9.03878 4.17355 9.7454 4.17355Z"
                                        fill="#957DAD" stroke="#957DAD" stroke-width="0.5" />
                                    <path
                                        d="M24.0713 41.9297V42.1797H24.3213H27.2365H27.4865V41.9297V39.0062C27.4865 38.6846 27.6139 38.3763 27.8404 38.1491C28.0669 37.9219 28.374 37.7944 28.6941 37.7944H37.4396C37.7596 37.7944 38.0667 37.9219 38.2932 38.1491C38.5198 38.3763 38.6472 38.6846 38.6472 39.0062V41.9297V42.1797H38.8972H41.8124H42.0624V41.9297V39.0062C42.0624 37.777 41.5755 36.5981 40.7086 35.7288C39.8418 34.8594 38.6659 34.3708 37.4396 34.3708H28.6941C27.4678 34.3708 26.2919 34.8594 25.425 35.7288C24.5582 36.5981 24.0713 37.777 24.0713 39.0062V41.9297Z"
                                        fill="#957DAD" stroke="#957DAD" stroke-width="0.5" />
                                    <path
                                        d="M26.9863 27.3119C26.9863 28.5177 27.3428 29.6964 28.0109 30.699C28.6789 31.7017 29.6285 32.4833 30.7396 32.9448C31.8507 33.4064 33.0734 33.5272 34.253 33.2919C35.4326 33.0566 36.5161 32.4757 37.3664 31.623C38.2167 30.7703 38.7957 29.6839 39.0302 28.5013C39.2648 27.3187 39.1444 26.0929 38.6843 24.9789C38.2242 23.8649 37.4449 22.9126 36.445 22.2426C35.4451 21.5725 34.2694 21.2148 33.0667 21.2148C31.4538 21.2148 29.9072 21.8574 28.767 23.0009C27.6268 24.1444 26.9863 25.6951 26.9863 27.3119ZM35.7319 27.3119C35.7319 27.8409 35.5755 28.3579 35.2825 28.7976C34.9896 29.2372 34.5733 29.5798 34.0864 29.7821C33.5995 29.9843 33.0637 30.0373 32.5469 29.9342C32.03 29.831 31.5552 29.5765 31.1824 29.2027C30.8096 28.8288 30.5556 28.3524 30.4527 27.8337C30.3499 27.3149 30.4027 26.7772 30.6045 26.2886C30.8063 25.8 31.148 25.3825 31.5863 25.0888C32.0245 24.7951 32.5397 24.6384 33.0667 24.6384C33.7733 24.6384 34.4511 24.9199 34.951 25.4212C35.4509 25.9225 35.7319 26.6026 35.7319 27.3119Z"
                                        fill="#957DAD" stroke="#957DAD" stroke-width="0.5" />
                                </svg>

                            </span>
                        @else
                            <span class="menu-icon">
                                <svg width="43" height="43" viewBox="0 0 43 43" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="Group 121">
                                        <g id="&#240;&#159;&#166;&#134; icon &#34;Collaborate&#34;">
                                            <path id="Vector"
                                                d="M7.08119 27.3125V27.0625H6.83119H3.91602H3.66602V27.3125V28.7743C3.66602 31.5542 4.76715 34.2203 6.72741 36.1862C8.6877 38.1521 11.3466 39.2567 14.1191 39.2567H18.4919H18.7419V39.0067V36.0832V35.8332H18.4919H14.1191C12.2528 35.8332 10.4627 35.0896 9.14281 33.7659C7.82286 32.4422 7.08119 30.6466 7.08119 28.7743V27.3125Z"
                                                fill="white" stroke="white" stroke-width="0.5" />
                                            <path id="Vector_2"
                                                d="M32.817 15.6171V15.8671H33.067H35.9821H36.2321V15.6171V14.1553C36.2321 11.3754 35.131 8.70923 33.1707 6.74334C31.2105 4.77742 28.5516 3.67285 25.779 3.67285H21.4062H21.1562V3.92285V6.8464V7.0964H21.4062H25.779C26.7032 7.0964 27.6183 7.27895 28.4721 7.63363C29.3259 7.98832 30.1018 8.5082 30.7553 9.16365C31.4089 9.81909 31.9274 10.5973 32.2811 11.4537C32.6349 12.3102 32.817 13.2282 32.817 14.1553V15.6171Z"
                                                fill="white" stroke="white" stroke-width="0.5" />
                                            <path id="Vector_3"
                                                d="M0.75 21.4651V21.7151H1H3.91518H4.16518V21.4651V18.5416C4.16518 18.22 4.29258 17.9117 4.51913 17.6845C4.74565 17.4573 5.05273 17.3298 5.37277 17.3298H14.1183C14.4383 17.3298 14.7454 17.4573 14.9719 17.6845C15.1985 17.9117 15.3259 18.22 15.3259 18.5416V21.4651V21.7151H15.5759H18.4911H18.7411V21.4651V18.5416C18.7411 17.3124 18.2542 16.1335 17.3873 15.2642C16.5205 14.3948 15.3446 13.9062 14.1183 13.9062H5.37277C4.1465 13.9062 2.97061 14.3948 2.10372 15.2642C1.23687 16.1335 0.75 17.3124 0.75 18.5416V21.4651Z"
                                                fill="white" stroke="white" stroke-width="0.5" />
                                            <path id="Vector_4"
                                                d="M9.74637 12.9442C10.9491 12.9442 12.1248 12.5865 13.1247 11.9165C14.1246 11.2464 14.9039 10.2942 15.364 9.18013C15.8241 8.06612 15.9445 6.84034 15.7099 5.65775C15.4754 4.47517 14.8964 3.3888 14.0461 2.53606C13.1958 1.68331 12.1123 1.1025 10.9327 0.867184C9.75311 0.63187 8.53042 0.752648 7.41929 1.21421C6.30817 1.67578 5.35859 2.45736 4.69056 3.46001C4.02253 4.46266 3.66602 5.64137 3.66602 6.84711C3.66602 8.46393 4.30645 10.0147 5.44666 11.1582C6.58689 12.3017 8.13353 12.9442 9.74637 12.9442ZM9.74637 4.17355C10.2733 4.17355 10.7885 4.33026 11.2268 4.62394C11.6651 4.91763 12.0068 5.33514 12.2086 5.82375C12.4104 6.31236 12.4632 6.85006 12.3603 7.36882C12.2574 7.88758 12.0035 8.36399 11.6307 8.73785C11.2579 9.1117 10.783 9.36621 10.2662 9.46931C9.74934 9.57242 9.2136 9.51951 8.72669 9.31724C8.23977 9.11498 7.82348 8.7724 7.53054 8.33273C7.2376 7.89304 7.08119 7.37604 7.08119 6.84711C7.08119 6.1378 7.36216 5.4577 7.86206 4.95637C8.36193 4.45506 9.03976 4.17355 9.74637 4.17355Z"
                                                fill="white" stroke="white" stroke-width="0.5" />
                                            <path id="Vector_5"
                                                d="M24.0723 41.93V42.18H24.3223H27.2374H27.4874V41.93V39.0064C27.4874 38.6848 27.6148 38.3765 27.8414 38.1493C28.0679 37.9221 28.375 37.7946 28.695 37.7946H37.4406C37.7606 37.7946 38.0677 37.9221 38.2942 38.1493C38.5208 38.3765 38.6482 38.6848 38.6482 39.0064V41.93V42.18H38.8982H41.8133H42.0633V41.93V39.0064C42.0633 37.7773 41.5765 36.5984 40.7096 35.729C39.8427 34.8596 38.6668 34.3711 37.4406 34.3711H28.695C27.4688 34.3711 26.2929 34.8596 25.426 35.729C24.5591 36.5984 24.0723 37.7773 24.0723 39.0064V41.93Z"
                                                fill="white" stroke="white" stroke-width="0.5" />
                                            <path id="Vector_6"
                                                d="M26.9863 27.3119C26.9863 28.5177 27.3428 29.6964 28.0109 30.699C28.6789 31.7017 29.6285 32.4833 30.7396 32.9448C31.8507 33.4064 33.0734 33.5272 34.253 33.2919C35.4326 33.0566 36.5161 32.4757 37.3664 31.623C38.2167 30.7703 38.7957 29.6839 39.0302 28.5013C39.2648 27.3187 39.1444 26.0929 38.6843 24.9789C38.2242 23.8649 37.4449 22.9126 36.445 22.2426C35.4451 21.5725 34.2694 21.2148 33.0667 21.2148C31.4538 21.2148 29.9072 21.8574 28.767 23.0009C27.6268 24.1444 26.9863 25.6951 26.9863 27.3119ZM35.7319 27.3119C35.7319 27.8409 35.5755 28.3579 35.2825 28.7976C34.9896 29.2372 34.5733 29.5798 34.0864 29.7821C33.5995 29.9843 33.0637 30.0373 32.5469 29.9342C32.03 29.831 31.5552 29.5765 31.1824 29.2027C30.8096 28.8288 30.5556 28.3524 30.4527 27.8337C30.3499 27.3149 30.4027 26.7772 30.6045 26.2886C30.8063 25.8 31.148 25.3825 31.5863 25.0888C32.0245 24.7951 32.5397 24.6384 33.0667 24.6384C33.7733 24.6384 34.4511 24.9199 34.951 25.4212C35.4509 25.9225 35.7319 26.6026 35.7319 27.3119Z"
                                                fill="white" stroke="white" stroke-width="0.5" />
                                        </g>
                                    </g>
                                </svg>
                            </span>
                        @endif
                        <span>Kolaborasi</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper" style="z-index: 1">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <ul class="navbar-nav w-100">
                        <li class="nav-item w-100">
                            <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                                <input type="text" class="form-control rounded-4" placeholder="Search products" />
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown"
                                href="#" data-toggle="dropdown">
                                <i class="mdi mdi-bell"></i>
                                <!-- <span class="count bg-danger"></span> -->
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="notificationDropdown">
                                <a class="dropdown-item preview-item" style="background-color: white; color: #6c6c6c">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <i class="mdi mdi-calendar text-success"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1" style="font-weight: 500">
                                            Event today
                                        </p>
                                        <p class="text-muted ellipsis mb-0">
                                            Just a reminder that you have an event today
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" src="/assets/images/faces/face15.jpg"
                                        alt="" />
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown"
                                style="
                    width: 30%;
                    background-color: #ececec;
                    border-radius: 10px;
                  ">
                                <a class="dropdown-item preview-item">
                                    <div class="profile-pic gap-2"
                                        style="
                        display: flex;
                        flex-direction: row;
                        justify-content: center;
                        align-items: center;
                      ">
                                        <div class="count-indicator">
                                            <img class="img-xs rounded-circle" src="/assets/images/faces/face15.jpg"
                                                alt="" />
                                        </div>
                                        <div class="profile-name">
                                            <h6 class="mb-0 font-weight-normal" style="color: #957dad">
                                                Henry Klein
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                viewBox="0 0 448 512">
                                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path
                                                    d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1 text-dark">Settings</p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item" href="{{ route('logout.artis') }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon rounded-circle">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                viewBox="0 0 512 512">
                                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path
                                                    d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1 text-dark">Keluar</p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>

            <!-- partial | ISI -->
            @yield('content')
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Kolaborasi</h1>
                    <button type="button" class="btn-unstyled" data-bs-dismiss="modal" aria-label="Close">
                        <i class="mdi mdi-close-circle-outline btn-icon text-danger"></i>
                    </button>
                </div>
                <div class="modal-body ">

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label"><b>Judul Lagu </b><strong class="">:</strong>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" value="Hai-hati di Jalan">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label"><b>Kategori </b><strong
                                class="">:</strong></label>
                        <div class="col-sm-5">
                            <input type="text" readonly class="form-control-plaintext" value="pop">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label"><b>Deskripsi </b><strong
                                class="">:</strong></label>
                        <div class="col-sm-5">
                            <p class="judul-lagu text-dark"> Menyatakan pertemuan sejoli dan
                                merasa satu sama lain sesusai dengan
                                kriteria idaman . Salah satu pihak lalu mengira mereka akan
                                bersama selamanya</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label"><b>Harga </b><strong class="">:</strong></label>
                        <div class="col-sm-5">
                            <input type="text" readonly class="form-control-plaintext" value="Rp 2.000.000,00">
                        </div>
                    </div>

                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-3">
                        <a href="{{ route('lirikAndChat') }}" class="btn-link"
                            style="color: inherit; text-decoration: none;">Buat
                            Proyek</a></button>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->

    <!-- summernote -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $('.summernote').summernote({
            placeholder: 'Hello stand alone ui',
            tabsize: 2,
            height: 320,
            disableResizeEditor: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });
    </script>
</body>

</html>
