<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta17
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="{{ asset('tabler-template/dist/css/tabler.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('tabler-template/dist/css/tabler-flags.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('tabler-template/dist/css/tabler-payments.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('tabler-template/dist/css/tabler-vendors.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('tabler-template/dist/css/demo.min.css?1674944402') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>
    <script src="{{ asset('tabler-template/dist/js/demo-theme.min.js?1674944402') }}"></script>
    <div class="page">
        <!-- Sidebar -->
        @include('layout.admin.sidebar')
        <!-- Navbar -->
        @include('layout.admin.header')

        <div class="page-wrapper">
            <!-- Content -->
            @yield('content')
            <!-- Footer -->
            @include('layout.admin.footer')

        </div>
    </div>

    <!-- Libs JS -->
    <script src="{{ asset('tabler-template/dist/libs/apexcharts/dist/apexcharts.min.js?1674944402') }}" defer></script>
    <script src="{{ asset('tabler-template/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1674944402') }}" defer></script>
    <script src="{{ asset('tabler-template/dist/libs/jsvectormap/dist/maps/world.js?1674944402') }}" defer></script>
    <script src="{{ asset('tabler-template/dist/libs/jsvectormap/dist/maps/world-merc.js?1674944402') }}" defer></script>
    <!-- Tabler Core -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="{{ asset('tabler-template/dist/js/tabler.min.js?1674944402') }}" defer></script>
    <script src="{{ asset('tabler-template/dist/js/demo.min.js?1674944402') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    @stack('myscript')
</body>

</html>
