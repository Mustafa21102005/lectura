<title> Lectura | Chat</title>

{{-- Meta tags --}}
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="id" content="{{ $id }}">
<meta name="messenger-color" content="{{ $messengerColor }}">
<meta name="messenger-theme" content="{{ $dark_mode }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url" content="{{ url('') . '/' . config('chatify.routes.prefix') }}" data-user="{{ Auth::user()->id }}">

<link rel="icon" type="image/png" href="{{ asset('dashboard/assets/img/favicon/favicon-96x96.png') }}"
    sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="{{ asset('dashboard/assets/img/favicon/favicon.svg') }}" />
<link rel="shortcut icon" href="{{ asset('dashboard/assets/img/favicon/favicon.ico') }}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('dashboard/assets/img/favicon/apple-touch-icon.png') }}" />
<link rel="manifest" href="{{ asset('dashboard/assets/img/favicon/site.webmanifest') }}" />

{{-- scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script>
<script src="{{ asset('js/chatify/autosize.js') }}"></script>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>

{{-- styles --}}
<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css' />
<link href="{{ asset('css/chatify/style.css') }}" rel="stylesheet" />
<link href="{{ asset('css/chatify/' . $dark_mode . '.mode.css') }}" rel="stylesheet" />

{{-- Setting messenger primary color to css --}}
<style>
    :root {
        --primary-color: {{ $messengerColor }};
    }

    * {
        font-family: "Quicksand", sans-serif;
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Quicksand:wght@300..700&display=swap"
    rel="stylesheet">
