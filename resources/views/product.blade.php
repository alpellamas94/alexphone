@extends('layout')

@section('title_page')
{{$title_page}}
@endsection

@section('navbar')
    @include('navbar')
@endsection

@section('content')
    <div class="mdl-detail">
        <div class="m-img" style="background-image: url('{{$element->image}}');"></div>

        <div class="m-section">
            <div class="m-top">
                <div class="m-title">{{$element->name}}</div>

                <div class="m-price">
                    <strong>{{$item->price}}€</strong>
                </div>
            </div>
            
            <div class="m-desc">{{$element->description}}</div>
            
            <div class="m-features m-row">
                <div class="m-colors">
                    <span class="m-color {{$item->color}}" style="background-color: {{$item->color}};">{{config('colors.' . $item->color)}}</span>
                </div>

                <div class="m-storage">
                    <span>{{$item->storage}} GB</span>
                </div>

                <div class="m-grade">
                    <span>{{config('grades.' . $item->grade)}}</span>
                </div>
            </div>
        </div>
    </div>
@endsection