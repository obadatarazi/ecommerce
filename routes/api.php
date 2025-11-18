<?php

use App\Http\Controllers\Api\{AuthController, OptionController,CurrencyController};

use App\Http\Controllers\Api\User\{UserCartController};

use App\Http\Controllers\Api\Admin\{AdminAuthController,
    AdminMultiTypeSettingController,
    AdminPermissionController,
    AdminRoleController,
    AdminRolesController,
    AdminUserController,
    AdminVisualSettingController,
    AdminCategoryController,
    AdminProductController,
    AdminBrandController,
    AdminReviewController,
    AdminIngredientController,
    AdminCurrencyController,
    AdminCartController,

};
use Illuminate\Support\Facades\Route;

Route::prefix('/admin/auth')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::get('/me/profile', [AdminAuthController::class, 'me'])->middleware('auth:api');
});

Route::prefix('/admin')->middleware('auth:api')->group(function () {
    Route::get('/me/profile', [AdminAuthController::class, 'me']);
    Route::get('/me/roles', [AdminAuthController::class, 'getMyRoles']);
    Route::apiResource('/users', AdminUserController::class);
    Route::apiResource('/roles', AdminRoleController::class);
    Route::get('/permissions', [AdminPermissionController::class, 'index']);
    Route::get('/role/list', [AdminRolesController::class, 'findAll']);
    Route::get('/role/by-section', [AdminRolesController::class, 'getBySection']);
    Route::apiResource('/multi-type-settings', AdminMultiTypeSettingController::class);
    Route::apiResource('/visual-settings', AdminVisualSettingController::class);
    Route::apiResource('/categories', AdminCategoryController::class);
    Route::apiResource('/products', controller: AdminProductController::class);
    Route::apiResource('/brands', controller: AdminBrandController::class);
    Route::apiResource('/reviews', controller: AdminReviewController::class);
    Route::apiResource('/ingredients', controller: AdminIngredientController::class);
    Route::apiResource('/currencies', controller: AdminCurrencyController::class);
    Route::apiResource('/carts', controller: AdminCartController::class);




});

Route::prefix('/auth')->middleware('auth:api')->group(function () {
    Route::apiResource('/login', controller: AuthController::class);

});
Route::prefix('/user')->middleware('auth:api')->group(function () {
    Route::apiResource('/carts', controller: UserCartController::class);
    Route::get('/my/cart/', [UserCartController::class, 'show']);
    Route::get('/carts/uuid/{uuid}', [UserCartController::class, 'showByUuid']);
    Route::post('/carts/items', [UserCartController::class, 'addItemsToCart']);
    Route::delete('/carts/items', [UserCartController::class, 'deleteCartItems']);



});

Route::prefix('/mobile/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken'])->middleware(['auth:api']);
});

Route::prefix('/mobile')->middleware('auth:api')->group(function () {
    Route::get('/me/profile', [AuthController::class, 'me']);
    Route::put('/me/profile/update', [AuthController::class, 'updateProfile']);
});

Route::controller(OptionController::class)->group(function () {
    Route::get('/options/users/gender', 'getGenderType');
});

Route::apiResource('/currencies', controller: CurrencyController::class);

