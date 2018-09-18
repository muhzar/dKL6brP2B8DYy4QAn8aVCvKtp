<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>@yield('title')</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="{{ asset('backend/bootstrap/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/css/font-awesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/css/ionicons.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/dist/css/AdminLTE.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/dist/css/skins/_all-skins.min.css') }}">
	    <link rel="stylesheet" href="{{ asset('backend/css/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">


		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		@yield('head')
		<style>
			#dialog-confirm {
				display: none;
			}


	        .bar {
	            height: 18px;
	            background: green;
	            width: 0px;
	        }
	        label.img-upload-label {
	            border: solid #cecece 1px;
	            padding: 5px;
	        }
	        label.img-upload-label input[type="file"] {
	            position: fixed;
	            top: -1000px;
	        }
		</style>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<!-- Site wrapper -->
		<div class="wrapper">
			@include('backend.templates.includes.header')
			@include('backend.templates.includes.sidebar')
			<div class="content-wrapper">
				<section class="content-header">
					<h1>{{ getCurrentController() }} </h1>
					<ol class="breadcrumb">
						<li><a href="{{ url('cms/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="{{ url('cms/' . strtolower(getCurrentController())) }}">{{ getCurrentController() }}</a></li>
						<li class="active">{{ getCurrentMethod() }}</li>
					</ol>
				</section>
				<section class="content">
					@yield('content')
				</section>
			</div>
			@include('backend.templates.includes.footer')

		  	<!-- Control Sidebar -->
		  	<aside class="control-sidebar control-sidebar-dark">
		    <!-- Create the tabs -->
		    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
		      	<!--li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
		      	<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li-->
		    </ul>
		    <!-- Tab panes -->
		    <div class="tab-content">
		      <!-- Home tab content -->
		      	<div class="tab-pane" id="control-sidebar-home-tab">
			        
		        
		        <!-- /.control-sidebar-menu -->

		      </div>
		      <!-- /.tab-pane -->
		      <!-- Stats tab content -->
		      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
		      <div class="tab-pane" id="control-sidebar-settings-tab">Stats Tab Content</div>
		      <!-- /.tab-pane -->
		    </div>
		  </aside>
		  <!-- /.control-sidebar -->
		  <!-- Add the sidebar's background. This div must be placed
		       immediately after the control sidebar -->
		  <div class="control-sidebar-bg"></div>
		</div>
		<!-- ./wrapper -->

		<!-- jQuery 2.2.3 -->
		<script src="{{ asset('backend/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
		<!-- Bootstrap 3.3.6 -->
		<script src="{{ asset('backend/bootstrap/js/bootstrap.min.js') }}"></script>
		<!-- SlimScroll -->
		<script src="{{ asset('backend/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
		<!-- FastClick -->
		<script src="{{ asset('backend/plugins/fastclick/fastclick.js') }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('backend/dist/js/app.min.js') }}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{ asset('backend/dist/js/demo.js') }}"></script>
		<script src="{{ asset('backend/dist/js/datepicker.js') }}"></script>
	    <script src="{{ asset('backend/js/jquery-ui.min.js') }}"></script>
	    <script src="{{ asset('backend/dist/js/jquery.ui.widget.js') }}"></script>
	    <script src="{{ asset('backend/dist/js/jquery.iframe-transport.js') }}"></script>
	    <script src="{{ asset('backend/dist/js/jquery.fileupload.js') }}"></script>


		<script>
			$('#InputFileImage').fileupload({
	            url: '{{ url('cms/uploads/images')}}',
	            type: 'POST',
	            dataType: 'json',
	            done: function (e, data) {
	                $.each(data.result.files, function (index, file) {
	                    temp = '<img src="{{ asset(config('app.folder_upload_images')) }}/' + file.url + '" class="img-responsive">';
	                    $(".img-temp").html(temp);
	                    $('.old-img').remove();
	                    $('.inputImage').val(file.url);
	                    $('.inputImageView').val(temp);                    
	                });
	            },
	            progressall: function (e, data) {
	                var progress = parseInt(data.loaded / data.total * 100, 10);
	                $('#progress .bar').css(
	                    'width',
	                    progress + '%'
	                );
	            }
	        });
		</script>
		@yield('js')
	</body>
</html>
