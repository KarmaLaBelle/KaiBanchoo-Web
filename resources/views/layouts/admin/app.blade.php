<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    {!! Html::style("bootstrap/css/bootstrap.min.css") !!}
            <!-- Font Awesome -->
    {!! Html::style("https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css") !!}
            <!-- Ionicons -->
    {!! Html::style("https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css") !!}
            <!-- Theme style -->
    {!! Html::style("dist/css/AdminLTE.min.css") !!}
            <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    {!! Html::style("dist/css/skins/_all-skins.min.css") !!}
            <!-- iCheck -->
    {!! Html::style("plugins/iCheck/flat/blue.css") !!}
            <!-- Morris chart -->
    {!! Html::style("plugins/morris/morris.css") !!}
            <!-- jvectormap -->
    {!! Html::style("plugins/jvectormap/jquery-jvectormap-1.2.2.css") !!}
            <!-- Date Picker -->
    {!! Html::style("plugins/datepicker/datepicker3.css") !!}
            <!-- Daterange picker -->
    {!! Html::style("plugins/daterangepicker/daterangepicker-bs3.css") !!}
            <!-- bootstrap wysihtml5 - text editor -->
    {!! Html::style("plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") !!}

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    {!! Html::script("https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js") !!}
    {!! Html::script("https://oss.maxcdn.com/respond/1.4.2/respond.min.js") !!}
    <![endif]-->
</head>
<body class="hold-transition skin-purple-light layout-top-nav">
<div class="wrapper">
    <!-- Nav Content -->
    @include('layouts.admin.nav')
            <!-- Sidebar Content -->
    @include('layouts.admin.leftsidebar')
            <!-- Main Content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>
        @yield('content')
    </div>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.3.2
    </div>
    <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
    reserved.
</footer>
<!-- ./wrapper -->
@include('layouts.admin.rightsidebar')
        <!-- jQuery 2.2.0 -->
{!! Html::script("plugins/jQuery/jQuery-2.2.0.min.js") !!}
        <!-- jQuery UI 1.11.4 -->
{!! Html::script("https://code.jquery.com/ui/1.11.4/jquery-ui.min.js") !!}
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
{!! Html::script("bootstrap/js/bootstrap.min.js") !!}
        <!-- Morris.js charts -->
{!! Html::script("https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js") !!}
{!! Html::script("plugins/morris/morris.min.js") !!}
        <!-- Sparkline -->
{!! Html::script("plugins/sparkline/jquery.sparkline.min.js") !!}
        <!-- jvectormap -->
{!! Html::script("plugins/jvectormap/jquery-jvectormap-1.2.2.min.js") !!}
{!! Html::script("plugins/jvectormap/jquery-jvectormap-world-mill-en.js") !!}
        <!-- jQuery Knob Chart -->
{!! Html::script("plugins/knob/jquery.knob.js") !!}
        <!-- daterangepicker -->
{!! Html::script("https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js") !!}
{!! Html::script("plugins/daterangepicker/daterangepicker.js") !!}
        <!-- datepicker -->
{!! Html::script("plugins/datepicker/bootstrap-datepicker.js") !!}
        <!-- Bootstrap WYSIHTML5 -->
{!! Html::script("plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js") !!}
        <!-- Slimscroll -->
{!! Html::script("plugins/slimScroll/jquery.slimscroll.min.js") !!}
        <!-- FastClick -->
{!! Html::script("plugins/fastclick/fastclick.js") !!}
        <!-- AdminLTE App -->
{!! Html::script("dist/js/app.min.js") !!}
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{!! Html::script("dist/js/pages/dashboard.js") !!}
        <!-- AdminLTE for demo purposes -->
{!! Html::script("dist/js/demo.js") !!}
</body>
</html>
