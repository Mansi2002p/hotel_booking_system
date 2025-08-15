<?php

use App\Http\Controllers\admin\AmentitiesController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\HotelController;
use App\Http\Controllers\admin\PropertyTypeController;
use App\Http\Controllers\admin\RoomTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\customer\BookingController;
use App\Http\Controllers\customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\customer\HotelController as CustomerHotelController;
use App\Http\Controllers\customer\InvoiceController;
use App\Http\Controllers\customer\PaymentController;
use App\Http\Controllers\hotel\BookingController as HotelBookingController;
// use App\Http\Controllers\hotel\DashboardController as HotelDashboardController;
use App\Http\Controllers\Hotel\DashboardController  as HotelDashboardController;
use App\Http\Controllers\hotel\HotelsController;
use App\Http\Controllers\hotel\PaymentController as HotelPaymentController;
use App\Http\Controllers\hotel\RateController;
use App\Http\Controllers\hotel\RoomsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });




// customer page 
Route::get('/', [CustomerHotelController::class, 'index'])->name('web.home');
Route::get('rooms', [CustomerHotelController::class, 'showRooms'])->name('web.rooms');
Route::get('about', [CustomerHotelController::class, 'ShowAbout'])->name('web.about');
Route::get('contact', [CustomerHotelController::class, 'ShowContact'])->name('web.contact');
Route::get('/rooms/{id}', [CustomerHotelController::class, 'ShowRoomDetails'])->name('rooms.show');
Route::get('/hotel/{id}', [CustomerHotelController::class, 'showHotelDetails'])->name('hotel.detail');
Route::get('hotels', [CustomerHotelController::class, 'showHotel'])->name('web.hotels');
Route::get('/get-room-types', [CustomerHotelController::class, 'getRoomTypes']);
Route::get('/get-rooms-by-type', [CustomerHotelController::class, 'getRoomsByType']);
Route::post('/check-availability', [CustomerHotelController::class, 'checkAvailability'])->name('check-availability');
Route::get('/get-cities' , [CustomerHotelController::class , 'getCity'])->name('get-cities');
Route::get('/get-hotels', [CustomerHotelController::class, 'getHotelsByCity'])->name('get-hotels');
// specific hotel rooms filter 
// Route::get('rooms', [CustomerHotelController::class, 'showhotelRooms'])->name('');



// authentication 
Route::post('authregister', [AuthController::class, 'register'])->name('authregister');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/authenticate', [AuthController::class, 'login'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
//dynmic dropdown-register
Route::get('fetch-countries', [AuthController::class, 'getCountries']);
Route::get('fetch-states', [AuthController::class, 'fetchStates']);
Route::get('fetch-cities', [AuthController::class, 'fetchCity']);




// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard',[DashboardController::class ,'index'])->name('admin.dashboard');

    // hotel-owner details
    Route::get('/hotel-owners', [DashboardController::class, 'showHotelOwners'])->name('admin.hotel-owners');
    Route::get('/get-hotel-owners', [DashboardController::class, 'getHotelOwners'])->name('admin.get-hotel-owners');
    Route::get('/hotel-owner/{id}/edit', [DashboardController::class, 'edit'])->name('admin.hotel-owner.edit');
    Route::post('/hotel-owner/{id}/update', [DashboardController::class, 'update'])->name('admin.hotel-owner.update');
    Route::get('/hotel-owner/{id}/delete', [DashboardController::class, 'destroy'])->name('admin.hotel-owner.delete');


    //customer detail
    Route::get('/customers', [DashboardController::class, 'showCustomers'])->name('admin.customers');
    Route::get('/get-customers', [DashboardController::class, 'getCustomers'])->name('admin.get-customers');
    Route::get('/customer/{id}/edit', [DashboardController::class, 'editCustomer'])->name('admin.customer.edit');
    Route::post('/customer/{id}/update', [DashboardController::class, 'updateCustomer'])->name('admin.customer.update');
    Route::get('/customer/{id}/delete', [DashboardController::class, 'destroy'])->name('admin.customer.delete');

    // property type
    Route::get('property/{id?}', [PropertyTypeController::class, 'createOrEdit'])->name('admin.property');
    Route::post('property/{id?}', [PropertyTypeController::class, 'createOrUpdate'])->name('admin.property.createOrUpdate'); // Create or Update
    Route::get('property-list', [PropertyTypeController::class, 'show'])->name('admin.property-list'); // List Page
    Route::get('admin/property-types', [PropertyTypeController::class, 'getPropertyTypes'])->name('admin.property-types'); // AJAX List
    Route::get('property/{id}/edit', [PropertyTypeController::class, 'createOrEdit'])->name('admin.property.edit');// Edit Page
    Route::delete('property/{id}', [PropertyTypeController::class, 'destroy'])->name('admin.property.delete'); // Delete
    
    //  Room Type
    Route::get('room/{id?}', [RoomTypeController::class, 'createOrEdit'])->name('admin.room.createOrEdit'); // Edit/Create Page
    Route::get('room/{id}/edit', [RoomTypeController::class, 'createOrEdit'])->name('admin.room.edit');
    Route::post('room/{id?}', [RoomTypeController::class, 'createOrUpdate'])->name('admin.room.createOrUpdate'); // Create/Update Action
    Route::get('room-list', [RoomTypeController::class, 'show'])->name('admin.room-list');
    Route::get('room-types', [RoomTypeController::class, 'getRoomTypes'])->name('admin.room-types');
    Route::delete('room/{id}', [RoomTypeController::class, 'destroy'])->name('admin.room.delete');
    
    // Amenities Routes
    Route::get('amenities/{id?}', [AmentitiesController::class, 'createOrEdit'])->name('admin.amenities.createOrEdit'); // Show Create Form
    Route::post('amenities/{id?}', [AmentitiesController::class, 'createOrUpdate'])->name('admin.amenities.createOrUpdate'); // Create or Update
    Route::get('amenities-list', [AmentitiesController::class, 'show'])->name('admin.amenities-list'); // List View
    Route::get('admin/amenities-types', [AmentitiesController::class, 'getAmenitiesTypes'])->name('admin.amenities-types'); // AJAX List
    Route::get('amenities/{id}/edit', [AmentitiesController::class, 'createOrEdit'])->name('admin.amenities.edit'); // Edit Page
    Route::delete('amenities/{id}', [AmentitiesController::class, 'destroy'])->name('admin.amenities.delete'); // Delete


    //hotels
    Route::get('hotel-list', [HotelController::class, 'show'])->name('admin.hotel-list'); // 
    Route::get('get-hotel', [HotelController::class, 'getHotel'])->name('admin.getHotel');  
    Route::get('/hotels/details/{id}', [HotelController::class, 'showDetails'])->name('admin.details');
    Route::post('update-hotel-status', [HotelController::class, 'updateStatus'])->name('admin.updateHotelStatus');




});





// Hotel Owner Route
Route::middleware(['auth', 'role:hotel_owner'])->prefix('owner')->group(function () {
    Route::get('dashboard', [HotelDashboardController::class, 'index'])->name('owner.dashboard');
    Route::get('profile', [HotelDashboardController::class, 'profile'])->name('owner.profile');
    Route::post('profile/update', [HotelDashboardController::class, 'updateProfile'])->name('owner.updateProfile');

    // hotel booking
    Route::get('hotels/{id?}', [HotelsController::class, 'createOrEdit'])->name('owner.createOrEdit');
    Route::post('hotels/{id?}', [HotelsController::class, 'createOrUpdate'])->name('owner.createOrUpdate');
    Route::get('hotels-list', [HotelsController::class, 'index'])->name('owner.index');
    Route::get('get-hotels', [HotelsController::class, 'getHotels'])->name('owner.getHotels');  
    Route::delete('hotel/{id}', [HotelsController::class, 'destroy'])->name('owner.delete'); 
    Route::get('/owner/hotel/{id}', [HotelsController::class, 'show'])->name('owner.hotel.show');
    Route::get('hotels/{id}/all-rooms' , [HotelsController::class,'allRooms'])->name('hotel.allRooms');
    Route::get('/hotel/room-types', [HotelsController::class, 'getRoomTypes'])->name('hotel.roomTypes');
    Route::get('/hotel/filter', [HotelsController::class, 'filterRooms'])->name('hotel.filter');
    Route::get('/hotel/room-statuses', [HotelsController::class, 'getRoomStatuses'])->name('hotel.roomStatuses');
    Route::get('/hotel/ac-options', [HotelsController::class, 'getAcOptions'])->name('hotel.acOptions');

    
    //Rooms 
    Route::get('/rooms', [RoomsController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/data', [RoomsController::class, 'getRooms'])->name('rooms.data');
    Route::get('/room/create-or-edit/{id?}', [RoomsController::class, 'createOrEdit'])->name('room.createOrEdit');
    Route::post('/room/store-or-update/{id?}', [RoomsController::class, 'createOrUpdate'])->name('room.createOrUpdate');
    Route::get('/room/details/{id}', [RoomsController::class, 'showDetails'])->name('room.details');
    Route::delete('/room/delete/{id}', [RoomsController::class, 'destroy'])->name('room.destroy');

    //booking
    Route::get('/bookings', [HotelBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/data', [HotelBookingController::class, 'getBookings'])->name('bookings.data');
    Route::get('/bookings/details', [HotelBookingController::class, 'bookingDetails'])->name('bookings.details');


    // payment 
    Route::get('/payment', [HotelPaymentController::class, 'showPayment'])->name('payment.showPayment');
    Route::get('/payments', [HotelPaymentController::class, 'getPayments'])->name('payments.list');

    //  rate 
    Route::get('/rate', [RateController::class, 'showRate'])->name('rate.showRate');
    Route::get('/reviews', [RateController::class, 'getReviews'])->name('reviews.list');



});



// Customer Routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('/proile', [CustomerDashboardController::class, 'profile'])->name('customer.profile');
    Route::post('/proffile/update', [CustomerDashboardController::class, 'updateProfile'])->name('customer.updateProfile');
    Route::get('/password', [CustomerDashboardController::class, 'password'])->name('customer.password');
    Route::post('/change-password', [CustomerDashboardController::class, 'changePassword'])->name('customer.change-password');

    // customer bookingh
    Route::get('/booking' ,[BookingController::class ,'index'])->name('customer.booking');
    Route::post('/book-room', [BookingController::class, 'store'])->name('book.room');
    Route::post('/calculate-price', [BookingController::class, 'calculatePrice'])->name('calculate.price');
    Route::post('/check-room-availability', [BookingController::class, 'checkRoomAvailability'])->name('check.room.availability');
    Route::get('/booking/details/{id}', [BookingController::class, 'show'])->name('booking.details');
    Route::post('/cancel-booking', [BookingController::class, 'cancelBooking'])->name('cancel-booking');


    // payments
    Route::get('payment/{bookingId}' ,[PaymentController::class,'index'])->name('customer.payment');
    Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('/paypal/payment/{booking_id}', [PaymentController::class, 'paypalPayment'])->name('paypal.payment');
    Route::get('/paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.payment.success');
    Route::get('/paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.payment.cancel');
    Route::get('/booking-confirmation', [PaymentController::class, 'confirmation'])->name('booking.confirmation');
    Route::get('/booking/invoice/{id}', [InvoiceController::class, 'generateInvoice'])->name('booking.invoice');
    Route::post('/booking/confirm/{id}', [InvoiceController::class, 'confirmBooking'])->name('booking.confirm');




});