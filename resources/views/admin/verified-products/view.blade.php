@extends('admin.layouts.app_second', [
'title' => 'Verified Products',
'sub_title' => 'Edit Verified Product'
])
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<style>
.bootstrap-tagsinput {
    width: 100%;
    min-height: 38px;
    padding: 0.375rem 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.bootstrap-tagsinput .tag {
    margin-right: 2px;
    color: white;
    background-color: #0d6efd;
    padding: 2px 5px;
    border-radius: 3px;
}

.capital {
    text-transform: uppercase;
}

.ck-editor__editable {
    min-height: 200px;
}

.text-warning {
    color: #ffc107 !important;
}

ul {
    list-style: outside none none;
    margin: 0;
    padding: 0;
}

.char-count {
    font-size: 0.8rem;
    color: #6c757d;
}

.char-count.warning {
    color: #ffc107;
}

.char-count.error {
    color: #dc3545;
}
</style>
@endsection
@section('breadcrumb')
<div class="breadcrumb-header">
    <div class="container-fluid">
        <h5 class="breadcrumb-line">
            <i class="bi bi-box-seam"></i>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.verified-products.index') }}"> -> Verified Products</a>
            <span> -> View Verified Product</span>
        </h5>
    </div>
</div>
@endsection

@section('content')

<div class="page-start-section from-start-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between"
                        style="background-color: transparent;padding: 15px;border: none !important;">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#general_information_menu"
                                    style="color: #015294;background-color: #fff;border-color: #fff;border-bottom: 1px solid #015294 !important;">
                                    <i class="bi bi-info-circle me-2"></i>
                                    General Information
                                </a>
                            </li>
                        </ul>
                        <div class="ms-auto">
                            <a class="btn-rfq btn-rfq-primary" href="{{ route('admin.verified-products.index') }}">
                                <i class="bi bi-arrow-left-square"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form pro_edit">
                            <form id="editVerifiedProductForm" method="POST" enctype="multipart/form-data" novalidate>
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                <input type="hidden" name="vendor_id" value="{{ $product->vendor_id }}">

                                <!-- Product Name -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Product Name<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="product_name" id="product_name"
                                            value="{{ $product->product->product_name }}" disabled>
                                        <span class="text-danger error-text product_name_error"></span>
                                    </div>
                                </div>

                                <!-- Upload Picture -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Upload Picture</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" name="product_image" id="product_image" class="form-control"
                                            accept=".jpeg,.jpg,.png,.gif"
                                            onchange="validateProductFile(this, 'JPEG/JPG/PNG/GIF')">
                                        <span class="text-danger error-text product_image_error"></span>
                                        @if($product->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('public/uploads/product/thumbnails/100/'.$product->image) }}"
                                                alt="Product Image" style="max-width: 200px; max-height: 200px;">
                                            <a href="{{ asset('public/uploads/product/thumbnails/100/'.$product->image) }}"
                                                target="_blank" class="ms-2"> <b>View Full Image </b></a>
                                            <input type="hidden" name="existing_product_image"
                                                value="{{ $product->image }}">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <span class="text-muted">(JPEG/JPG/PNG/GIF)</span>
                                    </div>
                                </div>

                                <!-- Product Description -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Product Description<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <span class="char-count prod-des-count">Characters:
                                            {{ strlen($product->description) }}/500</span>
                                        <textarea class="form-control" id="product_description"
                                            name="product_description" disabled>{{ $product->description }}</textarea>
                                        <span class="text-danger error-text product_description_error"></span>
                                    </div>
                                </div>

                                <!-- Dealer Type -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Dealer Type<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select" id="product_dealer_type" name="product_dealer_type"
                                            disabled>
                                            <option value="">Select Dealer Type</option>
                                            <option value="1" {{ $product->dealer_type_id == '1' ? 'selected' : '' }}>
                                                Manufacturer</option>
                                            <option value="2" {{ $product->dealer_type_id == '2' ? 'selected' : '' }}>
                                                Trader</option>
                                        </select>
                                        <span class="text-danger error-text product_dealer_type_error"></span>
                                    </div>
                                </div>

                                <!-- UOM -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">UOM</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="product_uom" name="product_uom" class="form-select" disabled>
                                            <option value="1" {{ $product->uom == '1' ? 'selected' : '' }}>Pieces
                                            </option>
                                            <option value="2" {{ $product->uom == '2' ? 'selected' : '' }}>Sets</option>
                                            <option value="3" {{ $product->uom == '3' ? 'selected' : '' }}>Metre
                                            </option>
                                            <option value="4" {{ $product->uom == '4' ? 'selected' : '' }}>MT</option>
                                            <option value="5" {{ $product->uom == '5' ? 'selected' : '' }}>Kgs</option>
                                            <option value="6" {{ $product->uom == '6' ? 'selected' : '' }}>Litre
                                            </option>
                                            <option value="7" {{ $product->uom == '7' ? 'selected' : '' }}>Packages
                                            </option>
                                        </select>
                                        <span class="text-danger error-text product_uom_error"></span>
                                    </div>
                                </div>

                                <!-- GST/Sales Tax Rate -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">GST/Sales Tax Rate<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select" id="product_gst" name="product_gst" disabled>
                                            <option value="">Select GST Class</option>
                                            <option value="1" {{ $product->gst_id == '1' ? 'selected' : '' }}>0%
                                            </option>
                                            <option value="2" {{ $product->gst_id == '2' ? 'selected' : '' }}>5%
                                            </option>
                                            <option value="3" {{ $product->gst_id == '3' ? 'selected' : '' }}>12%
                                            </option>
                                            <option value="4" {{ $product->gst_id == '4' ? 'selected' : '' }}>18%
                                            </option>
                                            <option value="5" {{ $product->gst_id == '5' ? 'selected' : '' }}>28%
                                            </option>
                                        </select>
                                        <span class="text-danger error-text product_gst_error"></span>
                                    </div>
                                </div>


                                <!-- HSN Code -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">HSN Code<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="product_hsn_code"
                                            name="product_hsn_code" placeholder="HSN Code"
                                            value="{{ $product->hsn_code }}" maxlength="8"
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" disabled>
                                        <span class="text-danger error-text product_hsn_code_error"></span>
                                    </div>
                                </div>

                                <!-- Aliases and Tags -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Aliases & Tags</label>
                                    </div>
                                    <div class="col-md-9">
                                        <span><b>Master Aliases:</b>
                                            {{ get_alias_master_by_prod_id($product->product_id) }}</span>
                                        @php
                                        $vendor_alias =
                                        get_alias_vendor_by_prod_id($product->product_id,$product->vendor_id);
                                        @endphp
                                        <input type="text" data-role="tagsinput" class="form-control" name="tag"
                                            id="tags-input" value="{{ old('vendor_alias', $vendor_alias ?? '') }}"
                                            disabled>
                                        <div class="product-alias-error-msg"></div>
                                    </div>
                                </div>

                                <!-- Product Catalogue -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Product Catalogue</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="file" name="product_catalogue_file" id="product_catalogue_file"
                                            class="form-control" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx"
                                            onchange="validateProductFile(this, 'PDF/PNG/JPG/JPEG/DOCX/DOC')">
                                        <span class="text-danger error-text product_catalogue_file_error"></span>
                                        @if($product->catalogue)
                                        <div class="mt-2">
                                            <a href="{{ asset('public/uploads/product/docs/'.$product->catalogue) }}"
                                                target="_blank">
                                                {{ $product->catalogue }} View Catalogue File
                                            </a>
                                            <input type="hidden" name="existing_product_catalogue_file"
                                                value="{{ $product->catalogue }}">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <span class="text-muted">(PDF/Image/Document)</span>
                                    </div>
                                </div>

                                <!-- Product Specifications -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Specifications</label>
                                    </div>
                                    <div class="col-md-9">
                                        <span class="char-count spec-char-count">Characters:
                                            {{ strlen($product->specification) }}/500</span>
                                        <textarea class="form-control" id="product_specifications"
                                            name="product_specifications">{{ $product->specification }}</textarea>
                                        <span class="text-danger error-text product_specifications_error"></span>
                                    </div>
                                </div>

                                <!-- Specifications Attachment -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Specifications Attachment</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="file" name="product_specification_file"
                                            id="product_specification_file" class="form-control"
                                            accept=".pdf,.png,.jpg,.jpeg,.doc,.docx"
                                            onchange="validateProductFile(this, 'PDF/PNG/JPG/JPEG/DOCX/DOC')">
                                        <span class="text-danger error-text product_specification_file_error"></span>
                                        @if($product->specification_file)
                                        <div class="mt-2">
                                            <a href="{{ asset('public/uploads/product/docs/'.$product->specification_file) }}"
                                                target="_blank">
                                                {{ $product->specification_file }} <b> View Specification File </b>
                                            </a>
                                            <input type="hidden" name="existing_product_specification_file"
                                                value="{{ $product->specification_file }}">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <span class="text-muted">(PDF/Image/Document)</span>
                                    </div>
                                </div>

                                <!-- Size -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Size</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" data-role="tagsinput" class="form-control"
                                            name="product_size" id="size-input" value="{{ $product->size }}" disabled>
                                        <span class="text-danger error-text product_size_error"></span>
                                    </div>
                                </div>

                                <!-- Certification -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Certification</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" data-role="tagsinput" class="form-control"
                                            name="product_certification" id="product_certification"
                                            value="{{ $product->certificates }}" disabled>
                                        <span class="text-danger error-text product_certification_error"></span>
                                    </div>
                                </div>

                                <!-- Certification Attachment -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Certification Attachment</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="file" name="product_certificates_file"
                                            id="product_certificates_file" class="form-control"
                                            accept=".pdf,.png,.jpg,.jpeg,.doc,.docx"
                                            onchange="validateProductFile(this, 'PDF/PNG/JPG/JPEG/DOCX/DOC')">
                                        <span class="text-danger error-text product_certificates_file_error"></span>
                                        @if($product->certificates_file)
                                        <div class="mt-2">
                                            <a href="{{ asset('public/uploads/product/docs/'.$product->certificates_file) }}"
                                                target="_blank">
                                                {{ $product->certificates_file  }} <b> View Certification File </b>
                                            </a>

                                            <input type="hidden" name="existing_product_certificates_file"
                                                value="{{ $product->certificates_file }}">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <span class="text-muted">(PDF/Image/Document)</span>
                                    </div>
                                </div>

                                <!-- Dealership -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Dealership</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" data-role="tagsinput" class="form-control"
                                            name="product_dealership" id="dealership" value="{{ $product->dealership }}"
                                            disabled>
                                        <span class="text-danger error-text product_dealership_error"></span>
                                    </div>
                                </div>

                                <!-- Dealership Attachment -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Dealership Attachment</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="file" name="product_dealership_file" id="product_dealership_file"
                                            class="form-control" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx"
                                            onchange="validateProductFile(this, 'PDF/PNG/JPG/JPEG/DOCX/DOC')">
                                        <span class="text-danger error-text product_dealership_file_error"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="text-muted">(PDF/Image/Document)</span>
                                    </div>
                                </div>

                                <!-- Packaging -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Packaging</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="product_packaging"
                                            id="product_packaging" value="{{ $product->packaging }}" maxlength="1700"
                                            disabled>
                                        <span class="text-danger error-text product_packaging_error"></span>
                                    </div>
                                </div>

                                <!-- Model No -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Model No.</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="product_model_no" id="Model No."
                                            value="{{ $product->model_no }}" maxlength="255" disabled>
                                        <span class="text-danger error-text product_model_no_error"></span>
                                    </div>
                                </div>

                                <!-- Guarantee/Warranty -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Guarantee/Warranty</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select name="prod_gorw" id="waranty_guarantee_type" class="form-select"
                                                    disabled>
                                                    <option value="Guarantee"
                                                        {{ $product->gorw == 'Guarantee' ? 'selected' : '' }}>Guarantee
                                                    </option>
                                                    <option value="Waranty"
                                                        {{ $product->gorw == 'Waranty' ? 'selected' : '' }}>Warranty
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 d-flex">

                                                <input type="text" class="form-control" name="product_gorw_year"
                                                    id="product_gorw_year" value="{{ $product->gorw_year }}"
                                                    placeholder="Ex. 1 Year"
                                                    oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,4)"
                                                    disabled>
                                                <label style="margin-left: 10px;margin-top: 10px;">Year</label>

                                            </div>
                                            <div class="col-md-4 d-flex">


                                                <input type="number" class="form-control waranty_guarantee_value"
                                                    name="product_gorw_month" id="waranty_guarantee_value" min="0"
                                                    max="12" value="{{ $product->gorw_month }}"
                                                    placeholder="Ex. 1 Month"
                                                    oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,2); if(parseInt(this.value) > 12) this.value = '12';"
                                                    disabled>
                                                <label style="margin-left: 10px;margin-top: 10px;">Month</label>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Brand -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Brand</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="brand_name" class="form-control" id="brand_name"
                                            value="{{ $product->brand }}" maxlength="255" disabled>
                                        <span class="text-danger error-text brand_name_error"></span>
                                    </div>
                                </div>

                                <!-- Country of Origin -->
                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <label class="form-label mb-0">Country of Origin</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input domestic" type="radio"
                                                name="product_country_origin" id="domestic" value="domestic" checked>
                                            <label class="form-check-label" for="domestic">India</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input international" type="radio"
                                                name="product_country_origin" id="international" value="international">
                                            <label class="form-check-label" for="international">International</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js" defer></script>
<script>
$(document).ready(function() {
    const editorConfig = {
        toolbar: [
            "heading", "bold", "italic", "bulletedList", "numberedList",
            "blockQuote", "undo", "redo"
        ]
    };

    const MAX_CHARS = 500;

    function initEditor(selector, counterSelector, errorSelector = null, validateForm = false) {
        ClassicEditor
            .create(document.querySelector(selector), editorConfig)
            .then(editor => {
                const counter = document.querySelector(counterSelector);
                let isProcessing = false;

                const updateCount = () => {
                    if (isProcessing) return;
                    isProcessing = true;

                    const content = editor.getData();
                    const text = content.replace(/<[^>]*>/g, '');
                    const count = text.length;

                    counter.textContent = `Characters: ${count}/${MAX_CHARS}`;
                    counter.className = 'char-count';

                    if (count > MAX_CHARS) {
                        counter.classList.add('error');
                        const trimmed = text.substring(0, MAX_CHARS);
                        editor.setData(trimmed);
                    } else if (count > 450) {
                        counter.classList.add('warning');
                    }

                    isProcessing = false;
                };

                updateCount();
                editor.model.document.on('change:data', updateCount);

                if (validateForm && errorSelector) {
                    document.querySelector('#editVerifiedProductForm').addEventListener('submit', function(
                        e) {
                        const content = editor.getData();
                        const text = content.replace(/<[^>]*>/g, '');
                        if (text.length > MAX_CHARS) {
                            e.preventDefault();
                            document.querySelector(errorSelector).textContent =
                                'Description must be 500 characters or less';
                        }
                    });
                }
            })
            .catch(error => {
                console.error(`Editor initialization error for ${selector}:`, error);
            });
    }

    // Initialize both editors
    initEditor('#product_description', '.prod-des-count', '#product_description_error', true);
    initEditor('#product_specifications', '.spec-char-count');

    $('#editVerifiedProductForm input, #editVerifiedProductForm select').on('keyup change', function() {
        const fieldName = $(this).attr('name');
        $(`span.error-text.${fieldName}_error`).text('');
    });
});
</script>
@endsection