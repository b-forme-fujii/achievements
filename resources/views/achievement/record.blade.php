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
                <a class="navbar-brand" href="#">出欠確認</a>
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

            @if (is_null($one_recode))
            <div class="alert alert-danger mt-4 mx-3" role="alert">
                <div class="row">
                    <b class="mt-3 mr-auto">※今日の開始時間が登録されていません</b>
                    <a href="/new_record?user_id={{$user->id}}" class="btn btn-outline-primary my-2 mr-5">出席</a>

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
                                <td>
                                    <div class="start mt-2">{{substr($one_recode->start_time,0, 5)}}</div>
                                </td>
                                @if (is_null($one_recode->end_time))
                                <td>
                                    <div class="end mt-1"><a href="/end_time?user_id={{$user->id}}"
                                            class="btn btn-outline-danger">退勤</a></div>
                                </td>
                                @else
                                <td>
                                    <div class="end mt-2">{{substr($one_recode->end_time,0, 5)}}</div>
                                </td>
                                @endif
                                @if ($one_recode->food == 0)
                                <td>
                                    <form action="/food_up" method="get">
                                        @csrf
                                        <span style="margin-right: 1em;"><input type="radio" name="food" value=0
                                                checked="checked">無</span>
                                        <input type="radio" name="food" value=1>有
                                        <div class="food_up mt-3">
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                                        </div>
                                    </form>
                                </td>
                                @elseif ($one_recode->food == 1)
                                <td>
                                    <form action="/food_up" method="get">
                                        @csrf
                                        <span style="margin-right: 1em;"><input type="radio" name="food"
                                                value=0>無</span>
                                        <input type="radio" name="food" value=1 checked="checked">有
                                        <div class="food_up mt-3">
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                                        </div>
                                    </form>
                                </td>
                                @endif

                                @if ($one_recode->outside_support == 0)
                                <td>
                                    <form action="/outside_up" method="get">
                                        @csrf
                                        <span style="margin-right: 1em;"><input type="radio" name="outside" value=0
                                                checked="checked">無</span>
                                        <input type="radio" name="outside" value=2>有
                                        <div class="outside_up mt-3">
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                                        </div>
                                    </form>
                                </td>
                                @elseif ($one_recode->outside_support == 2)
                                <td>
                                    <form action="/outside_up" method="get">
                                        @csrf
                                        <span style="margin-right: 1em;"><input type="radio" name="outside"
                                                value=0>無</span>
                                        <input type="radio" name="outside" value=2 checked="checked">有
                                        <div class="outside_up mt-3">
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                                        </div>
                                    </form>
                                </td>
                                @endif
                                @if ($one_recode->medical__support == 0)
                                <td>
                                    <form action="/medical_up" method="get">
                                        @csrf
                                        <span style="margin-right: 1em;"><input type="radio" name="medical" value=0
                                                checked="checked">無</span>
                                        <input type="radio" name="medical" value=2>有
                                        <div class="medical_up mt-3">
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                                        </div>
                                    </form>
                                </td>
                                @elseif ($one_recode->medical__support == 2)
                                <td>
                                    <form action="/medical_up" method="get">
                                        @csrf
                                        <span style="margin-right: 1em;"><input type="radio" name="medical"
                                                value=0>無</span>
                                        <input type="radio" name="medical" value=2 checked="checked">有
                                        <div class="medical_up mt-3">
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                                        </div>
                                    </form>
                                </td>
                                @endif
                                @if ($one_recode->note == null)
                                <td>
                                    <form action="/note_up" method="get">
                                        @csrf
                                        <select class="note my-1" name="note">
                                            <option value=""></option>
                                            <option value="通所">通所　</option>
                                            <option value="Skype">Skype　</option>
                                            <option value="メール">メール　</option>
                                            <option value="訪問">訪問　</option>
                                        </select>
                                        <div class="note_up my-1">
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                                        </div>
                                    </form>
                                </td>

                                @elseif($one_recode->note == "通所")
                                <td>
                                    <form action="/note_up" method="get">
                                        @csrf
                                        <select class="note my-1" name="note">
                                            <option value={{$one_recode->note}}>{{$one_recode->note}}　</option>
                                            <option value="Skype">Skype　</option>
                                            <option value="メール">メール　</option>
                                            <option value="訪問">訪問　</option>
                                        </select>
                                        <div class="note_up my-1">
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                                        </div>
                                    </form>
                                </td>

                                @elseif($one_recode->note == "Skype")
                                <td>
                                    <form action="/note_up" method="get">
                                        @csrf
                                        <select class="note my-1" name="note">
                                            <option value={{$one_recode->note}}>{{$one_recode->note}}　</option>
                                            <option value="通所">通所　</option>
                                            <option value="メール">メール　</option>
                                            <option value="訪問">訪問　</option>
                                        </select>
                                        <div class="note_up my-1">
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                                        </div>
                                    </form>
                                </td>

                                @elseif($one_recode->note == "メール")
                                <td>
                                    <form action="/note_up" method="get">
                                        @csrf
                                        <select class="note my-1" name="note">
                                            <option value={{$one_recode->note}}>{{$one_recode->note}}　</option>
                                            <option value="通所">通所　</option>
                                            <option value="Skype">Skype　</option>
                                            <option value="訪問">訪問　</option>
                                        </select>
                                        <div class="note_up my-1">
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                                        </div>
                                    </form>
                                </td>

                                @elseif($one_recode->note == "訪問")
                                <td>
                                    <form action="/note_up" method="get">
                                        @csrf
                                        <select class="note my-1" name="note">
                                            <option value={{$one_recode->note}}>{{$one_recode->note}}　</option>
                                            <option value="通所">通所　</option>
                                            <option value="Skype">Skype　</option>
                                            <option value="メール">メール　</option>
                                        </select>
                                        <div class="note_up my-1">
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                                        </div>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <div class="card  mt-4 mx-3">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item mx-2">
                            <font size="2">支給決定障害者名</font>
                            <p class="name">{{$user->first_name}} {{$user->last_name}}</p>
                        </li>
                        <li class="nav-item mx-1 mt-2">
                            <form action="/achievement" method="get">
                                @csrf
                                    <select class="past my-1" name="month">
                                        @foreach (array_map(null, $pmonths, $nums) as [$pmonth, $num])
                                        <option value={{(int)$num}}>{{$pmonth}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="user_id" value={{$user->id}}>
                                    <input type="submit" class="btn btn-outline-secondary btn-sm" value="変更">
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <h1>{{$year}}年{{$month}}月分</h1>
                    <table class="table table-bordered">
                        <thead>
                            <tr align="center">
                                <th>日付</th>
                                <th>曜日</th>
                                <th>開始時間</th>
                                <th>終了時間</th>
                                <th>食事提供加算</th>
                                <th>施設外支援</th>
                                <th>医療連携体制加算</th>
                                <th>備考</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (array_map(null, $days, $weeks, $recodes, ) as [$day, $week, $recode, ])
                            <tr align="center">
                                @if ($day == $recode)
                                <td>{{substr($day,8,9)}}</td>
                                <td>{{$week}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                @else
                                <td>{{substr($recode->insert_date,8,9)}}</td>
                                <td>{{$week}}</td>
                                <td>{{substr($recode->start_time,0, 5)}}</td>
                                <td>{{substr($recode->end_time,0, 5)}}</td>
                                @if ($recode->food == 0)
                                <td>無</td>
                                @elseif ($recode->food == 1)
                                <td><font color="red">有</font></td>
                                @endif

                                @if ($recode->outside_support == 0)
                                <td>無</td>
                                @elseif ($recode->outside_support == 2)
                                <td><font color="red">有</font></td>
                                @endif

                                @if ($recode->medical__support == 0)
                                <td>無</td>
                                @elseif ($recode->medical__support == 2)
                                <td><font color="red">有</font></td>
                                @endif

                                @if ($recode->note)
                                <td>{{$recode->note}}</td>
                                @else
                                <td></td>
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
