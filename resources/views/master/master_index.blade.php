@extends('layouts.master_app')
@yield('css')
@section('title', '管理者画面')
@section('content')
<div class="row justify-content-center my-3">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">実績閲覧</div>
            <div class="card-body">
                <form method="GET" action="/master">
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

                <form method="GET" action="/master">
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
            </div>
        </div>
    </div>

    @if (isset($user))
    <div class="col-10 mt-3">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item mx-2">
                        <font size="2">支給決定障害者名</font>
                        <p class="name">{{$user->first_name}} {{$user->last_name}}</p>
                    </li>
                    <li class="nav-item mx-1 mt-2">
                        <form action="/check_records" method="get">
                            @csrf
                            <select class="past my-1" name="month">
                                <option>{{$month->isoformat('Y年M月')}}</option>
                                @foreach (array_map(null, $years, $nums) as [$year, $num])
                                <option value={{(int)$num}}>{{$year->isoformat('Y年M月')}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="user_id" value={{$user->id}}>
                            <input type="submit" class="btn btn-outline-secondary btn-sm mx-2" value="変更">
                        </form>
                    </li>
                    <li class="nav-item ml-auto">
                        <button type="button" class="btn btn-outline-secondary btn-sm mx-1 mt-2"
                            onclick="location.href='/add_achievement?user_id={{$user->id}}';">記録を作成</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <h1>{{$month->isoformat('Y年M月')}}分</h1>
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
                        @foreach (array_map(null, $days, $records) as [$day, $record])
                        <tr align="center">
                            @if ($day == $record)
                            <td>{{$day->isoformat('D')}}</td>
                            <td>{{$day->isoformat('ddd')}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @else
                            <td>{{$day->isoformat('D')}}</td>
                            <td>{{$day->isoformat('ddd')}}</td>
                            <td>{{substr($record->start_time,0, 5)}}</td>
                            <td>{{substr($record->end_time,0, 5)}}</td>
                            @if ($record->food == 0)
                            <td>無</td>
                            @elseif ($record->food == 1)
                            <td>
                                <font color="red">有</font>
                            </td>
                            @endif

                            @if ($record->outside_support == 0)
                            <td>無</td>
                            @elseif ($record->outside_support == 2)
                            <td>
                                <font color="red">有</font>
                            </td>
                            @endif

                            @if ($record->medical__support == 0)
                            <td>無</td>
                            @elseif ($record->medical__support == 2)
                            <td>
                                <font color="red">有</font>
                            </td>
                            @endif

                            @if ($record->note)
                            <td>{{$record->note}}</td>
                            @else
                            <td></td>
                            @endif
                            <td>
                            <button type="button" class="btn btn-secondary btn-sm"
                            onclick="location.href='/edit_achievement?id={{$record->id}}';">編集</button>
                            </td>
                            <td></td>

                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
