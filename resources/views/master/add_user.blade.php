@extends('layouts.master_app')
@section('title', '利用者登録画面')
@yield('css')
@section('content')
<div class="row justify-content-center my-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <p class="mt-3 ml-2">新規利用者登録</p>

                </div>
            </div>
            <div class="row justify-content-center">
                <div class="card-body">
                    <form method="POST" action="/add_user">
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">利用者の名字</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text"
                                    class="form-control @error('first_name') is-invalid @enderror" name="first_name"
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
                                <input id="last_name" type="text"
                                    class="form-control @error('last_name') is-invalid @enderror" name="last_name"
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
                                <input id="full_name" type="text"
                                    class="form-control @error('full_name') is-invalid @enderror" name="full_name"
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

                            <div class="col-md-2 mt-1">
                                <input id="age" type="number" class="form-control @error('age') is-invalid @enderror"
                                    name="age" value="{{ old('age') }}" required autocomplete="age" autofocus>
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
                                <label>
                                    <input class="@error('school_id') is-invalid @enderror" type="radio" name="school_id" value=1 @if(old('school_id')==1) checked
                                    @endif required autocomplete="school_id" autofocus>本校
                                </label>
                                <label>
                                    <input class="@error('school_id') is-invalid @enderror" type="radio" name="school_id" value=2 @if(old('school_id')==2) checked
                                        @endif>２校
                                </label>
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
                                <button type="button" class="btn btn-outline-primary"
                                    onclick="location.href='/master';">キャンセル</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
