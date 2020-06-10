@extends('layouts.master')
@section('content')
<div class="col-md-12">
    <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary">World</strong>
            <h5 class="mb-0">{{$product->title}}</h5>
            <div class="mb-1 text-muted">{{$product->created_at->format('d/m/y')}}</div>
            <p class="card-text mb-auto">{{$product->description}}</p>
            <strong class="card-text mb-auto">{{$product->getFrenchPrice()}}</strong>
            <form action="{{route('carts.store')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$product->id}}">
                
                <button type="submit" class="btn btn-dark">Ajouter au panier</button>
            </form>
        </div>
        <div class="col-auto d-none d-lg-block">
            <img src="{{
                str_replace('\\', '/', asset('storage/' . Arr::get(json_decode($product->image), 0)->download_link))
            
            }}" width="150" height="250">
        </div>
    </div>
</div>   
@endsection
