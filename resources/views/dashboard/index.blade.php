<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title>Cemara Multi Kreatif App</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Cemara Inventory - Build with Laravel" name="description" />
        <meta content="Riski" name="author" />
        <meta name='robots' content='noindex,follow' />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- google font -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
        
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('app.css') }}" rel="stylesheet" type="text/css" />

        <!-- Sweet Alerts js -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

        <script>
        var sounds = {
            "dead": {
                url: "{{ asset('assets/sounds/dead.wav') }}"
            },
            "smash": {
                url: "{{ asset('assets/sounds/smash.mp3') }}"
            },
            "ping": {
                url: "{{ asset('assets/sounds/ping.mp3') }}"
            },
            "bump": {
                url: "{{ asset('assets/sounds/bump.mp3') }}"
            },
            "jump": {
                url: "{{ asset('assets/sounds/jump.wav') }}"
            },
            "coin": {
                url: "{{ asset('assets/sounds/coin.mp3') }}"
            },
            "jo": {
                url: "{{ asset('assets/sounds/spongebob_song_remix.mp3') }}"
            }
        };
        </script>

        <!-- sound js -->
        <script src="{{ asset('assets/js/sound.js') }}"></script>

    </head>

    <body data-topbar="colored">

        <!-- Begin page -->
        <div id="layout-wrapper">

            @include('layouts.header')

            @include('layouts.sidebar')

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">

                    <!-- Page-Title -->
                    <div class="page-title-box">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="page-title mb-1">{{ $pageTitle }}</h4>
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Cemara App</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right d-none d-md-block">
                                        <div class="dropdown">
                                            <button class="btn btn-help btn-rounded">
                                                <i class="mdi mdi-coffee mr-1"></i> Bantuan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title end breadcrumb -->

                    <div class="page-content-wrapper">
                        <div class="container-fluid">
                            <div class="row" id="inventory-stats">

                                <div class="col-sm-12 col-lg-4">
                                    <div class="card greeting">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-7">
                                                    <h5>Welcome Back !</h5>

                                                    @if(Auth::user()->id == 3)
                                                        <h2 class="name" style="font-size: 22px">{{ Auth::user()->name }}</h2>
                                                    @else
                                                        <h2 class="name">{{ Auth::user()->name }}</h2>
                                                    @endif

                                                    <div class="mt-4">
                                                        <a href="#" class="btn btn-primary btn-sm">Start <i class="mdi mdi-arrow-right ml-1"></i></a>
                                                    </div>
                                                </div>

                                                <div class="col-5 ml-auto">
                                                    <div>
                                                        <img src="assets/images/widget-img.png" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-8">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5>Inventories</h5>
                                                            <span class="big-count">{{ \App\InventoryItem::count() }}</span>
        
                                                            <div class="mt-2">
                                                                <a href="{{ route('inventory.index') }}" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ml-1"></i></a>
                                                            </div>
                                                        </div>
        
                                                        <div class="col-md-5 ml-auto icon">
                                                            <div class="stats-icon">
                                                                <i class="mdi mdi-buffer"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-sm-6 col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5>Brands</h5>
                                                            <span class="big-count">{{ \App\InventoryBrand::count() }}</span>
        
                                                            <div class="mt-2">
                                                                <a href="{{ route('brands.index') }}" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ml-1"></i></a>
                                                            </div>
                                                        </div>
        
                                                        <div class="col-md-5 ml-auto icon">
                                                            <div class="stats-icon">
                                                                <i class="mdi mdi-bookmark-check"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-sm-6 col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5>Categories</h5>
                                                            <span class="big-count">{{ \App\InventoryCategory::count() }}</span>
        
                                                            <div class="mt-2">
                                                                <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ml-1"></i></a>
                                                            </div>
                                                        </div>
        
                                                        <div class="col-md-5 ml-auto icon">
                                                            <div class="stats-icon">
                                                                <i class="mdi mdi-animation"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mt-2" id="jo-stats">
                                <div class="col-sm-12">
                                    <div class="title">
                                        <h4>Job Schedule</h4>
                                    </div>
                                </div>
                                
                                <div class="col-md-2 col-lg-3">
                                    <div class="card total">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <h5>Total JO</h5>
                                                    <span class="big-count">{{ \App\Jo::count() }}</span>

                                                    <div class="mt-4">
                                                        <a href="{{ route('job') }}" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ml-1"></i></a>
                                                    </div>
                                                </div>

                                                <div class="col-md-5 ml-auto icon">
                                                    <div class="stats-icon">
                                                        <i class="mdi mdi-coffee"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-3">
                                    <div class="card waiting-list">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <h5>Waiting List</h5>
                                                    <span class="big-count">{{ \App\Jo::where('jo_status_id', 1)->count() }}</span>

                                                    <div class="mt-4">
                                                        <a href="{{ route('job-waiting-list') }}" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ml-1"></i></a>
                                                    </div>
                                                </div>

                                                <div class="col-md-5 ml-auto icon">
                                                    <div class="stats-icon">
                                                        <i class="mdi mdi-clock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-3">
                                    <div class="card progrs">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <h5>JO Progress</h5>
                                                    <span class="big-count">{{ \App\Jo::where('jo_status_id', 2)->count() }}</span>

                                                    <div class="mt-4">
                                                        <a href="{{ route('job-progress') }}" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ml-1"></i></a>
                                                    </div>
                                                </div>

                                                <div class="col-md-5 ml-auto icon">
                                                    <div class="stats-icon">
                                                        <i class="mdi mdi-trending-up"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-3">
                                    <div class="card done">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <h5>JO Selesai</h5>
                                                    <span class="big-count">{{ \App\Jo::where('jo_status_id', 3)->count() }}</span>

                                                    <div class="mt-4">
                                                        <a href="{{ route('job-done') }}" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ml-1"></i></a>
                                                    </div>
                                                </div>

                                                <div class="col-md-5 ml-auto icon">
                                                    <div class="stats-icon">
                                                        <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title mb-4">Statistik JO (v1.0 Aphla Belum Fix)</h4>
    
                                            <div id="spline_area" class="apex-charts" dir="ltr"></div>
                                        </div>
                                    </div><!--end card-->
                                </div>
                            </div>
                            <!-- end row -->


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title mb-4">Statiksik v2</h4>
                                            
                                            <div id="mixed_chart" class="apex-charts" dir="ltr"></div> 
                                        </div>
                                    </div><!--end card-->
                                </div>
                                <div class="col-xl-6 d-none">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title mb-4">Radial Chart</h4>
                                            
                                            <div id="radial_chart" class="apex-charts" dir="ltr"></div>  
                                        </div>
                                    </div><!--end card-->
                                    
                                </div>
                            </div>
                            <!-- end row -->





                        </div>
                        <!-- end container-fluid -->
                    </div>
                    <!-- end page-content-wrapper -->
                </div>
                <!-- End Page-content -->


                @include('layouts.footer')
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        @include('layouts.right_sidebar')
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

        <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>


        <script src="{{ asset('assets/js/app.js') }}"></script>

        <!-- Plugin Js-->
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <!-- demo js-->
        <script src="{{ asset('assets/js/pages/apex.init.js') }}"></script>   
        
        
        <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
        {{-- Uji hanya tim produksi yang akan menerima notification ini --}}
        @if(Auth::user()->role->id == 3)
            <script>
            var pusher = new Pusher('72f209b771778f605aa1', {
                cluster: 'ap1',
                encrypted: true
            });

            //Also remember to change channel and event name if your's are different.
            var channel = pusher.subscribe('notification');
            channel.bind('notification-event', function(message) {
                Swal.fire({
                    icon: 'info',
                    title: message,
                    text: 'Ada jo baru',
                    footer: '<a href="{{ route('job') }}">Refresh Halaman JO</a>'
                });
                playSound("jo");
            });
            </script>
        @endif
        
    </body>
</html>
