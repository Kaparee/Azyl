<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithWebOrJson;
use App\Http\Requests\StoreDonationRequest;
use App\Models\Donation;
use App\Models\Fundraiser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    use RespondsWithWebOrJson;

    public function store(StoreDonationRequest $request)
    {
        $userId = (Auth::check() && ! $request->has('anonymous')) ? Auth::id() : null;

        $donation = DB::transaction(function () use ($request, $userId) {
            $newDonation = Donation::create([
                'fundraiser_id' => $request->fundraiser_id,
                'user_id' => $userId,
                'amount' => $request->amount,
            ]);

            $fundraiser = Fundraiser::findOrFail($request->fundraiser_id);

            $fundraiser->increment('collected_amount', $request->amount);

            return $newDonation;
        });

        return $this->jsonOrRedirect(
            $request,
            'Dziękujemy! Wpłata została zaksięgowana.',
            ['donation' => $donation],
            201,
            null,
            'success',
        );
    }
}
