<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIBALA-TI</title>


    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ 'css/bootstrap.min.css' }}">
    <link rel="stylesheet" href="{{ 'vendor/fontawesome-free/css/all.css' }}">

    <!-- style css -->
    <link rel="stylesheet" href="{{ 'css/styles.css' }}">


</head>

<body>
    <!-- Header -->
    @include('layouts.navbar')

    @yield('main')

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Javascript -->
    <script src="{{ 'js/bootstrap.bundle.min.js' }}"></script>
</body>

</html>
