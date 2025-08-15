<?php
namespace App\Helpers;

use App\Models\Room;
use Carbon\Carbon;

class PriceHelper
{
    public static function calculateTotalPrice($roomId, $checkinDate, $checkoutDate, $guests, $rooms)
    {
        $room = Room::find($roomId);
        if (!$room) {
            return ['error' => 'Room not found'];
        }
    
        $nights = Carbon::parse($checkinDate)->diffInDays(Carbon::parse($checkoutDate));
        if ($nights <= 0) {
            return ['error' => 'Invalid date selection'];
        }
    
        // Adjust hotel charges based on the number of rooms
        $hotelCharges = $room->price * $nights * $rooms;
        $discount = $hotelCharges * 0.05; // Example: 5% discount
        $subTotal = $hotelCharges - $discount;
        $taxes = $subTotal * 0.18; // 18% GST
        $serviceCharge = 569 * $rooms;
        $totalPrice = $subTotal + $taxes + $serviceCharge;
    
        return [
            'hotel_charges' => $hotelCharges,
            'discount' => $discount,
            'sub_total' => $subTotal,
            'taxes' => $taxes,
            'service_charge' => $serviceCharge,
            'total_price' => $totalPrice
        ];
    }
    
}
