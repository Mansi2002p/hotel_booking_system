<?php

use App\Http\Controllers\api\AmenityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\ForgotPasswordController;
use App\Http\Controllers\api\HotelController;
use App\Http\Controllers\api\PayPalController;
use App\Http\Controllers\api\PropertyTypeController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\api\Roomcontroller;
use App\Http\Controllers\api\RoomTypeController;
use App\Http\Controllers\api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/paypal/execute-payment', [PayPalController::class, 'executePayment']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    // hotel api
    Route::get('/amenities', [AmenityController::class, 'index']);
    Route::get('/property_type', [PropertyTypeController::class, 'index']);
    Route::get('/room_type', [RoomTypeController::class, 'index']);
    Route::post('/hotel', [HotelController::class, 'createOrUpdate']);
    Route::delete('/hotels/{id}', [HotelController::class, 'destroy']);
    Route::post('/hotels-delete', [HotelController::class, 'hotelDelete']);
    Route::post('changeprofile', [UserController::class, 'changeProfile']); //change profile
    Route::get('hotel/details', [HotelController::class, 'showHotelById']); 
    Route::get('/customers', [UserController::class, 'getCustomerList']);
    Route::get('/hotel_owner', [UserController::class, 'getHotelownerList']);
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');

    Route::post('/reviews', [ReviewApiController::class, 'store'])->name('api.reviews.store');
    Route::get('/hotels/{hotel}/reviews', [ReviewApiController::class, 'hotelReviews'])->name('api.hotels.reviews');
    // check avilibility

    Route::get('/room-types', [BookingController::class, 'getRoomTypes']);
    
    // dd("efsdfvasd");
    // rooms api
    Route::post('/rooms', [Roomcontroller::class, 'storeOrUpdate']);
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::middleware(['auth'])->get('/owner-hotels', [HotelController::class, 'getOwnerHotels']);
    Route::post('/room-delete', [Roomcontroller::class, 'roomDelete']);
    Route::get('room/details', [Roomcontroller::class, 'showRoomById']); 


  
    Route::post('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking/calculate-price', [BookingController::class, 'calculatePrice'])->name('booking.calculatePrice');


    Route::get('booking-confirm' , [BookingController::class , 'userBookings']);



    Route::post('/paypal/create-payment', [PayPalController::class, 'createPayment']);





    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});





//  auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp']);
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

Route::get('/checkrooms', [BookingController::class, 'checkRooms']); // check room avilibility
//  hotel-owner
