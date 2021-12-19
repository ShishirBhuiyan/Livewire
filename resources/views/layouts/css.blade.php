
 <!-- Font Awesome -->
 <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">

 <!-- Ionicons -->
 <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

 <!-- Tempusdominus Bbootstrap 4 -->
 <link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

 <!-- Theme style -->
 <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">

 {{-- For Tostar Message css Local Link--}}
 <link href="{{ asset('backend/plugins/toastr/toastr.min.css') }}" rel="stylesheet"/>

 {{-- For Tostar Message css Cdn Link--}}
 <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> 
 
 {{-- Alopine Js For progress bar --}}
 <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

 <!-- iCheck -->
 <link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

 <!-- Bootstrap Color Picker -->
 <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">



 <!-- External CSS code from dynamic blade file -->
 @stack('styles')