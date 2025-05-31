
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>AmyGB.ai</title>
		<link rel="icon" type="image/x-icon" href="assets/img/favicon.png">

        <!-- Bootstrap Core CSS -->
        <link  rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"/>
        <link  rel="stylesheet" href="{{asset('assets/css/bootstrap-icons.min.css')}}"/>
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"> -->

        <!-- MetisMenu CSS -->
        <link href="{{asset('assets/js/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{asset('assets/css/sb-admin-2.css')}}" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="{{asset('assets/fonts/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
        {{-- <link rel="stylesheet" href="{{asset('assets/fonts/font-awesome/css/jquery.dataTables.min.css')}}"> --}}
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
            <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.dataTables.min.css')}}">
            <link rel="stylesheet" type="text/css" href="{{asset('assets/css/buttons.dataTables.min.css')}}">
            <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}">
            <link href="{{asset('assets/css/work-sans-fonts.css')}}" rel="stylesheet" type="text/css">
            <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
            
            <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
        {{-- <script src="{{asset('assets/js/jquery.min.js')}}" type="text/javascript"></script> --}}
        <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
        
        <script src="{{asset('assets/js/jquery-ui.js')}}"></script>
        <!-- DataTables CSS -->
    
        <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('assets/js/buttons.html5.min.js')}}"></script>
        <script src="{{asset('assets/js/buttons.print.min.js')}}"></script>
        <script src="{{asset('assets/js/customJS.js')}}"></script>
    
    </head>

    <body  data-bs-spy="scroll" data-bs-target=".header">



        <div id="wrapper">
            @if(session()->has('data'))
            <?php
               // echo "<pre>"; print_r(session('data'));


            ?>
            <?php
                 $url = parse_url($_SERVER['REQUEST_URI']);
                 $URLfilename = explode('/', $url['path']);
                 $fileName = end($URLfilename);
                //echo "<pre>"; print_r($_SESSION);
            ?>
            <!-- Navigation -->


            <div class="content">

            <!--success / error-->
                @if(Session::get('success'))
                    <?php $message = Session::get('success') ?>
                    <?php echo '<script>swal.fire({text:"'. $message .'",icon:"success",timer:3000,showConfirmButton:false});</script>' ?>
                @endif
                
                @if(Session::get('error'))
                    <?php $message = Session::get('error') ?>
                    <?php echo '<script>swal.fire({text:"'. $message .'",icon:"error",timer:3000,showConfirmButton:false});</script>' ?>
                @endif
            </div>
                <header id="header" class="header fixed-top d-flex align-items-center">

                    <div class="d-flex align-items-center justify-content-between">
                    <!-- <a href="{{asset('login')}}" class="logo d-flex align-items-center">
                        <img src="{{asset('assets/img/logo.png')}}" alt="Edas Logo">
                        {{-- <span class="d-none d-lg-block">Vahan</span> --}}
                    </a> -->
                    <!-- <i class="bi bi-list toggle-sidebar-btn"></i> -->
                    <a href="#" class="toggle-sidebar-btn">
                            <svg width="25" height="20" viewBox="0 0 25 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="menu">
                                <g id="&#240;&#159;&#166;&#134; icon &#34;menu scale&#34;">
                                <path id="Vector" d="M1 1H11.2857" stroke="black" stroke-width="1.41" stroke-linecap="round" stroke-linejoin="round"/>
                                <path id="Vector_2" d="M1 10H17.7143" stroke="black" stroke-width="1.41" stroke-linecap="round" stroke-linejoin="round"/>
                                <path id="Vector_3" d="M1 19H24.1429" stroke="black" stroke-width="1.41" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                                </g>
                            </svg>
                        </a>
                    </div><!-- End Logo -->

                    <!-- <div class="search-bar">
                    <form class="search-form d-flex align-items-center" method="POST" action="#">
                        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                    </form>
                    </div> -->
                    
                    <!-- End Search Bar -->

                    <nav class="header-nav ms-auto">
                    <ul class="d-flex align-items-center">
                        {{-- <li>
                            <a class="dropdown-item " href="">
                                <div class="box-header">
                                    <div>
                                        <!-- <i class="bi bi-credit-card-2-back-fill"></i> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
                                            <circle cx="16.5" cy="16.5" r="16.5" fill="#DFE5EF"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.41174 11.673V21.3274C8.41351 21.8511 8.61905 22.3525 8.98312 22.7214C9.34719 23.0903 9.83995 23.2964 10.3529 23.2943H21.9999C22.5129 23.2964 23.0058 23.0903 23.3698 22.7214C23.7339 22.3525 23.9394 21.8511 23.9412 21.3274V11.673C23.9394 11.1493 23.7339 10.6478 23.3698 10.2789C23.0058 9.91005 22.5129 9.70396 21.9999 9.70607H10.3529C9.83995 9.70396 9.34719 9.91005 8.98312 10.2789C8.61905 10.6478 8.41351 11.1493 8.41174 11.673Z" stroke="#1D4487" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M24.3704 15.2846C24.848 15.2846 25.2352 14.905 25.2352 14.4367C25.2352 13.9685 24.848 13.5889 24.3704 13.5889V15.2846ZM8.62953 13.5889C8.15187 13.5889 7.76465 13.9685 7.76465 14.4367C7.76465 14.905 8.15187 15.2846 8.62953 15.2846V13.5889ZM17.4837 18.7653C17.9614 18.7653 18.3486 18.3857 18.3486 17.9175C18.3486 17.4492 17.9614 17.0696 17.4837 17.0696V18.7653ZM8.62953 17.0696C8.15187 17.0696 7.76465 17.4492 7.76465 17.9175C7.76465 18.3857 8.15187 18.7653 8.62953 18.7653V17.0696ZM21.4189 18.7653C21.8966 18.7653 22.2838 18.3857 22.2838 17.9175C22.2838 17.4492 21.8966 17.0696 21.4189 17.0696V18.7653ZM20.4352 17.0696C19.9575 17.0696 19.5703 17.4492 19.5703 17.9175C19.5703 18.3857 19.9575 18.7653 20.4352 18.7653V17.0696ZM24.3704 13.5889H8.62953V15.2846H24.3704V13.5889ZM17.4837 17.0696H8.62953V18.7653H17.4837V17.0696ZM21.4189 17.0696H20.4352V18.7653H21.4189V17.0696Z" fill="#1D4487"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5>Credit</h5>
                                        <p>Rs.9000</p>
                                    </div>
                                </div>
                         
                                
                            </a>
                        </li> --}}
                        @if(session('data.userRole') == 'user' || session('data.userRole') == 'admin')
                        <li>
                            <a class="dropdown-item">
                                <div class="box-header">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
                                            <circle cx="16.5" cy="16.5" r="16.5" fill="#DFE5EF"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.41174 11.673V21.3274C8.41351 21.8511 8.61905 22.3525 8.98312 22.7214C9.34719 23.0903 9.83995 23.2964 10.3529 23.2943H21.9999C22.5129 23.2964 23.0058 23.0903 23.3698 22.7214C23.7339 22.3525 23.9394 21.8511 23.9412 21.3274V11.673C23.9394 11.1493 23.7339 10.6478 23.3698 10.2789C23.0058 9.91005 22.5129 9.70396 21.9999 9.70607H10.3529C9.83995 9.70396 9.34719 9.91005 8.98312 10.2789C8.61905 10.6478 8.41351 11.1493 8.41174 11.673Z" stroke="#1D4487" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M24.3704 15.2846C24.848 15.2846 25.2352 14.905 25.2352 14.4367C25.2352 13.9685 24.848 13.5889 24.3704 13.5889V15.2846ZM8.62953 13.5889C8.15187 13.5889 7.76465 13.9685 7.76465 14.4367C7.76465 14.905 8.15187 15.2846 8.62953 15.2846V13.5889ZM17.4837 18.7653C17.9614 18.7653 18.3486 18.3857 18.3486 17.9175C18.3486 17.4492 17.9614 17.0696 17.4837 17.0696V18.7653ZM8.62953 17.0696C8.15187 17.0696 7.76465 17.4492 7.76465 17.9175C7.76465 18.3857 8.15187 18.7653 8.62953 18.7653V17.0696ZM21.4189 18.7653C21.8966 18.7653 22.2838 18.3857 22.2838 17.9175C22.2838 17.4492 21.8966 17.0696 21.4189 17.0696V18.7653ZM20.4352 17.0696C19.9575 17.0696 19.5703 17.4492 19.5703 17.9175C19.5703 18.3857 19.9575 18.7653 20.4352 18.7653V17.0696ZM24.3704 13.5889H8.62953V15.2846H24.3704V13.5889ZM17.4837 17.0696H8.62953V18.7653H17.4837V17.0696ZM21.4189 17.0696H20.4352V18.7653H21.4189V17.0696Z" fill="#1D4487"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5>Credit</h5>
                                        <p>
                                            <span id="availableBalance"> 0.00</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li class="dropdown notification-btn notify-defult">
                            <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="16.5" cy="16.5" r="16.5" fill="#EFDFDF"/>
                                <g clip-path="url(#clip0_650_2249)">
                                <path d="M16 24.9999C16.5304 24.9999 17.0391 24.7892 17.4142 24.4141C17.7893 24.039 18 23.5303 18 22.9999H14C14 23.5303 14.2107 24.039 14.5858 24.4141C14.9609 24.7892 15.4696 24.9999 16 24.9999ZM16 10.9179L15.203 11.0789C14.299 11.2631 13.4863 11.754 12.9027 12.4685C12.319 13.183 12.0001 14.0773 12 14.9999C12 15.6279 11.866 17.1969 11.541 18.7419C11.381 19.5089 11.165 20.3079 10.878 20.9999H21.122C20.835 20.3079 20.62 19.5099 20.459 18.7419C20.134 17.1969 20 15.6279 20 14.9999C19.9997 14.0775 19.6807 13.1834 19.097 12.4691C18.5134 11.7548 17.7009 11.2641 16.797 11.0799L16 10.9179ZM22.22 20.9999C22.443 21.4469 22.701 21.8009 23 21.9999H9C9.299 21.8009 9.557 21.4469 9.78 20.9999C10.68 19.1999 11 15.8799 11 14.9999C11 12.5799 12.72 10.5599 15.005 10.0989C14.991 9.95985 15.0064 9.81942 15.05 9.68667C15.0937 9.55392 15.1647 9.43179 15.2584 9.32816C15.3522 9.22452 15.4666 9.14169 15.5943 9.085C15.7221 9.02831 15.8603 8.99902 16 8.99902C16.1397 8.99902 16.2779 9.02831 16.4057 9.085C16.5334 9.14169 16.6478 9.22452 16.7416 9.32816C16.8353 9.43179 16.9063 9.55392 16.95 9.68667C16.9936 9.81942 17.009 9.95985 16.995 10.0989C18.1253 10.3288 19.1414 10.9423 19.8712 11.8354C20.6011 12.7285 20.9999 13.8465 21 14.9999C21 15.8799 21.32 19.1999 22.22 20.9999Z" fill="red"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_650_2249">
                                <rect width="16" height="16" fill="white" transform="translate(8 9)"/>
                                </clipPath>
                                </defs>
                            </svg>
                            <span class="notification-number "></span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                                <div class="list-group">
                                    
                                    <a href="#" class="list-group-item list-group-item-action d-flex gap-1 py-3" aria-current="true">
                                    <div class="d-flex gap-1 w-100 justify-content-between">
                                        <div>
                                     
                                        <p class="mb-0 opacity-75">Subject</p>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </ul>
                        </li>
                       
                        @endif
                        <li class="nav-item dropdown manage-profile">

                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <!-- <img src="{{asset('assets/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle"> -->
                            <i class="bi bi-person user-icon"></i>
                            <span class="d-none d-md-block dropdown-toggle ps-2">{{Str::ucfirst(session('data.Name'))}}</span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6>{{session('data.userRole')}}</i></h6>
                            </li>
                            {{-- <li>
                                <i class="bi bi-award" title="Email ID"> Email Id : </i> <span>sdf{{session('data.email')}}</span>
                            </li>
                            <li>
                                <i class="bi bi-award" title="Last login"> Last Login At:</i> <span>sdf{{session('data.email')}}</span>
                            </li> --}}
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{asset('password/reset')}}">
                                    <i class="bi bi-gear"></i>
                                    <span>Reset Password</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{asset('signout')}}">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>

                        </ul><!-- End Profile Dropdown Items -->
                        </li><!-- End Profile Nav -->

                    </ul>
                    </nav><!-- End Icons Navigation -->

                </header>
                <aside id="sidebar" class="sidebar">

                    <ul class="sidebar-nav" id="sidebar-nav">
                        <a href="{{asset('login')}}" class="logo d-flex justify-content-center">
                            <img src="{{asset('assets/img/logo.png')}}" alt="Edas Logo">
                            <!-- <span class="d-none d-lg-block">Vahan</span> -->
                        </a>
                  <?php

                    //  $sessionData = session('data');
                    //  print_r($sessionData);//die;
                    ?>
                    @if(session('data.userRole') == 'user')
                        <li class="nav-item">
                            <a class="nav-link <?php if($fileName == 'dashboard'){ echo "";} else { echo "collapsed";}?>" href="{{asset('dashboard')}}">
                                <i class="bi bi-receipt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                       <?php
                       $apiArr = session('data.api_list');
                        
                        if(!empty($apiArr))
                        {
                            $viewFilenames = array_values(array_column($apiArr, 'view_filename'));
                             ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if(in_array($fileName, $viewFilenames)){ echo '';} else { echo 'collapsed';} ?>" data-bs-target="#Module-nav" data-bs-toggle="collapse" href="#">
                                    <i class="bi bi-award"></i><span>Module</span><i class="bi bi-chevron-down ms-auto"></i>
                                </a>
                                <ul id="Module-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <?php foreach($apiArr as $k => $val) { ?>
                                    <li>
                                        <a href="{{asset($val['view_filename'])}}">
                                            <i class="bi bi-circle"></i><span>{{strtoupper($val['api_alias'])}}</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            
                                </ul>
                            </li>
                        <?php  }  ?>
                        {{-- <li class="nav-item">
                            <a class="nav-link collapsed" data-bs-target="#Report-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-file-earmark-text"></i><span>Report</span><i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul id="Report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li>
                                    <a href="{{asset('report')}}">
                                    <i class="bi bi-circle"></i><span>Login Activity</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{asset('dashboardreport')}}">
                                    <i class="bi bi-circle"></i><span>Module Activity</span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                    <!-- End RC Nav -->
                    @endif 
                    @if(session('data.userRole') == 'super_admin')

                        {{-- <li class="nav-item">
                            <a class="nav-link <?php if($fileName == 'dashboard'){ echo "";} else { echo "collapsed";}?>" href="{{asset('dashboard')}}">
                                <i class="bi bi-layout-sidebar"></i>
                                <span>Dashboard</span>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" data-bs-target="#Dashboard-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-layout-sidebar"></i><span>Dashboard</span><i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul id="Dashboard-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li>
                                    <a href="{{asset('dashboard')}}">
                                    <i class="bi bi-circle"></i><span>Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/bi_dashboard') }}">
                                        <i class="bi bi-circle"></i>
                                        <span>BI Dashboard</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" data-bs-target="#Organization-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-receipt"></i><span>Organization</span><i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul id="Organization-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li>
                                    <a href="{{asset('company')}}">
                                        <i class="bi bi-circle"></i><span>Organization List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/company/create') }}">
                                    <i class="bi bi-circle"></i><span>Add New</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" data-bs-target="#User-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-award"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul id="User-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li>
                                    <a href="{{asset('users')}}">
                                    <i class="bi bi-circle"></i><span>User List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('users.create') }}">
                                    <i class="bi bi-circle"></i><span>Add New</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link collapsed" data-bs-target="#Module-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-person-vcard"></i><span>Module</span><i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul id="Module-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li>
                                    <a href="{{asset('module')}}">
                                    <i class="bi bi-circle"></i><span>Module List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('module.create') }}">
                                    <i class="bi bi-circle"></i><span>Add New</span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" data-bs-target="#Report-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-file-earmark-text"></i><span>Report</span><i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul id="Report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li>
                                    <a href="{{asset('report')}}">
                                    <i class="bi bi-circle"></i><span>Login Activity</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{asset('dashboardreport')}}">
                                    <i class="bi bi-circle"></i><span>Module Activity</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{asset('rcbulkreport')}}">
                                    <i class="bi bi-circle"></i>
                                    <span>RC-Bulk List</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link collapsed" data-bs-target="#BillReport-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-file-earmark-text"></i><span>Billing Report</span><i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul id="BillReport-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                
                                <li>
                                    <a href="{{asset('summarybillingreport')}}">
                                    <i class="bi bi-circle"></i><span>Summary Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{asset('billingreport')}}">
                                    <i class="bi bi-circle"></i><span>Module Report</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                    @endif

                    @if(session('data.userRole') == 'admin')

                        <li class="nav-item">
                            <a class="nav-link <?php if($fileName == 'dashboard'){ echo "";} else { echo "collapsed";}?>" href="{{asset('dashboard')}}">
                            <i class="bi bi-layout-sidebar"></i>
                            <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" data-bs-target="#User-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-award"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul id="User-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li>
                                    <a href="{{asset('users')}}">
                                    <i class="bi bi-circle"></i><span>User List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('users.create') }}">
                                    <i class="bi bi-circle"></i><span>Add New</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" data-bs-target="#Report-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-file-earmark-text"></i><span>Report</span><i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul id="Report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li>
                                    <a href="{{asset('report')}}">
                                    <i class="bi bi-circle"></i><span>Login Activity</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{asset('dashboardreport')}}">
                                    <i class="bi bi-circle"></i><span>Module Activity</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{asset('rcbulkreport')}}">
                                    <i class="bi bi-circle"></i>
                                    <span>RC-Bulk List</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    
                </ul>
                </aside>
                {{-- <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0"> --}}
                    <!-- <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="">Administrator</a>
                    </div> -->
                    <!-- /.navbar-header -->

                    <!-- <ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                                </li>
                                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="logout.blade.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul> -->
                    <!-- /.navbar-top-links -->

                    <!-- <div class="navbar-default sidebar" role="navigation">
                        <div class="sidebar-nav navbar-collapse">
                            <ul class="nav" id="side-menu">
                               <li>
                                    <a href="index.blade.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                                </li>
                                <li>
                                    <a href="rc_details.blade.php"><i class="fa fa-users fa-fw"></i> RC Details</a>
                                </li>
                                <li>
                                    <a href="challan_details.blade.php"><i class="fa fa-users fa-fw"></i> Challan Details</a>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                    <!-- /.navbar-static-side -->
                {{-- </nav> --}}
            @endif
            <!-- The End of the Header -->
            <div class="content">
                @yield('content')
            </div>

            </div>
    <!-- /#wrapper -->

    <!-- jQuery -->


    <!-- Bootstrap Core JavaScript -->
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{asset('assets/js/metisMenu/metisMenu.min.js')}}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{asset('assets/js/sb-admin-2.js')}}"></script>
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->

    <script>
        $(document).ready(function(){

            var sessionData = @json(session()->all());

            getAvailableBalance();

            getNotifications();
            

                $('.list-group').on('click', 'a.list-group-item', function(e) {
                    e.preventDefault();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var notification_id = $(this).data('notification-id');
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                    });
                    // Perform the Ajax call using the notificationId variable
                    $.ajax({
                        url: "{{ route('notification.change')}}",
                        type: 'POST',
                        data: {
                            notification_id: notification_id
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr) {
                            // Handle the error response
                        }
                    });
                });

        });

        function getAvailableBalance()
        {   
            var sessionData = @json(session()->all());
            
            var userrole = sessionData.data.Role; 
            if(userrole != 'super_admin'){
                $.ajax({
                    url: "{{ route('header.balance')}}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(availableBalance) {
                        $("#availableBalance").html(availableBalance);
                    }
                });
            }
        }


        function getNotifications() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var sessionData = @json(session()->all());
            
    var userid = sessionData.data.userID; 
    var clientid = sessionData.data.Client_id;

    if (userid != null && clientid != null) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        // Make the Ajax request
        $.ajax({
            url: "{{ route('notification.data') }}",
            type: 'POST',
            data: { userid: userid, clientid: clientid },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response != null && response.length > 0) { // Check if the response is not empty
                    $('.list-group').empty();

                    $.each(response, function(index, item) {
                        var notificationItem = $('<a>', {
                            class: 'list-group-item list-group-item-action d-flex gap-1 py-3',
                            href: '#',
                            'aria-current': 'true',
                            'data-notification-id': item.id
                        }).appendTo('.list-group');

                        $('.notification-btn').addClass('notify').removeClass('notify-defult');

                        var notificationContent = $('<div>', {
                            class: 'd-flex gap-1 w-100 justify-content-between'
                        }).appendTo(notificationItem);

                        var notificationText = $('<div>').appendTo(notificationContent);

                        $('<p>', {
                            class: 'mb-0 opacity-75 fw-bold',
                            text: item.subject
                        }).appendTo(notificationText);

                        $('<p>', {
                            class: 'mb-0 opacity-75',
                            text: item.created_at
                        }).appendTo(notificationText);
                    });
                } else {
                    $('.list-group').empty(); // Clear the list if the response is empty
                    $('.notification-btn').addClass('notify-defult').removeClass('notify');
                }
            },
            error: function(xhr, status, error) {
                // Handle the error
                console.log('AJAX Error:', error);
            }
        });
    } else {
        $('.list-group').empty(); // Clear the list if either userid or clientid is null
        $('.notification-btn').addClass('notify-defult').removeClass('notify');
    }
}

        // function getNotifications(){
        //     var csrfToken = $('meta[name="csrf-token"]').attr('content');
        //     var sessionData = @json(session()->all());
            
        //     var userid = sessionData.data.userID; 
        //     var clientid = sessionData.data.Client_id;

        //     if(userid != null && clientid != null ){
        //         //console.log(sessionData);
        //         $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': csrfToken
        //         }
        //         });
        //         // Make the Ajax request
        //         $.ajax({
        //             url: "{{ route('notification.data') }}",
        //             type: 'POST',
        //             data: { userid : userid ,clientid : clientid },
        //             dataType: 'json',
        //             success: function(response) {
        //                 console.log(response);
        //             if(response != null || response != undefined){

        //                 $('.list-group').empty();

        //                 $.each(response, function(index, item) {

        //                     var notificationItem = $('<a>', {
        //                         class: 'list-group-item list-group-item-action d-flex gap-1 py-3',
        //                         href: '#',
        //                         'aria-current': 'true',
        //                         'data-notification-id': item.id
        //                     }).appendTo('.list-group');

        //                     $('.notification-btn').addClass('notify').removeClass('notify-defult');

        //                     var notificationContent = $('<div>', {
        //                         class: 'd-flex gap-1 w-100 justify-content-between'
        //                     }).appendTo(notificationItem);

        //                     var notificationText = $('<div>').appendTo(notificationContent);

        //                     $('<p>', {
        //                         class: 'mb-0 opacity-75 fw-bold',
        //                         text: item.subject
        //                     }).appendTo(notificationText);

        //                     $('<p>', {
        //                         class: 'mb-0 opacity-75',
        //                         text: item.created_at
        //                     }).appendTo(notificationText);
                          
        //                 });
        //             }
        //             else if(response == null || response == undefined){
        //                 $('.notification-btn').addClass('notify-defult').removeClass('notify');
        //             }
        //             else{
        //                 $('.notification-btn').addClass('notify-defult').removeClass('notify');
        //             }
        //             },
        //             error: function(xhr, status, error) {
        //                 // Handle the error
        //                 console.log('AJAX Error:', error);
        //             }
        //             });
        //         }
        // }

        setInterval(getNotifications, 5000);
    </script>

</body>

</html>