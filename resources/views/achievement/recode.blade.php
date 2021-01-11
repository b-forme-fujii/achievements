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
                        <li class="nav-item active">
                            <p>{{$user->first_name}}{{$user->last_name}}さんの実績ページ</p>
                        </li>
                        <li class="nav-item ml-3">
                            <a href="{{ url('/') }}">ログアウト</a>
                        </li>
                    </ul>
                </div>
            </nav>

            @if ($one_recode == null)
            <div class="alert alert-danger mt-4 mx-3" role="alert">
                <div class="row">
                    <b class="mt-3 mr-auto">※今日の開始時間が登録されていません</b>
                    <form action="/insert_date" method="get">
                        @csrf
                        <input type="hidden" name="id" value={{$user->id}}>
                        <input type="submit" class="btn btn-primary my-2 mr-5" value="出席">
                    </form>
                </div>
            </div>
            @else
            <div class="card mt-4 mx-3">
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
                                <td>{{$one_recode->start_time}}</td>
                                @if ($one_recode->end_time == null)                           
                                <td>aaa</td>
                                @else
                                <td>{{$one_recode->end_time}}</td>
                                @endif
                                @if ($one_recode->food == 0)
                                <td>無</td>
                                @elseif ($one_recode->food == 1)
                                <td>有</td>
                                @endif
                                @if ($one_recode->outside_support == 0)
                                <td>無</td>
                                @elseif ($one_recode->outside_support == 2)
                                <td>有</td>
                                @endif
                                @if ($one_recode->medical__support == 0)
                                <td>無</td>
                                @elseif ($one_recode->medical__support == 2)
                                <td>有</td>
                                @endif
                                @if ($one_recode->note)
                                <td>{{$one_recode->note}}</td>
                                @else
                                <td></td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
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
                            @foreach (array_map(null, $days, $weeks, $recodes, $fdays) as [$day, $week, $recode, $fday])
                            <tr align="center">
                                @if ($day == $recode)
                                <td>{{$fday}}</td>
                                <td>{{$week}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                @else
                                <td>{{$fday}}</td>
                                <td>{{$week}}</td>
                                <td>有</td>
                                <td>{{$recode->start_time}}</td>
                                <td>{{$recode->end_time}}</td>
                                @if ($recode->food == 0)
                                <td>無</td>
                                @elseif ($recode->food == 1)
                                <td>有</td>
                                @endif

                                @if ($recode->outside_support == 0)
                                <td>無</td>
                                @elseif ($recode->outside_support == 2)
                                <td>有</td>
                                @endif

                                @if ($recode->medical__support == 0)
                                <td>無</td>
                                @elseif ($recode->medical__support == 2)
                                <td>有</td>
                                @endif

                                @if ($recode->note)
                                <td>{{$recode->note}}</td>
                                @else
                                <td>無</td>
                                @endif

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
@endsection
