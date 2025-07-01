<?php 
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorProfileController;
use App\Http\Controllers\Vendor\CommonController;
use App\Http\Controllers\Vendor\MiniWebPageController;
use App\Http\Controllers\Vendor\HelpSupportController;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\RfqReceivedController;
use App\Http\Controllers\Vendor\LiveAuctionRfqController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\FastTrackProductController;
use App\Http\Controllers\Vendor\MultipleProductController;

Route::name('vendor.')->group(function() {
    Route::middleware(['auth', 'validate_account', 'usertype:2'])->group(function () {
        
        // common routes
        Route::post('/get-state-by-country-id', [CommonController::class, 'getStateByCountryId'])->name('get-state-by-country-id');
        Route::post('/get-city-by-state-id', [CommonController::class, 'getCityByStateId'])->name('get-city-by-state-id');

        Route::prefix('profile')->group(function() {
            Route::get('/', [VendorProfileController::class, 'index'])->name('profile');
            Route::post('/validate-vendor-gstin-vat', [VendorProfileController::class, 'validateVendorGSTINVat'])->name('validate-vendor-gstin-vat');
            Route::post('/save-vendor-profile', [VendorProfileController::class, 'saveVendorProfile'])->name('save-vendor-profile');
            Route::get('/profile-complete', [VendorProfileController::class, 'profileComplete'])->name('profile-complete');
        });
        Route::get('/change-password',[VendorProfileController::class, 'changePassword'] )->name('password.change');
        Route::post('/update-password',[VendorProfileController::class, 'updatePassword'] )->name('password.update');

        Route::middleware(['profile_verified'])->group(function () {
            Route::prefix('dashboard')->group(function() {
                Route::get('/', [VendorDashboardController::class, 'index'])->name('dashboard');
            });

            Route::get('web-pages', [MiniWebPageController::class, 'index'])->name('web-pages.index');
            Route::post('web-pages/store', [MiniWebPageController::class, 'store'])->name('web-pages.store');
            // add new routes here.....
            Route::prefix('help-support')->group(function() {
                Route::get('/', [HelpSupportController::class, 'index'])->name('help_support.index');
                Route::get('/create', [HelpSupportController::class, 'create'])->name('help_support.create');
                Route::post('/store', [HelpSupportController::class, 'store'])->name('help_support.store');
                Route::put('/update/{id}', [HelpSupportController::class, 'update'])->name('help_support.update');
                Route::post('/view', [HelpSupportController::class, 'view'])->name('help_support.view');
                Route::post('/list', [HelpSupportController::class, 'list'])->name('help_support.list');
            }); 

            Route::prefix('orders-confirmed')->group(function() {
                Route::get('/rfq-order', [OrderController::class, 'rfqOrder'])->name('rfq_order.index');
                Route::get('/rfq-order/show/{id}', [OrderController::class, 'rfqOrderView'])->name('rfq_order.show');
                Route::get('/rfq-order/print/{id}', [OrderController::class, 'rfqOrderPrint'])->name('rfq_order.print');

                Route::get('/direct-order', [OrderController::class, 'directOrder'])->name('direct_order.index');

                Route::get('/direct-order/show/{id}', [OrderController::class, 'directOrderView'])->name('direct_order.show');
                Route::get('/direct-order/print/{id}', [OrderController::class, 'directOrderPrint'])->name('direct_order.print');
            });
            Route::prefix('rfq')->group(function() {
                Route::get('/rfq-received', [RfqReceivedController::class, 'index'])->name('rfq.received.index');
                Route::get('/live-auction', [LiveAuctionRfqController::class, 'index'])->name('rfq.live-auction.index');
            });

            Route::prefix('products')->group(function() {
                Route::get('/', [VendorProductController::class, 'index'])->name('products.index');
                Route::get('/create', [VendorProductController::class, 'create'])->name('products.create');
                Route::post('/store', [VendorProductController::class, 'store'])->name('products.store');
                // Route for editing a product
                Route::get('/vendor/products/{id}/edit', [VendorProductController::class, 'edit'])->name('products.edit');

                Route::put('/update/{id}', [VendorProductController::class, 'update'])->name('products.update');


                // Product Listing


                Route::get('manage-products/approved', [VendorProductController::class, 'approvedList'])->name('manage-products.approved');
                Route::get('manage-products/pending', [VendorProductController::class, 'pendingList'])->name('manage-products.pending');
              

                // Update Status (AJAX)
                Route::put('product-approvals/{id}/status', [VendorProductController::class, 'updateStatus'])->name('admin.product-approvals.status');

                // Delete Product (AJAX)
                Route::delete('product-approvals/{id}', [VendorProductController::class, 'destroy'])->name('admin.product-approvals.destroy');

                Route::get('get-categories-by-division/{division_id}', [VendorProductController::class, 'getCategoriesByDivision'])->name('getCategoriesByDivision');

                Route::get('product-autocomplete', [VendorProductController::class, 'autocomplete'])->name('product.autocomplete');
                
                Route::get('add-fast-track-product', [FastTrackProductController::class, 'index'])->name('products.fast_track_product');

                Route::post('products/new_search_product_for_supplier', [FastTrackProductController::class, 'newSearchProductForSupplier'])->name('products.new_search_product_for_supplier');
                Route::get('fasttrack/products/autocomplete', [FastTrackProductController::class, 'autocomplete'])->name('fasttrack.products.autocomplete');

                Route::post('fasttrack/products/store', [FastTrackProductController::class, 'storeFastTrackProducts'])->name('fasttrack.products.store');

               // For Multiple Products
               Route::get('add-multiple-product', [MultipleProductController::class, 'index'])->name('products.add_multiple_product');

               Route::any('add-multiple/products/autocomplete', [MultipleProductController::class, 'autocomplete'])->name('addmultiple.products.autocomplete');

               Route::post('add-multiple/products/store', [MultipleProductController::class, 'storeMultipleProducts'])->name('addmultiple.products.store');

                

                



            });


        });

    });
});