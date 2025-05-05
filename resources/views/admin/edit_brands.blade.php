@extends('layouts.admin')
@section('content')
<div class="main-content-wrap">
    <div class="flex items-center flex-wrap justify-between gap20 mb-27">
        <h3>Brand infomation</h3>
        <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
            <li>
                <a href="{{ route('dashboard') }}">
                    <div class="text-tiny">Dashboard</div>
                </a>
            </li>
            <li><i class="icon-chevron-right"></i></li>
            <li>
                <a href="{{ route('admin.brands') }}">
                    <div class="text-tiny">Brands</div>
                </a>
            </li>
            <li><i class="icon-chevron-right"></i></li>
            <li>
                <div class="text-tiny">New Brand</div>
            </li>
        </ul>
    </div>

    <!-- new-category -->
    <div class="wg-box">
        <form class="form-new-product form-style-1" action="{{ route('admin.update_brands', $brands->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <fieldset class="name">
                <div class="body-title">Brand Name <span class="tf-color-1">*</span></div>
                <input class="flex-grow" type="text" placeholder="Brand name" name="name" value="{{ old('name') ?? $brands->brand_name }}"
                    tabindex="0" required>
            </fieldset>

            <fieldset class="name">
                <div class="body-title">Brand Slug <span class="tf-color-1">*</span></div>
                <input class="flex-grow" type="text" placeholder="Brand Slug" name="slug" value="{{ old('slug') ?? $brands->brand_slug }}"
                    tabindex="0" required>
            </fieldset>

            <fieldset>
                <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                <div class="upload-image flex-grow">
                    <div class="item" id="imgpreview" style="{{ $brands->brand_img ? '' : 'display: none' }}">
                        <img id="previewImage" src="{{ $brands->brand_img ? asset('uploads/brands/' . $brands->brand_img) : '' }}"
                             class="effect8" alt="Image preview">
                    </div>
                    
                    <div id="upload-file" class="item up-load">
                        <label class="uploadfile" for="myFile">
                            <span class="icon">
                                <i class="icon-upload-cloud"></i>
                            </span>
                            <span class="body-text">Drop your images here or select 
                                <span class="tf-color">click to browse</span>
                            </span>
                            <input type="file" id="myFile" name="image" accept="image/*">
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="bot">
                <div></div>
                <button class="tf-button w208" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- ✅ JavaScript for image preview -->
<script>
    document.getElementById('myFile').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('imgpreview');
        const previewImage = document.getElementById('previewImage');

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            previewImage.src = '';
            previewContainer.style.display = 'none';
        }
    });
</script>

@endsection