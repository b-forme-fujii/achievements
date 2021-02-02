@extends('layouts.master_app')
@section('title', '利用者登録画面')
@yield('css')
@section('content')
<div class="row justify-content-center my-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <p class="mt-3 ml-2">実績データの追加</p>

                </div>
            </div>
            <div class="row justify-content-center">
                <div class="card-body">
                    <form method="POST" action="/add_achievement">
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="col-md-5 col-form-label text-md-right">利用者名</label>

                            <div class="col-md-5">
                                <p class="mt-2">{{$first_name}} {{$last_name}}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="insert_date" class="col-md-5 col-form-label text-md-right">登録日</label>

                            <div class="col-md-5">
                                <input id="insert_date" type="date"
                                    class="form-control @if(session('error')) is-invalid @endif" name="insert_date"
                                    value="{{ old('insert_date', date('Y-m-d')) }}" required autocomplete="insert_date" autofocus>
                                 @if (session('error')) 
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ session('error') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_time" class="col-md-5 col-form-label text-md-right">
                                開始時間
                            </label>

                            <div class="col-md-3 mt-1">
                                <input id="start_time" type="time"
                                    class="form-control @error('start_time') is-invalid @enderror" name="start_time" step="900" 
                                    value="{{ empty(old('start_time')) ? ("09:30") : old('start_time')}}" min="09:30"
                                    max="16:00" required autocomplete="start_time" autofocus>
                                @error('start_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_time" class="col-md-5 col-form-label text-md-right">
                                終了時間
                            </label>

                            <div class="col-md-3 mt-1">
                                <input id="end_time" type="time"
                                    class="form-control @error('end_time') is-invalid @enderror" name="end_time" step="900"
                                    value="{{ empty(old('end_time')) ? ("16:00") : old('end_time')}}" min="10:15"
                                    max="16:00" required autocomplete="end_time" autofocus>
                                @error('end_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="food" class="col-md-5 col-form-label text-md-right">食事提供加算</label>

                            <div class="col-md-6 mt-1">
                                <label class="mr-3">
                                    <input class="@error('food') is-invalid @enderror" type="radio" name="food" value=0
                                        @if(old('food')==0) checked @endif required autocomplete="food" autofocus>無
                                </label>
                                <label>
                                    <input class="@error('food') is-invalid @enderror" type="radio" name="food" value=1
                                        @if(old('food')==1) checked @endif required autocomplete="food" autofocus>有
                                </label>
                                @error('food')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="outside_support" class="col-md-5 col-form-label text-md-right">施設外支援</label>

                            <div class="col-md-6 mt-1">
                                <label class="mr-3">
                                    <input class="@error('outside_support') is-invalid @enderror" type="radio"
                                        name="outside_support" value=0 @if(old('outside_support')==0) checked @endif
                                        required autocomplete="outside_support" autofocus>無
                                </label>
                                <label>
                                    <input class="@error('outside_support') is-invalid @enderror" type="radio"
                                        name="outside_support" value=2 @if(old('outside_support')==2) checked @endif
                                        required autocomplete="outside_support" autofocus>有
                                </label>
                                @error('outside_support')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="medical__support" class="col-md-5 col-form-label text-md-right">医療連携体制加算</label>

                            <div class="col-md-6 mt-1">
                                <label class="mr-3">
                                    <input class="@error('medical__support') is-invalid @enderror" type="radio"
                                        name="medical__support" value=0 @if(old('medical__support')==0) checked @endif
                                        required autocomplete="medical__support" autofocus>無
                                </label>
                                <label>
                                    <input class="@error('medical__support') is-invalid @enderror" type="radio"
                                        name="medical__support" value=2 @if(old('medical__support')==2) checked @endif
                                        required autocomplete="medical__support" autofocus>有
                                </label>
                                @error('medical__support')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="note" class="col-md-5 col-form-label text-md-right">備考</label>

                            <div class="col-md-6 mt-1">
                                <select class="note my-1" name="note">
                                    <option value="通所" @if(old('note')=="通所" ) selected @endif>通所</option>
                                    <option value="Skype" @if(old('note')=="Skype" ) selected @endif>Skype</option>
                                    <option value="メール" @if(old('note')=="メール" ) selected @endif>メール</option>
                                    <option value="訪問" @if(old('note')=="訪問" ) selected @endif>訪問</option>
                                </select>
                                @error('note')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value={{$id}}>



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