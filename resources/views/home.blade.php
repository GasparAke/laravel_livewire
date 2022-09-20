@extends('layouts.theme.app')

@section('content')
<div class="container">
<br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
            <img src="assets/img/pizza.jpeg" class="img-circle" alt="AdminLTE Logo" 
      style="width: 30%; display:block; margin:auto;">

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Iniciaste Sesión!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
