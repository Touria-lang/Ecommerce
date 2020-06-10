@extends('layouts.master')
@section('content')
<div class="row mb-2">  
  @foreach ($products as $product)
    <div class="col-md-6">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary">
            
            @foreach ($product->categories()->get() as $category)
                {{$category->name}}
            @endforeach
          </strong>
          <h5 class="mb-0">{{$product->title}}</h5>
          <div class="mb-1 text-muted">{{$product->created_at->format('d/m/y')}}</div>
          <p class="card-text mb-auto">{{$product->subtitle}}</p>
          <strong class="card-text mb-auto">{{$product->getFrenchPrice()}}</strong>
          <a href="{{route('products.show',['product' => $product])}}" class="stretched-link btn btn-primary">Voir l'article</a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <img src="{{
           str_replace('\\', '/', asset('storage/' . Arr::get(json_decode($product->image), 0)->download_link))
            
          }}" width="150" height="250">
          
        </div>
      </div>
    </div>
  @endforeach
</div>   
{{$products->links()}}   
@endsection

