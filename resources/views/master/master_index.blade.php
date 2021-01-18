@extends('layouts.achievement')
@section('title', '管理者画面')
@yield('css')
@section('content')
<div class="row justify-content-center my-3">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <p class="title mt-2">管理者ページ</p>
                    <ul class="master list-unstyled ml-auto">
                        <li class="nav-item mt-2">
                            <a href="#" class="nav-item mx-2">新規利用者登録</a>
                            <a class="nav-item mx-2" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="">
                    @csrf
                    <div class="form-group row">
                        <label for="school-1" class="col-md-4 col-form-label text-md-center">本校の利用者</label>

                        <div class="col-md-6">
                            <select class="form-control" name="id">
                                @foreach ($school_1 as $item1)
                                <option value={{$item1->id}}>{{$item1->first_name}}　{{$item1->last_name}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="month" value=0>
                            <input type="submit" value="一覧表示" class="button">
                        </div>
                    </div>
                </form>


                <form method="GET" action="">
                    @csrf
                    <div class="form-group row">
                        <label for="school-2" class="col-md-4 col-form-label text-md-center">２校の利用者</label>
                        <div class="col-md-6">
                            <select class="form-control" name="id">
                                @foreach ($school_2 as $item2)
                                <option value={{$item2->id}}>{{$item2->first_name}}　{{$item2->last_name}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="month" value=0>
                            <input id="id" type="submit" value="一覧表示" class="button">
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
@endsection
