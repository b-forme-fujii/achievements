@extends('layouts.master_app')
@yield('css')
@section('title', '管理者画面')
@section('content')
<div class="row justify-content-center my-3">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-primary">
                <div class="row">
                    <p class="text-light mt-2 ml-2">実績閲覧</p>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="/check_recodes">
                    @csrf
                    <div class="form-group row">
                        <label for="school-1" class="col-md-4 col-form-label text-md-center">本校の利用者</label>
                        <div class="col-md-6">
                            <select class="form-control" name="user_id">
                                @foreach ($school_1 as $sch1)
                                <option value={{$sch1->id}}>{{$sch1->first_name}}　{{$sch1->last_name}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="month" value=0>
                            <input type="submit" value="一覧表示" class="button">
                        </div>
                    </div>
                </form>

                <form method="GET" action="/check_recodes">
                    @csrf
                    <div class="form-group row">
                        <label for="school-2" class="col-md-4 col-form-label text-md-center">２校の利用者</label>
                        <div class="col-md-6">
                            <select class="form-control" name="user_id">
                                @foreach ($school_2 as $sch2)
                                <option value={{$sch2->id}}>{{$sch2->first_name}}　{{$sch2->last_name}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="month" value=0>
                            <input type="submit" value="一覧表示" class="button">
                        </div>
                    </div>
                </form>

                @if (isset($user))
                <div class="card  mt-4 mx-3">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item mx-2">
                                <font size="2">支給決定障害者名</font>
                                <p class="name">{{$user->first_name}} {{$user->last_name}}</p>
                            </li>
                            <li class="nav-item mx-1 mt-2">
                                <form action="/check_recodes" method="get">
                                    @csrf
                                    <select class="past my-1" name="month">
                                        @foreach (array_map(null, $pmonths, $nums) as [$pmonth, $num])
                                        <option value={{(int)$num}}>{{$pmonth}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="user_id" value={{$user->id}}>
                                    <input type="submit" class="btn btn-outline-primary btn-sm mx-2" value="変更">
                                </form>
                            </li>
                            <li class="nav-item ml-auto">
                                <button type="button" class="btn btn-outline-secondary btn-sm mx-1 mt-2" onclick="location.href='/master';">記録を作成</button>
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
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (array_map(null, $days, $weeks, $recodes) as [$day, $week, $recode])
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
                                    <td>
                                        <font color="red">有</font>
                                    </td>
                                    @endif

                                    @if ($recode->outside_support == 0)
                                    <td>無</td>
                                    @elseif ($recode->outside_support == 2)
                                    <td>
                                        <font color="red">有</font>
                                    </td>
                                    @endif

                                    @if ($recode->medical__support == 0)
                                    <td>無</td>
                                    @elseif ($recode->medical__support == 2)
                                    <td>
                                        <font color="red">有</font>
                                    </td>
                                    @endif

                                    @if ($recode->note)
                                    <td>{{$recode->note}}</td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td>
                                        <form action="" method="get">
                                            @csrf
                                            <input type="hidden" name="id" value={{$recode->id}}>
                                            <input type="hidden" name="user_id" value={{$user->id}}>
                                            <input type="submit" class="btn btn-outline-secondary btn-sm" value="編集">
                                        </form>
                                    </td>
                                    <td></td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
