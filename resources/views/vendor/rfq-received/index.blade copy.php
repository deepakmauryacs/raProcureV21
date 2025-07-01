@extends('vendor.layouts.app_second',['title'=>'RFQ','sub_title'=>'RFQ Received'])
@section('css')

@endsection
@section('breadcrumb')
<div class="breadcrumb-header">
    <div class="container-fluid">
        <h5 class="breadcrumb-line">
            <i class="bi bi-pin"></i> <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
            <a href="{{ route('vendor.rfq.received.index') }}"> ->RFQ</a>
            <a href="{{ route('vendor.rfq.received.index') }}"> ->RFQ Received</a>
        </h5>
    </div>
</div>
@endsection

@section('content')
<div class="about_page_details">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-body">
                <div class="col-md-12 d-flex justify-content-between">
                    <h3 class="">RFQ Received</h3>
                    <form id="searchForm" action="{{ route('vendor.rfq.received.index') }}" method="GET">
                        <ul class="rfq-filter-button">
                            <li>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <div class="form-floating">
                                        <input type="text" id="frq_no" name="frq_no"
                                            class="form-control fillter-form-control"
                                            value="{{ request('frq_no') }}" placeholder="Search RFQ No">
                                        <label for="frq_no">RFQ No</label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <div class="form-floating">
                                        <input type="text" id="buyer_name" name="buyer_name"
                                            class="form-control fillter-form-control"
                                            value="{{ request('buyer_name') }}" placeholder="Search Buyer Name">
                                        <label for="buyer_name">Buyer Name</label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-record2"></i></span>
                                    <div class="form-floating">
                                        <select name="status" id="status" class="form-select fillter-form-select">
                                            <option value=""> Select </option>
                                            <option value="1">RFQ Received </option>
                                            <option value="4">Counter Offer Received</option>
                                            <option value="5">Order Confirmed </option>
                                            <option value="6">Counter Offer Sent</option>
                                            <option value="7">Quotation Sent </option>
                                            <option value="8">Closed </option>
                                        </select>
                                        <label for="status">Status</label>
                                    </div>
                                </div>
                            </li>
                            <li class="notShow_on_mobile">
                                <button type="submit" class="btn-style btn-style-primary">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </li>
                            <li class="notShow_on_mobile">
                                <a href="{{ route('vendor.rfq.received.index') }}"
                                    class="btn-style btn-style-danger">RESET</a>
                            </li>
                        </ul>
                    </form>
                </div>
                <div class="col-md-12 botom-border">
                    <div class="table-responsive product_listing_table_wrap" id="table-container">
                        @include('vendor.rfq-received.partials.table', ['results' => $results])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $(document).on('submit', '#searchForm', function(e) {
        e.preventDefault();
        loadTable($(this).attr('action') + '?' + $(this).serialize());
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        loadTable($(this).attr('href'));
    });

    $(document).on('change', '#perPage', function () {
        const form = $('#searchForm');
        const formData = form.serialize();
        const perPage = $(this).val();
        const url = form.attr('action') + '?' + formData + '&per_page=' + perPage;
        loadTable(url);
    });

    function loadTable(url) {
        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () {
                $('#table-container').html('<div class="text-center py-4">Loading...</div>');
            },
            success: function(response) {
                $('#table-container').html(response);
                if (history.pushState) {
                    history.pushState(null, null, url);
                }
            }
        });
    }
});
</script>

@endsection