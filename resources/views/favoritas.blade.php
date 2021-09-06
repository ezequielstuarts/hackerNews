@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Noticias Favoritas</div>

                <div class="card-body">
                    <div class="card-columns">
                        <noticias-favoritas-component></noticias-favoritas-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
