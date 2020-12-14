<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
    <style>
        .button {
            display: inline-block;
            border-radius: 5%;
            /* 角丸       */
            font-size: 10pt;
            /* 文字サイズ */
            text-align: center;
            /* 文字位置   */
            cursor: pointer;
            /* カーソル   */
            margin: 5px 0px;
            padding: 12px 65px;
            /* 余白       */
            background: #1a1aff;
            /* 背景色     */
            color: #ffffff;
            /* 文字色     */
            line-height: 1em;
            /* 1行の高さ  */
            opacity: 0.9;
            /* 透明度     */
            transition: .3s;
            /* なめらか変化 */
        }

        .button:hover {
            opacity: 1;
            /* カーソル時透明度 */
        }


    </style>
    

</head>

<body>
    <div class="container-sm">

        @section('content')
        <div class='menutitle'>@yield('menutitle')</div>
        <div class="content">@yield('content')</div>
    </div>
</body>

</html>
