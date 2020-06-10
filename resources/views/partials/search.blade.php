<form action="{{route('products.search')}}" method="get" class="d-flex">
    @csrf
    <input type="text" name="q" class="form-control" value="{{request('q') ?? ''}}"/>
    <button type="submit" class="btn btn-info mr-3"><i class="fa fa-search"></i></button>
</form>



