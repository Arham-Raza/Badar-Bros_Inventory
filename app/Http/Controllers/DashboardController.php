<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Product;
use App\Models\PurchaseMaster;
use App\Models\SalesMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:dashboard-list', ['only' => ['index']]);
    }

    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;

        $totalMonthSales = SalesMaster::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $totalMonthPurchases = PurchaseMaster::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $totalMonthReceipts = Transaction::where('type', 'receipt')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('amount');

        $totalMonthPayments = Transaction::where('type', 'payment')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('amount');

        $totalSales = SalesMaster::count();
        $totalPurchases = PurchaseMaster::count();
        $totalReceipts = Transaction::where('type', 'receipt')->sum('amount');
        $totalPayments = Transaction::where('type', 'payment')->sum('amount');

        $firstSale = SalesMaster::orderBy('created_at', 'asc')->first();
        $firstPurchase = PurchaseMaster::orderBy('created_at', 'asc')->first();
        $firstReceipt = Transaction::where('type', 'receipt')->orderBy('created_at', 'asc')->first();
        $firstPayment = Transaction::where('type', 'payment')->orderBy('created_at', 'asc')->first();
        $monthsCount = 1; // fallback
        if ($firstSale || $firstPurchase || $firstReceipt || $firstPayment) {
            $saleMonthsCount = Carbon::now()->diffInMonths(Carbon::parse($firstSale->created_at)) + 1;
            $purchaseMonthsCount = Carbon::now()->diffInMonths(Carbon::parse($firstPurchase->created_at)) + 1;
            $receiptMonthsCount = Carbon::now()->diffInMonths(Carbon::parse($firstReceipt->created_at)) + 1;
            $paymentMonthsCount = Carbon::now()->diffInMonths(Carbon::parse($firstPayment->created_at)) + 1;
        }

        // Average sales per month
        $averageMonthlySales = $monthsCount > 0 ? ($totalSales / $monthsCount) : 0;

        // dd($averageMonthlySales);

        // Percentage of current month vs average
        $salesPercentage = $averageMonthlySales > 0
            ? round(($totalMonthSales / $averageMonthlySales) * 100, 2)
            : 0;

        // Average sales per month
        $averageMonthlyPurchase = $monthsCount > 0 ? ($totalPurchases / $monthsCount) : 0;

        // Percentage of current month vs average
        $purchasessPercentage = $averageMonthlyPurchase > 0
            ? round(($totalMonthPurchases / $averageMonthlyPurchase) * 100, 2)
            : 0;

        // Average sales per month
        $averageMonthlyReceipts = $monthsCount > 0 ? ($totalReceipts / $monthsCount) : 0;

        // Percentage of current month vs average
        $receiptsPercentage = $averageMonthlyReceipts > 0
            ? round(($totalMonthReceipts / $averageMonthlyReceipts) * 100, 2)
            : 0;

        // Average sales per month
        $averageMonthlyPayments = $monthsCount > 0 ? ($totalPayments / $monthsCount) : 0;

        // Percentage of current month vs average
        $paymentsPercentage = $averageMonthlyPayments > 0
            ? round(($totalMonthPayments / $averageMonthlyPayments) * 100, 2)
            : 0;
        $sales = SalesMaster::with('receipts')->get();
        $purchases = PurchaseMaster::with('payments')->get();
        $salesData = [
            'labels' => [],
            'paid'   => [],
            'due'    => []
        ];

        $salesByDay = $sales
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->groupBy(function ($sale) {
                return $sale->created_at->format('d'); // group by day of month
            });

        foreach (range(1, now()->daysInMonth) as $day) {
            $dayStr = str_pad($day, 2, '0', STR_PAD_LEFT);

            $daySales = $salesByDay->get($dayStr, collect());

            $paid = $daySales->sum(fn($sale) => $sale->receipts->sum('amount'));
            $total = $daySales->sum('net_amount');
            $due  = $total - $paid;

            $salesData['labels'][] = $dayStr;
            $salesData['paid'][]   = $paid;
            $salesData['due'][]    = $due;
        }

        // --- Purchases ---
        $purchaseData = [
            'labels' => [],
            'paid'   => [],
            'due'    => []
        ];

        $purchasesByDay = $purchases
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->groupBy(function ($purchase) {
                return $purchase->created_at->format('d'); // group by day
            });

        foreach (range(1, now()->daysInMonth) as $day) {
            $dayStr = str_pad($day, 2, '0', STR_PAD_LEFT);

            $dayPurchases = $purchasesByDay->get($dayStr, collect());

            $paid = $dayPurchases->sum(fn($p) => $p->payments->sum('amount'));
            $total = $dayPurchases->sum('net_amount');
            $due  = $total - $paid;

            $purchaseData['labels'][] = $dayStr;
            $purchaseData['paid'][]   = $paid;
            $purchaseData['due'][]    = $due;
        }


        return view('dashboard', compact('salesData', 'purchaseData', 'totalMonthSales', 'totalMonthPurchases', 'totalMonthReceipts', 'totalMonthPayments', 'averageMonthlySales', 'averageMonthlyPurchase', 'averageMonthlyPayments', 'averageMonthlyReceipts','totalSales', 'totalPurchases', 'totalReceipts', 'totalPayments', 'salesPercentage', 'purchasessPercentage', 'receiptsPercentage', 'paymentsPercentage'));
    }
}
