<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Admin | Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	
	<!-- ================== BEGIN core-css ================== -->
	<link href="{{url('assets/css/app.min.css')}}" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
	<link rel="icon" href="{{url('assets/img/logo.png')}}" type="image/png">
    <link rel="shortcut icon" href="{{url('assets/img/logo.png')}}" type="image/png"> 
</head>
<body>
	<!-- BEGIN #app -->
	<div id="app" class="app">
		
		@include('admin.layout.header')

		@include('admin.layout.sidebar')
		<!-- BEGIN #content -->
			<div id="content" class="app-content">

                 @yield('content')
             </div>
		<!-- END #content -->
		
		<!-- BEGIN btn-scroll-top -->
		<a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
		<!-- END btn-scroll-top -->
	</div>
	<!-- END #app -->
	
	<!-- ================== BEGIN core-js ================== -->
	<script src="{{url('assets/js/app.min.js')}}"></script>
	<!-- ================== END core-js ================== -->

<script type="text/javascript">  
    var url = "{{ route('changeLang') }}";
  
    $(".changeLang").change(function(){
        window.location.href = url + "?lang="+ $(this).val();
    });
</script>
</body>
</html>