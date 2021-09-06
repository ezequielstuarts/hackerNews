@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-12 justify-content-center">
        <div class="card">
            <div class="card-header">Noticias</div>
            <div class="card-body">
                <div class="card-columns">
                    <noticias-component></noticias-component>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection
