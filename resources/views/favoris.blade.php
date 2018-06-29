@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h2 class="titlePage">{{ __('MES FAVORIS') }}</h2>
            </div>

            @if(session('message'))
                <div class='alert alert-success'>
                    {{ session('message') }}
                </div>
            @endif
            <div class="col-md-10">
                <h3 class="subTitle">Itinéraires</h3>


                <div class="row">

                    @foreach ($favoris as $data)
                        <div class="card col-md-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $data->nomfavoris}}</h5>
                                <p class="card-text"><span class="fromTo">DE:  {{ $data->adressedepart}} </span></p>
                                <p class="card-text"><span class="fromTo">A:  {{ $data->adressearriver}} </span></p>
                                <a href="#" class="btn btn-primary">Y ALLER</a>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>

        </div> <!-- /container -->
@endsection