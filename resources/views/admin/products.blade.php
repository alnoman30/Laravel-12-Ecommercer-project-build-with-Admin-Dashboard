@extends('layouts.admin')
@section('content')
<div class="main-content-wrap">
    <div class="flex items-center flex-wrap justify-between gap20 mb-27">
        <h3>All Products</h3>
        <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
            <li>
                <a href="{{ route('dashboard') }}">
                    <div class="text-tiny">Dashboard</div>
                </a>
            </li>
            <li>
                <i class="icon-chevron-right"></i>
            </li>
            <li>
                <div class="text-tiny">All Products</div>
            </li>
        </ul>
    </div>

    <div class="wg-box">
        <div class="flex items-center justify-between gap10 flex-wrap">
            <div class="wg-filter flex-grow">
                <form class="form-search">
                    <fieldset class="name">
                        <input type="text" placeholder="Search here..." class="" name="name"
                            tabindex="2" value="" aria-required="true" required="">
                    </fieldset>
                    <div class="button-submit">
                        <button class="" type="submit"><i class="icon-search"></i></button>
                    </div>
                </form>
            </div>
            <a class="tf-button style-1 w208" href="{{ route('admin.add_products') }}"><i
                    class="icon-plus"></i>Add new</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>SalePrice</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Featured</th>
                        <th>Stock</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $products as $product )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="pname">
                            <div class="image">
                                <img src="{{ asset('uploads/products') }}/{{ $product->image}}" alt="" class="image">
                            </div>
                            <div class="name">
                                <a href="{{ $product->slug }}" class="body-title-2">{{ $product->name }}</a>
                                <div class="text-tiny mt-3">{{ $product->slug }}</div>
                            </div>
                        </td>
                        <td>{{ $product->regular_price }}</td>
                        <td>{{ $product->sale_price }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->category->category_name }}</td>
                        <td>{{ $product->brand->brand_name }}</td>

                        <td>{{ $product->featured ? 'Yes' : 'No' }}</td>
                        <td>{{ $product->stock_status }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            <div class="list-icon-function">
                                <a href="#" target="_blank">
                                    <div class="item eye">
                                        <i class="icon-eye"></i>
                                    </div>
                                </a>
                                <a href="{{ route('admin.edit_products', $product->id )}}">
                                    <div class="item edit">
                                        <i class="icon-edit-3"></i>
                                    </div>
                                </a>
                                <form action="{{ route('admin.delete_products', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this brand?'); ">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="item text-danger delete" style="background: none; border: none; padding: 0;">
                                        <i class="icon-trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="divider"></div>
        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">


        </div>
    </div>
</div>
@endsection