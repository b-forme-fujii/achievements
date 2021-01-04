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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="card  mt-4 mx-3">
                        <h5 class="card-header">実績記録表</h5>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr align="center">
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
                                </thead>
                                <tbody>
                                    @foreach (array_map(null, $days, $weeks) as [$day, $week])
                                    @foreach ($users as $user)
                                    @if ($day != $user->insert_date)
                                    <tr align="center">
                                        <td>{{$day}}</td>
                                        <td>{{$week}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @endif
                                     @if ($day == $user->insert_date)
                                        <tr align="center">
                                            <td>{{$day}}</td>
                                            <td>{{$week}}</td>
                                        <td scope="row">出</td>
                                        <td>{{$user->start_time}}</td>
                                        <td>{{$user->end_time}}</td>
                                        @if ($user->food == 0)
                                        <td>無</td>
                                        @elseif ($user->food == 1)
                                        <td scope=>有</td>
                                        @endif
                                        @if ($user->outside_support == 0)
                                        <td scope="row">無</td>
                                        @elseif ($user->outside_support == 2)
                                        <td scope="row">有</td>
                                        @endif
            
                                        @if ($user->medical__support == 0)
                                        <td scope="row">無</td>
                                        @elseif ($user->medical__support == 2)
                                        <td scope="row">有</td>
                                        @endif
            
                                        @if ($user->note)
                                        <td scope="row">{{$user->note}}</td>
                                        @else
                                        <td scope="row"></td> 
                                        @endif

                                        
                                    </tr>
                                    @endif

                                    @endforeach
                                   
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="card  mt-4 mx-3">
                        <h5 class="card-header">実績記録表</h5>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr align="center">
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
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr align="center">
                                        <td scope="row">
                                            {{ $user->insert_date}}
                                        </td>
                                        <td scope="row"></td>
                                        @if ($user->insert_date == null)
                                        <td scope="row">欠</td>
                                        @else
                                        <td scope="row">出</td>
                                        @endif

                                        <td scope="row">{{$user->start_time}}</td>
                                        <td scope="row">{{$user->end_time}}</td>
                                        @if ($user->food == 0)
                                        <td scope="row">無</td>
                                        @elseif ($user->food == 1)
                                        <td scope="row">有</td>
                                        @endif

                                        @if ($user->outside_support == 0)
                                        <td scope="row">無</td>
                                        @elseif ($user->outside_support == 2)
                                        <td scope="row">有</td>
                                        @endif

                                        @if ($user->medical__support == 0)
                                        <td scope="row">無</td>
                                        @elseif ($user->medical__support == 2)
                                        <td scope="row">有</td>
                                        @endif

                                        @if ($user->note)
                                        <td scope="row">{{$user->note}}</td>
                                        @else
                                        <td scope="row">無</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="col-1"></div>
</div>
@endsection
