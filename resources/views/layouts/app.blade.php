<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Meta Title')</title>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="{{ asset('css/icon/bootstrapicons-iconpicker.min.css') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link href="{{ asset('css/select2/select2.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('js/select2/select2.min.js')}}"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php //print_r($breadcrumbService); ?>
        @include('partials.loader') 
        @include('partials.message') 
        @include('partials.header') 
        <div id="layoutSidenav">
            @include('partials.sidenav') 
            <div id="layoutSidenav_content">
                <main> 
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">@yield('title', 'Breadcrumb Title')</h1>
                        <nav aria-label="breadcrumb">
                          <ol class="breadcrumb">
                            @foreach($breadcrumbService as $item)
                                @if($loop->last)
                                    <li class="breadcrumb-item active" aria-current="page">{{$item['title']}}</li>
                                @else
                                    <li class="breadcrumb-item"><a href="{{$item['url']}}">{{$item['title']}}</a></li>
                                @endif
                            @endforeach
                          </ol>
                        </nav>
                        <main>
                            @yield('content') <!-- Dynamic content will be injected here -->
                        </main>
                    </div>
                </main>
                @include('partials.footer')
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/icon/bootstrapicon-iconpicker.min.js') }}"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
    </body>
</html>
