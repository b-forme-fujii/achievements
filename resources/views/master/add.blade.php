@extends('layouts.achievement')
@section('title', '利用者登録画面')
@yield('css')
@section('content')
<div class="row justify-content-center my-3">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-primary">
                <div class="row">
                    <p class="text-light mt-3 ml-2">利用者登録ページ</p>
                    <ul class="master list-unstyled ml-auto">
                        <li class="nav-item mt-3">
                            <a href="/new_user" class="nav-item text-light mx-2">新規利用者登録</a>
                            <a class="nav-item text-light mx-2" href="{{ route('logout') }}" onclick="event.preventDefault();
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
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-body">
                        <form method="POST" action="/create_user">
                            @csrf
    
                            <div class="form-group row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">利用者の名字</label>
    
                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" 
                                    value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>  
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">利用者の名前</label>
    
                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" 
                                    value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>  
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="full_name" class="col-md-4 col-form-label text-md-right">
                                    利用者のフルネーム<br>(カタカナ)
                                    </label>
    
                                <div class="col-md-6 mt-1">
                                    <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" 
                                    value="{{ old('full_name') }}" required autocomplete="full_name" autofocus>  
                                    @error('full_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="age" class="col-md-4 col-form-label text-md-right">年齢</label>
    
                                <div class="col-md-6 mt-1">
                                    <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" 
                                    value="{{ old('age') }}" required autocomplete="age" autofocus>  
                                    @error('age')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="school_id" class="col-md-4 col-form-label text-md-right">所属校</label>
    
                                <div class="col-md-6 mt-1">
                                    <span style="margin-right: 1em;"><input type="radio" name="school_id" value=1
                                        checked="checked">本校</span>
                                <input type="radio" name="school_id" value=2>２校
                                    @error('school_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">登録</button>
                                    <button type="button" class="btn btn-outline-primary" onclick="location.href='/master';">キャンセル</button>
                                </div>
                            </div>
                        </form>
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
