<?php

namespace App\Http\Controllers;

use App\Models\Propertie;
use App\Models\Reservation;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class ReservationController extends Controller
{

    public function index()
    {
        //
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
        // dd($request);
        request()->validate([
            'propertie_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'travelers' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);
        Reservation::create([
            'propertie_id' => $request->propertie_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'travelers' => $request->travelers,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ]);

        Stripe::setApiKey(config('stripe.sk'));

        $event = Propertie::where('id', $request->propertie_id)->first();

        // dd($event);
        $startDate = Carbon::parse($request->startDate);
        $endDate = Carbon::parse($request->endDate);
        // dd($endDate.date('Y-m-d'));
        $days = $startDate->diffInDays($endDate);
        $amount = $event->price_per_night . "00";
        // dd($amount);
        $session = Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            "name" => "VacaRental",
                            "description" => "Thank you"
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' => $days,
                ],

            ],
            'mode' => 'payment', // the mode of payment
            'success_url' => route('success'), // route when success 
            'cancel_url' => route('home'), // route when failed or canceled
        ]);

        return redirect()->away($session->url);
    }

    public function show($propertie)
    {
        //
        // dd($propertie);
        $reservations = Reservation::where('propertie_id', $propertie)->get();
        $events = $reservations->map(function (Reservation $event) {
            $start = $event->startDate;
            $end = $event->endDate;
            // $startDateTime = new DateTime($event->startDate);
            // $endDateTime = new DateTime($event->endDate);
            // $start = $startDateTime->format('Y-m-d');
            // $end = $endDateTime->format('Y-m-d');
            return [
                'start' => $start,
                'end' => $end,
                'allday' => true,
                'title' => 'reserved'
            ];
        });
        return response()->json([
            "events" => $events
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
