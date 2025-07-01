<?php 
use App\Http\Controllers\Buyer\BuyerDashboardController;
use App\Http\Controllers\Buyer\BuyerProfileController;
use App\Http\Controllers\Buyer\CommonController;
use App\Http\Controllers\Buyer\CategoryController;
use App\Http\Controllers\Buyer\VendorProductController;
use App\Http\Controllers\Buyer\RFQDraftController;
use App\Http\Controllers\Buyer\RFQComposeController;
use App\Http\Controllers\Buyer\ComposeRFQController;
use App\Http\Controllers\Buyer\SearchProductController;
use App\Http\Controllers\Buyer\ActiveRFQController;

Route::name('buyer.')->group(function() {

    Route::middleware(['auth', 'validate_account', 'usertype:1'])->group(function () {

        // common routes
        Route::post('/get-state-by-country-id', [CommonController::class, 'getStateByCountryId'])->name('get-state-by-country-id');
        Route::post('/get-city-by-state-id', [CommonController::class, 'getCityByStateId'])->name('get-city-by-state-id');
        
        Route::prefix('profile')->group(function() {
            Route::get('/', [BuyerProfileController::class, 'index'])->name('profile');
            Route::post('/validate-buyer-gstin-vat', [BuyerProfileController::class, 'validateBuyerGSTINVat'])->name('validate-buyer-gstin-vat');
            Route::post('/validate-buyer-short-code', [BuyerProfileController::class, 'validateBuyerShortCode'])->name('validate-buyer-short-code');
            Route::post('/save-buyer-profile', [BuyerProfileController::class, 'saveBuyerProfile'])->name('save-buyer-profile');
            Route::get('/profile-complete', [BuyerProfileController::class, 'profileComplete'])->name('profile-complete');
        });
                
        Route::middleware(['profile_verified'])->group(function () {

            Route::prefix('dashboard')->group(function() {
                Route::get('/', [BuyerDashboardController::class, 'index'])->name('dashboard');
            });
            
            Route::prefix('category')->group(function() {
                Route::get('/category-product/{id}', [CategoryController::class, 'index'])->name('category.product');
                Route::post('/get-category-product', [CategoryController::class, 'getCategoryProduct'])->name('category.get-product');
            });

            Route::prefix('vendor-product')->group(function() {
                Route::get('/{id}', [VendorProductController::class, 'index'])->name('vendor.product');
            });
            Route::prefix('rfq')->group(function() {
                Route::post('draft/add', [RFQDraftController::class, 'addToDraft'])->name('rfq.add-to-draft');
                Route::get('compose/draft-rfq/{draft_id}', [RFQComposeController::class, 'index'])->name('rfq.compose-draft-rfq');
                Route::post('draft-rfq/add', [RFQDraftController::class, 'addToDraftRFQ'])->name('rfq.add-to-draft-rfq');
                Route::get('compose/rfq-success/{rfq_id}', [ComposeRFQController::class, 'composeRFQSuccess'])->name('rfq.compose-rfq-success');


                Route::get('active-rfq', [ActiveRFQController::class, 'index'])->name('rfq.active-rfq');
                Route::get('draft-rfq', [RFQDraftController::class, 'index'])->name('rfq.draft-rfq');
                
            });
            
            Route::prefix('ajax')->group(function() {
                Route::post('get-vendor-product', [VendorProductController::class, 'getVendorProduct'])->name('vendor.get-product');
                
                Route::post('compose/get-draft-product', [RFQComposeController::class, 'getDraftProduct'])->name('rfq.get-draft-product');
                Route::post('compose/search-selected-product', [RFQComposeController::class, 'searchSelectedProduct'])->name('rfq.search-selected-product');
                Route::post('compose/rfq-update-product', [RFQComposeController::class, 'updateProduct'])->name('rfq.update-product');
                Route::post('compose/rfq-update-draft', [RFQComposeController::class, 'updateDraftRFQ'])->name('rfq.update-draft');
                Route::post('compose/rfq-delete-product', [RFQComposeController::class, 'deleteProduct'])->name('rfq.delete-product');
                Route::post('compose/rfq-delete-product-variant', [RFQComposeController::class, 'deleteProductVariant'])->name('rfq.delete-product-variant');
                Route::post('compose/rfq-delete-draft', [RFQComposeController::class, 'deleteDraftRFQ'])->name('rfq.delete-draft');
                Route::post('compose/rfq-compose', [ComposeRFQController::class, 'composeRFQ'])->name('rfq.compose');
                
                Route::post('search/vendor-product', [SearchProductController::class, 'searchVendorActiveProduct'])->name('search.vendor-product');
                Route::post('search-by-division', [SearchProductController::class, 'getSearchByDivision'])->name('search-by-division');
                
                Route::post('delete-draft-rfq', [RFQDraftController::class, 'deleteDraftRFQ'])->name('rfq.draft-rfq.delete-draft-rfq');
                
            });

            
            
        });
    });
});
