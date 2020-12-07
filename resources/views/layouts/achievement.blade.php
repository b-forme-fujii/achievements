<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
    <style>
        .button {
            display       : inline-block;
            border-radius : 5%;          /* 角丸       */
            font-size     : 10pt;        /* 文字サイズ */
            text-align    : center;      /* 文字位置   */
            cursor        : pointer;     /* カーソル   */
            margin        : 5px 0px;
            padding       : 12px 65px;   /* 余白       */
            background    : #1a1aff;     /* 背景色     */
            color         : #ffffff;     /* 文字色     */
            line-height   : 1em;         /* 1行の高さ  */
            opacity       : 0.9;         /* 透明度     */
            transition    : .3s;         /* なめらか変化 */
          }
          .button:hover {
            opacity       : 1;           /* カーソル時透明度 */
          }
  </style>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>
<body>
    <div class="container-sm">

@section('content')
    <div class='menutitle'>@yield('menutitle')</div>
    <div class="content">@yield('content')</div>
    </div>
</body>
</html>
