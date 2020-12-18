@extends('layouts.achievement')
@section('title', '実績画面')
@yield('css')
@section('content')
<div class="row my-3">
    <div class="col-1"></div>
    <div class="col-md-10">
        <div class="card">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4"
                    aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">実績ページ</a>
                <div class="collapse navbar-collapse justify-content-end">
                    <ul class="navbar-nav mt-3">
                        @foreach ($users as $user)
                        @endforeach
                        <li class="nav-item active">
                            <p>{{$user->first_name}}{{$user->last_name}}さんの実績ページ</p>
                        </li>
                        <li class="nav-item ml-3">
                            <a href="{{ url('/') }}">ログアウト</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="alert alert-danger mt-4 mx-3" role="alert">
                <div class="row">
                    <b class="mt-3 mr-auto">※今日の開始時間が登録されていません</b>
                    <a class="btn btn-primary my-2 mr-5" href="#" role="button">出席</a>
                </div>
            </div>

            <div class="card mx-3">
                <h5 class="card-header text-white bg-primary mb-3">本日の利用状況</h5>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr align="center">
                                <th>開始時間</th>
                                <th>終了時間</th>
                                <th>食事提供加算</th>
                                <th>施設外支援</th>
                                <th>医療連携体制加算</th>
                                <th>備考</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr align="center">
                                <td>　</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="card  mt-4 mx-3">
                <h5 class="card-header">実績記録表</h5>
                <div class="card-body">
                    <table class="table table-bordered">
  <thead>
    <tr>
      @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
      <th>{{ $dayOfWeek }}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach ($dates as $date)
    @if ($date->dayOfWeek == 0)
    <tr>
    @endif
      <td
        
      >
        {{ $date->day }}
      </td>
    @if ($date->dayOfWeek == 6)
    </tr>
    @endif
    @endforeach
  </tbody>
</table>
                </div>
            </div>

        </div>
    </div>
    <div class="col-1"></div>
</div>
@endsection
