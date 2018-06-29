@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="titlePage">FAQ</h1>

{{--// On affiche chaque entrée une à une--}}

        @foreach ($faq as $data)
                <div class="col-md-10">
                    <h3 class="subTitle">{{  $data->questions }}</h3>
                    <p>{{  $data->reponses }}</p>
                </div>
        @endforeach
    </div> <!-- /container -->
@endsection