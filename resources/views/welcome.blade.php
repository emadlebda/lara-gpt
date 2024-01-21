<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full grid place-items-center p-6">
<div class="text-xs font-sans">

    @if(isset($error))
        <div role="alert">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Error
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                <p>{{$error}}</p>
            </div>
        </div>
    @endif


    @if(isset($poem))
        {!! nl2br($poem) !!}
    @endif
</div>
</body>
</html>
