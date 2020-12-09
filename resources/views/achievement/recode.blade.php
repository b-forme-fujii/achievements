@extends('layouts.achievement')
@section('title', '実績画面')
@yield('css')
@section('content')
<div class="row my-3">
    <div class="col-3">
        <h1>実績記録</h1>
    </div>
    <div class="alert alert-danger" role="alert">
        A simple danger alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
      </div>
    <h2>当月の利用実績</h2>
    <table class="table table-boder">
        <tr>
            <th>日付</th>
            <th>曜日</th>
            <th>サービス提供状況</th>
            <th>開始時間</th>
            <th>終了時間</th>
            <th>食事提供加算</th>
            <th>施設外支援</th>
            <th>医療連携体制加算</th>
            <th>備考</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$user->start_time}}</td>
            <td>{{$user->end_time}}</td>
            @if ($user->food == 0)
                <td>無</td>
            @elseif ($user->food == 1)
                <td>有</td>
            @endif
    
            @if ($user->outside_support == 0)
                <td>無</td>
            @elseif ($user->outside_support == 2)
                <td>有</td>
            @endif
    
            @if ($user->medical__support == 0)
                <td>無</td>
            @elseif ($user->medical__support == 2)
                <td>有</td>
            @endif
    
            @if ($user->note)
                <td>{{$user->note}}</td>
            @else
                <td></td>
            @endif
        </tr>
        @endforeach
    
    </table>
</div>
@endsection
