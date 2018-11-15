<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Trade;
use Dirape\Token\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index', [
            'successful_trades_data' => $this->successfulTradesData(),
            'successful_trades_count' => $this->countSuccessfulTrades(),
        ]);
    }


    protected function successfulTradesData()
    {
        $total = collect([]);
        $month = collect([]);

        $model = DB::table('trades')->where('status', 'successful')
            ->whereYear('created_at', now()->year)
            ->where(function ($query) {
                $query->where('partner_id', Auth::id());
                $query->orWhere('user_id', Auth::id());
            });

        for ($i = 1; $i <= 12; $i++) {

            $date = \DateTime::createFromFormat(
                '!m', $i
            );

            $month->put($i, $date->format('F'));

            $record = clone $model;

            $total->put($i, $record->whereMonth(
                'created_at', $i
            )->count());
        }

        return [
            'total' => $total->values()->toArray(),
            'month' => $month->values()->toArray()
        ];
    }

    /**
     * @return int
     */
    protected function countSuccessfulTrades()
    {
        return DB::table('trades')
            ->where('status', 'successful')
            ->count();
    }
}
