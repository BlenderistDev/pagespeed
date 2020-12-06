<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;600&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
    </script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
    <div id="app">
        <admin></admin>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script> 

    <script>
        window.App = {!! json_encode([
            'apiToken' => Auth::user()->api_token  ?? null,
        ]) !!};
    </script>
</body>
</html>