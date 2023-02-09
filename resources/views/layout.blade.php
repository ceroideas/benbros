<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Benbros</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{url('adminlte')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{url('adminlte')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('adminlte')}}/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="{{ asset('/pnotify/PNotifyBrightTheme.css') }}" />

  <style>
    .filters th .inline-fields::placeholder {
      color: #c0c0c0 !important;
    }
  	.top-item {
  		position: relative;
  	}
  	.top-item ul li { list-style: none; }
  	.top-item ul li a { display: block; color: #fff !important; padding: 4px; }
  	.top-item ul li a:hover { background-color: gray; }
  	.top-item ul {
  		display: none;
  		position: absolute;
  		background: #4b545c;
  		border-radius: .25rem;
  		padding: 8px;
  	}
  	.top-item:hover ul {
  		display: block;
  	}

  	.info-box {
  		min-height: 84px !important;
  	}

  	.small-box {
  		min-height: 40px !important;
  	}

  	.info-box-number-2 {
  		float: right;
  	}

    th {
      background-color: #2a3963 !important;
      color: #fff !important;
    }

    th input {
      color: #fff;
    }

    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
      background-color: #2a3963 !important;
    }
  </style>

  <style>
  .inline-fields {
    min-width: 182px;
    width: 100%;
    min-height: 36px !important;
    background-color: transparent;
    border: none;
    border-bottom: 1px solid silver;
    outline: none;
  }
  .content .container-fluid {
    padding-bottom: 80px;
  }

  .table-hover tbody tr:hover {
    color: #333 !important;
    font-weight: bolder;
  }
</style>
</head>
<body class="hold-transition dark-mode- sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{url('adminlte')}}/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="{{url('/')}}" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item top-item d-none d-sm-inline-block">
        <a href="{{url('/lands')}}" class="nav-link">{{trans('layout.menu_1')}}</a>
      </li>
      <li class="nav-item top-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">{{trans('layout.menu_2')}}</a>
        <ul>
        	<li><a href="{{url('/total')}}">{{trans('layout.menu_2_1')}}</a></li>
        	<li><a href="{{url('/partners')}}">{{trans('layout.menu_3')}}</a></li>
        	<li><a href="{{url('/contract-documents')}}">{{trans('layout.menu_4')}}</a></li>
        </ul>
      </li>

      <li class="nav-item top-item d-none d-sm-inline-block">
        <a href="{{url('/projects')}}" class="nav-link">{{trans('layout.menu_5')}}</a>
      </li>

      <li class="nav-item top-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">{{trans('layout.menu_6')}}</a>
        <ul>
        	<li><a href="{{url('/benbros-partners')}}">{{trans('layout.menu_partner')}}</a></li>
        	<li><a href="{{url('/administration-organ')}}">{{trans('layout.menu_7')}}</a></li>
        	<li><a href="{{url('/compliance-documents')}}">{{trans('layout.menu_8')}}</a></li>
          {{-- <li><a href="{{url('/proxies')}}">{{trans('layout.menu_9')}}</a></li> --}}
          <li><a href="{{url('/legal-documents')}}">{{trans('layout.menu_10')}}</a></li>
        </ul>
      </li>

      <li class="nav-item top-item d-none d-sm-inline-block">
        <a href="{{url('/m_a-documents')}}" class="nav-link">{{trans('layout.menu_6_1')}}</a>
      </li>

      <li class="nav-item top-item d-none d-sm-inline-block">
        @if (\App::getLocale() == 'es')
        <a href="{{url('changeLang/en')}}" class="nav-link">Inglés</a>
        @else
        <a href="{{url('changeLang/es')}}" class="nav-link">Spanish</a>
        @endif
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="javascript:;" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="javascript:;">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="javascript:;" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{url('adminlte')}}/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="javascript:;" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{url('adminlte')}}/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="javascript:;" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{url('adminlte')}}/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="javascript:;" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="javascript:;">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="javascript:;" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="javascript:;" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="javascript:;" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="javascript:;" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> --}}
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="javascript:;" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="javascript:;" role="button">
          <i class="fas fa-bell"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link" style="padding: 0;">
      <img src="{{url('logo.png')}}" alt="AdminLTE Logo" class="brand-image -img-circle elevation-3" style="opacity: 1; max-height: 56px !important; display: block;
    margin: auto;
    float: unset;
    box-shadow: none !important;">
      {{-- <span class="brand-text font-weight-light">AdminLTE 3</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <div class="img-circle elevation-2" style="width: 34px; height: 34px;background-size: cover; background-position: center; background-image: url('{{url('uploads/avatars',Auth::user()->avatar)}}');">
            
          </div>
          {{-- <img src="" class="img-circle elevation-2" alt="User Image"> --}}
        </div>
        <div class="info">
          <a href="{{url('profile')}}" class="d-block">{{Auth::user()->name}} <i class="fa fa-pencil"></i></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{url('/')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                {{trans('layout.menu_11')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/')}}" class="nav-link active">
                  {{-- <i class="far fa-circle nav-icon"></i> --}}
                  <p> &nbsp;&nbsp;&nbsp;&nbsp; {{trans('layout.menu_12')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/projects')}}" class="nav-link">
                  {{-- <i class="far fa-circle nav-icon"></i> --}}
                  <p> &nbsp;&nbsp;&nbsp;&nbsp; {{trans('layout.menu_13')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/subcontractors')}}" class="nav-link">
                  {{-- <i class="far fa-circle nav-icon"></i> --}}
                  <p> &nbsp;&nbsp;&nbsp;&nbsp; {{trans('layout.menu_14')}}</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{url('/technologies')}}" class="nav-link">
              <i class="nav-icon far fa-window-restore"></i>
              <p>{{trans('layout.menu_technologies')}}</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('/contacts')}}" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>{{trans('layout.menu_15')}}</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('/chat')}}" class="nav-link" style="position: relative;">
              <span id="bubble-chat" style="width: fit-content; border-radius: 4px; background-color: crimson;
              color: #fff; font-size: 8px; padding: 0 2px; position: absolute; top: 8px; left: 8;
              display: {{
                App\Models\Message::where('to',Auth::id())->where('seen',null)->count()
                || App\Models\Message::where('to',null)->
                    where(function($q){
                        $q->
                        where('seen',null)->
                        orWhere('seen','not like',"%\"".Auth::id()."\"%");
                    })
                    ->count()
                ? 'block' : 'none' }};">new</span>
              <i class="nav-icon far fa-comment"></i>
              <p>{{trans('layout.menu_16')}}</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('/other-information')}}" class="nav-link">
              {{-- <i class="nav-icon far fa-envelope"></i> --}}
              <p>{{trans('layout.menu_6_2')}}</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('/logout')}}" class="nav-link">
              {{-- <i class="nav-icon far fa-logout"></i> --}}
              <p>{{trans('layout.menu_17')}}</p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- /.content-header -->

    <!-- Main content -->
    @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3 control-sidebar-content">
      <h5>Notificaciones Activas</h5><hr class="mb-2"/>

      <h6>Benbros Solar</h6>

      @php
        use App\Models\Notification;
        use Carbon\Carbon;

        $vencidas = Notification::where('type',1)->where('duration','mismo dia')->where('notification_date','<',Carbon::today()->format('Y-m-d'))->count();

        $one_day = Notification::where('type',1)->where('duration','mismo dia')
          ->where('notification_date','>=',Carbon::today()->addDay(1)->format('Y-m-d'))
          ->where('notification_date','=<',Carbon::today()->addDays(2)->format('Y-m-d'))

          ->count();
        $two_weeks = Notification::where('type',1)->where('duration','mismo dia')
          ->where('notification_date','>=',Carbon::today()->addWeeks(2)->format('Y-m-d'))
          ->where('notification_date','=<',Carbon::today()->addWeeks(2)->addDay(1)->format('Y-m-d'))

          ->count();
        $six_weeks = Notification::where('type',1)->where('duration','mismo dia')
          ->where('notification_date','>=',Carbon::today()->addWeeks(6)->format('Y-m-d'))
          ->where('notification_date','=<',Carbon::today()->addWeeks(6)->addDay(1)->format('Y-m-d'))

          ->count();
        $no_vencidas = Notification::where('type',1)->where('duration','mismo dia')->where('notification_date','>',Carbon::today()->addWeeks(6)->addDay(1)->format('Y-m-d'))->count();
      @endphp

      <span>{{trans('layout.expired')}}: {{$vencidas}} </span> <br>
      <span>{{trans('layout.notice_1')}}: {{$one_day}} </span> <br>
      <span>{{trans('layout.notice_2')}}: {{$two_weeks}} </span> <br>
      <span>{{trans('layout.notice_6')}}: {{$six_weeks}} </span> <br>
      <span>{{trans('layout.not_expired')}}: {{$no_vencidas}} </span> <br>

      <br>

      <h6>Benbros Energy</h6>

      @php
        $vencidas_1 = Notification::where('type',2)->where('duration','mismo dia')->where('notification_date','<',Carbon::today()->format('Y-m-d'))->count();
        
        $one_day = Notification::where('type',2)->where('duration','mismo dia')
          ->where('notification_date','>=',Carbon::today()->addDay(1)->format('Y-m-d'))
          ->where('notification_date','=<',Carbon::today()->addDays(2)->format('Y-m-d'))

          ->count();
        $two_weeks = Notification::where('type',2)->where('duration','mismo dia')
          ->where('notification_date','>=',Carbon::today()->addWeeks(2)->format('Y-m-d'))
          ->where('notification_date','=<',Carbon::today()->addWeeks(2)->addDay(1)->format('Y-m-d'))

          ->count();
        $six_weeks = Notification::where('type',2)->where('duration','mismo dia')
          ->where('notification_date','>=',Carbon::today()->addWeeks(6)->format('Y-m-d'))
          ->where('notification_date','=<',Carbon::today()->addWeeks(6)->addDay(1)->format('Y-m-d'))

          ->count();
        $no_vencidas = Notification::where('type',2)->where('duration','mismo dia')->where('notification_date','>',Carbon::today()->addWeeks(6)->addDay(1)->format('Y-m-d'))->count();
      @endphp

      <span>{{trans('layout.expired')}}: {{$vencidas_1}} </span> <br>
      <span>{{trans('layout.notice_1')}}: {{$one_day}} </span> <br>
      <span>{{trans('layout.notice_2')}}: {{$two_weeks}} </span> <br>
      <span>{{trans('layout.notice_6')}}: {{$six_weeks}} </span> <br>
      <span>{{trans('layout.not_expired')}}: {{$no_vencidas}} </span> <br>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2022 <a target="_blank" href="https://ceroideas.es">Cero Ideas</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->

<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script src="{{url('adminlte')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{url('adminlte')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{url('adminlte')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{url('adminlte')}}/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{url('adminlte')}}/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="{{url('adminlte')}}/plugins/raphael/raphael.min.js"></script>
{{-- <script src="{{url('adminlte')}}/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="{{url('adminlte')}}/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<script src="{{url('adminlte')}}/plugins/jquery-mapael/maps/spain.min.js"></script> --}}
<!-- ChartJS -->
<script src="{{url('adminlte')}}/plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
{{-- <script src="{{url('adminlte')}}/dist/js/demo.js"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('adminlte')}}/dist/js/pages/dashboard2.js"></script>

<script type="text/javascript" src="{{ asset('/pnotify/PNotify.js') }}"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/b-2.2.2/fc-4.0.2/r-2.2.9/datatables.min.css"/>

<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
 
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/b-2.2.2/fc-4.0.2/r-2.2.9/datatables.min.js"></script>

<!-- DataTables  & Plugins -->
{{-- <script src="{{url('adminlte')}}/plugins/datatables/jquery.dataTables.min.js"></script> --}}
<script src="{{url('adminlte')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{url('adminlte')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{url('adminlte')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{url('adminlte')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

@yield('scripts')
@yield('scripts1')
@yield('scripts2')

<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "1dcda926-e4ba-4904-bcb0-c0348f1030b0",
    });
  });
</script>

<script>
  
  @if ($vencidas || $vencidas_1)
    
    var notice = PNotify.notice({
          title: "{{trans('layout.warning')}}",
          text: `{{trans('layout.expired_con')}}:
          @if ($vencidas)
            <div>Benbros Solar: {{$vencidas}}</div>
          @endif
          @if ($vencidas_1)
            <div>Benbros Energy: {{$vencidas_1}}</div>
          @endif
          `,
          textTrusted: true,
          modules: {
            Buttons: {
              closer: false,
              sticker: false,
            }
          }
        })
    notice.on('click', function() {
      notice.close();
    });

  @endif

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.5.3/socket.io.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<script>
    var socket = io.connect('https://server.benbros.es:8890');
    socket.on('newMessage', function (data) {
        console.log(data);
        if (
            (data.to == "" && $('[name="to_message"]').val() == "") ||
            (data.to == {{Auth::id()}} && $('[name="to_message"]').val() == data.from) || 
            (data.from == {{Auth::id()}})
           ) {
          let side = 'left';
          let now = moment().format('DD-MM-Y HH:mm')
          if (data.from == '{{ Auth::id() }}') {
            side = 'right';
          }

          let html = `<div class="answer ${side}">
                        <div class="avatar">
                          <div class="img inside" style="background-image: url(${data.avatar})"></div>
                        </div>
                        <div class="name">${data.user}</div>
                        <div class="text">
                          ${data.message}
                        </div>
                        <div class="time">${now}</div>
                      </div>`;

          $( "#messages" ).append( html );

          scrollBox();
        }

        if (data.to == "" && $('[name="to_message"]').val() != "") {
          $('#benbros-group').find('.status').show();
        }

        if (data.to == {{Auth::id()}} && $('[name="to_message"]').val() != data.from) {
          if ($('.user[data-id="'+data.from+'"]').length) {
            $('.user[data-id="'+data.from+'"]').find('.status').show();
          }else{
            console.log('se muestra la burbuja por mensaje 1a1');
            $('#bubble-chat').show();
          }

          // alert('tienes un mensaje de otro chat');
        }else{

          if (!$('[name="to_message"]').length && data.to == "") {
            console.log('se muestra la burbuja por mensaje grupal')
            $('#bubble-chat').show();
          }

          if (data.from != {{Auth::id()}}) {
            $.post('{{url('setSeen')}}', {_token: '{{csrf_token()}}', from: data.from, to: data.to }, function(data, textStatus, xhr) {
              console.log('seen out');
            });
          }
        }
    });

    function scrollBox()
    {
      let container = document.getElementById('messages');
      container.scrollTop = container.scrollHeight;
    }

    setTimeout(()=>{
      scrollBox();
    },100)

    $('#sendNewMessage').submit(function(e) {
        e.preventDefault();


        var token = '{{csrf_token()}}';
        var user = '{{Auth::user()->name}}';
        var id = '{{Auth::user()->id}}';
        var avatar = '{{Auth::user()->avatar}}';
        var msg = $(".msg").val();
        if(msg != ''){
          let data = {
            '_token':token,
            'message':msg,
            'user':user,
            'avatar': '{{url('uploads/avatars',Auth::user()->avatar)}}',
            'from': {{Auth::user()->id}},
            'to': $('[name="to_message"]').val() }
            console.log( socket.emit('sendMessage',
              data) );
            $(".msg").val('');
            $.ajax({
                type: "POST",
                url: '{!! URL::to("sendmessage") !!}',
                dataType: "json",
                data: data,
                success:function(data){
                    console.log(data);
                    $(".msg").val('');
                }
            });
        }else{
            alert("Please Add Message.");
        }
    })
</script>

</body>
</html>
