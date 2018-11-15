<?php

namespace App\Http\Controllers\Marketplace;

use App\Models\Offer;
use App\Models\PaymentMethodCategory;
use Dirape\Token\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateOfferController extends Controller
{
    public function buyIndex()
    {
        return view('marketplace.create_offer.buy', [
            'payment_methods' => $this->getPaymentMethods()
        ]);

    }

    public function sellIndex()
    {
        return view('marketplace.create_offer.sell', [
            'payment_methods' => $this->getPaymentMethods()
        ]);
    }

    /**
     * Store offer
     *
     * @param Request $request
     * @param $type
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $type)
    {
        $coins = array_keys(get_coins());
        $payment_methods = collect($this->getPaymentMethods())->flatten();
        $currency = array_keys(get_iso_currencies());

        if (in_array($type, ['buy', 'sell'])) {
            $user = Auth::user();

            $this->validate($request, [
                // Select Boxes
                'coin' => ['required', Rule::in($coins)],
                'payment_method' => ['required', Rule::in($payment_methods)],
                'currency' => ['required', Rule::in($currency)],

                // Multiselect
                'tags' => 'required|array|max:3',

                // Text & Textarea
                'label' => 'required|string|max:25',
                'terms' => 'required|string',
                'trade_instruction' => 'required|string',

                // Numbers
                'min_amount' => 'required|numeric|min:0',
                'max_amount' => 'required|numeric|min:0|gte:min_amount',
                'deadline' => 'required|numeric|min:0',
                'profit_margin' => 'required|numeric',
            ]);

            try{
                $offer = new Offer();

                $offer->fill($request->only([
                    'coin', 'payment_method', 'currency', 'label', 'trade_instruction',
                    'profit_margin', 'tags', 'min_amount', 'max_amount', 'deadline', 'terms',
                ]));

                $offer->fill([
                    'trusted_offer' => $request->filled('trusted_offer'),
                    'phone_verification' => $request->filled('phone_verification'),
                    'email_verification' => $request->filled('email_verification'),
                    'type' => $type,
                ]);

                if(!$offer->token){
                    $offer->setToken();
                }
            }catch(\Exception $e){
                return error_response($request, $e->getMessage());
            }

            $user->offers()->save($offer);

            toastr()->success(__('Your offer has been created!'));

            return redirect()->route('home.index');

        } else {
            return abort(404);
        }
    }

    public function getPaymentMethods()
    {
        $categories = PaymentMethodCategory::all();

        $payment_methods = array();

        foreach ($categories as $category) {
            $payment_methods[$category->name] = $category->payment_methods()
                ->get()->pluck('name', 'name');
        }

        return $payment_methods;
    }
}
