<!DOCTYPE html>
<html lang="en">
@include('admin.partials.head')

<body class="nav-fixed">
    @include('admin.partials.top_navbar')
    <div id="layoutSidenav">
        @include('admin.partials.sidebar')
        <div id="layoutSidenav_content">
            <main>
                @include('admin.partials.header')
                <div class="container-xl px-4 mt-4">
                    @yield('content')
                </div>
            </main>
            @include('admin.partials.footer')
        </div>
    </div>
    @include('admin.partials.scripts')
</body>

</html>
