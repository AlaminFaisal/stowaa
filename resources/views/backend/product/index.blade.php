@extends('layouts.backend')
@section('title', "All Product")

@section('content')
<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('backend.home')}}">Home</a></li>
                    <li class="breadcrumb-item active"
                        aria-current="page">All Product</li>
                </ol>
            </nav>
            <h1 class="m-0">All Product</h1>
        </div>
    </div>
</div>

<div class="container-fluid page__container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>All Product</h4>
                </div>
                <div class="card-body ">
                    <table class="table">
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Categories</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>
                                    <img src="{{asset('storage/product/'.$product->image)}}" alt="" width="50">
                                </td>
                                <td>{{Str::limit($product->title, 20, '...')}}</td>
                                <td>{{Str::limit($product->slug, 20, '....')}}</td>
                                <td>
                                    @foreach ($product->categories as $category)
                                        <span class="badge badge-success">{{$category->name}}</span>
                                    @endforeach
                                </td>
                                <td>{{$product->created_at->diffForHumans()}}</td>
                                <td>{{$product->status}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <p>{{ __('Product Not Found!') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </table>

                    <div class="mt-5">
                        {{$products->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
