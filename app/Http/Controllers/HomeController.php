<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Charts\TotalSaleChart;
use App\Charts\PaymentMethodChart;
use App\Order;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('checkRole');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        for ($i=1; $i <= 7 ; $i++) { 

         $date[] = Carbon::now()->subDays(7-$i)->format('Y-m-d');
         $sale[] = Order::whereDate('created_at', Carbon::now()->subDays(7-$i)->format('Y-m-d'))->sum('total');

        }

        $cod    = Order::where('payment_status', 1)->count();
        $stripe = Order::where('payment_status', 2)->count();
        $paypal = Order::where('payment_status', 3)->count();
        // Chart Starts Here

        $sevenDaysSaleChart = new TotalSaleChart;
        $sevenDaysSaleChart->labels($date);
        $sevenDaysSaleChart->dataset('Sale Amount', 'bar',$sale)->options([
            'backgroundColor' => [
                'red',
                'green',
                'black',
                'yellow',
                'brown',
                'beige',
                'blue',
            ],
        ]);

        $paymentMethodChart = new PaymentMethodChart;
        $paymentMethodChart->labels(['Cash on delivery', 'Card Payment', 'PayPal']);
        $paymentMethodChart->dataset('Payment Type', 'doughnut',[$cod, $stripe, $paypal])->options([
            'backgroundColor' => [
                'red',
                'blue',
                '#44CB8C',
            ],
        ]);
        // $sevenDaysSaleChart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);

        // Chart Ends Here

        User::all()->except(Auth::id());
        $logged = Auth::id();
        $users = User::where('id', '!=', $logged)->orderBy('id', 'desc')->get();
        $total_users = User::count();
        return view('home', compact('users', 'total_users','sevenDaysSaleChart', 'paymentMethodChart'));
    }
}
