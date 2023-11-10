<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div id="flash">
    @include('partials.flash')
    <!-- Misatges -->
    @if ($message = Session::get('success'))
    @include('partials.flash-message', ['type' => "success", 'message' => $message])
    @endif
    @if ($message = Session::get('error'))
    @include('partials.flash-message', ['type' => "danger", 'message' => $message])
    @endif
    @if ($message = Session::get('warning'))
    @include('partials.flash-message', ['type' => "warning", 'message' => $message])
    @endif
    @if ($message = Session::get('info'))
    @include('partials.flash-message', ['type' => "info", 'message' => $message])
    @endif
    @if ($errors->any())
    @foreach ($errors->all() as $error)
        @include('partials.flash-message', ['type' => "danger", 'message' => $error])
    @endforeach
    @endif
    </div>
    
    
</body>
</html>

