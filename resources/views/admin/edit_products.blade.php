@extends('layouts.admin')
@section('content')
<div class="main-content-wrap">
    <div class="flex items-center flex-wrap justify-between gap20 mb-27">
        <h3>Add Product</h3>
        <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
            <li><a href="{{ route('dashboard') }}"><div class="text-tiny">Dashboard</div></a></li>
            <li><i class="icon-chevron-right"></i></li>
            <li><a href="{{ route('admin.products') }}"><div class="text-tiny">Products</div></a></li>
            <li><i class="icon-chevron-right"></i></li>
            <li><div class="text-tiny">Add product</div></li>
        </ul>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{ route('admin.store_products') }}">
        @csrf

        <div class="wg-box">
            <fieldset class="name">
                <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                <input class="mb-10" type="text" name="name" value="{{ old('name', $products->name )}}" placeholder="Enter product name" required>
            </fieldset>

            <fieldset class="name">
                <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                <input class="mb-10" type="text" name="slug" value="{{ old('slug', $products->slug ) }}" placeholder="Enter product slug" required>
            </fieldset>

            <div class="gap22 cols">
                <fieldset class="category">
                    <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                    <div class="select">
                        <select name="category_id" required>
                            <option value="">Choose category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $products->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                </fieldset>

                <fieldset class="brand">
                    <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                    <div class="select">
                        <select name="brand_id" required>
                            <option value="">Choose brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" 
                                    {{ old('brand_id', $products->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->brand_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>
            </div>

            <fieldset class="shortdescription">
                <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                <textarea class="mb-10 ht-150" name="short_description" required>{{ old('short_description', $products->short_description) }}</textarea>
            </fieldset>

            <fieldset class="description">
                <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                <textarea class="mb-10" name="description" required>{{ old('description', $products->description) }}</textarea>
            </fieldset>
        </div>

        <div class="wg-box">
            <fieldset>
                <div class="body-title">Upload image <span class="tf-color-1">*</span></div>
                <div class="upload-image flex-grow">
                    <div id="upload-file" class="item up-load">
                        <label class="uploadfile" for="myFile">
                            <span class="icon"><i class="icon-upload-cloud"></i></span>
                            <span class="body-text">Drop your images here or <span class="tf-color">click to browse</span></span>
                            <input type="file" id="myFile" name="image" accept="image/*" required onchange="previewMainImage(event)">
                        </label>
                    </div>
                    <!-- Preview for main image -->
                    <div id="main-image-preview" class="preview-container mt-10" style="display: none;">
                        <img id="main-image" src="{{ old('image', $products->image ? asset('uploads/products/' . $products->image) : '') }}" alt="Main image preview" style="max-width: 200px; max-height: 200px;">
                    </div>
                </div>
            </fieldset>
    
            <fieldset>
                <div class="body-title mb-10">Upload Gallery Images</div>
                <div class="upload-image mb-16">
                    <div id="galUpload" class="item up-load">
                        <label class="uploadfile" for="gFile">
                            <span class="icon"><i class="icon-upload-cloud"></i></span>
                            <span class="text-tiny">Drop your images here or <span class="tf-color">click to browse</span></span>
                            <input type="file" id="gFile" name="images[]" accept="image/*" multiple onchange="previewGalleryImages(event)">
                        </label>
                    </div>
                    <!-- Preview for gallery images -->
                    <div id="gallery-image-preview" class="preview-container mt-10">
                        <!-- Gallery previews will be shown here -->
                    </div>
                </div>
            </fieldset>

            <div class="cols gap22">
                <fieldset class="name">
                    <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="number" step="0.01" name="regular_price" value="{{ old('regular_price', $products->regular_price) }}" required>
                </fieldset>
                <fieldset class="name">
                    <div class="body-title mb-10">Sale Price</div>
                    <input class="mb-10" type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $products->sale_price) }}">
                </fieldset>
            </div>

            <div class="cols gap22">
                <fieldset class="name">
                    <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" name="sku" value="{{ old('sku', $products->sku) }}" >
                </fieldset>
                <fieldset class="name">
                    <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="number" name="quantity" min="0" value="{{ old('quantity', $products->quantity) }}" required>
                </fieldset>
            </div>

            <div class="cols gap22">
                <fieldset class="name">
                    <div class="body-title mb-10">Stock Status</div>
                    <div class="select mb-10">
                        <select name="stock_status" required>
                            <option value="instock" {{ old('stock_status') == 'instock' ? 'selected' : '' }}>In Stock</option>
                            <option value="outofstock" {{ old('stock_status') == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title mb-10">Featured</div>
                    <div class="select mb-10">
                        <select name="featured" required>
                            <option value="0" {{ old('featured') == '0' ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('featured') == '1' ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>
                </fieldset>
            </div>

            <div class="cols gap10">
                <button class="tf-button w-full" type="submit">Add product</button>
            </div>
        </div>
    </form>
</div>
<script>
    // Main image preview function
    function previewMainImage(event) {
        const mainImagePreview = document.getElementById('main-image-preview');
        const mainImage = document.getElementById('main-image');

        const file = event.target.files[0]; // Get the file
        if (file) {
            const reader = new FileReader();

            // Set up the reader to display the image when it's loaded
            reader.onload = function (e) {
                mainImage.src = e.target.result; // Set the image source to the file data
                mainImagePreview.style.display = 'block'; // Show the preview container
            };

            reader.readAsDataURL(file); // Read the file as a data URL
        }
    }

    // Gallery image preview function
    function previewGalleryImages(event) {
        const galleryPreviewContainer = document.getElementById('gallery-image-preview');
        galleryPreviewContainer.innerHTML = ''; // Clear any existing previews

        const files = event.target.files; // Get all selected files
        if (files.length > 0) {
            // Loop through each file and create an image preview
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                
                reader.onload = function (e) {
                    const img = document.createElement('img'); // Create an img element for each file
                    img.src = e.target.result; // Set the image source to the file data
                    img.style.maxWidth = '100px'; // Limit size of preview
                    img.style.marginRight = '10px'; // Add spacing between images
                    galleryPreviewContainer.appendChild(img); // Add the image to the preview container
                };

                reader.readAsDataURL(file); // Read the file as a data URL
            });
        }
    }
</script>
@endsection
