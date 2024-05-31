<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pembayaran;
use App\Models\PengeluaranLainLain;
use Illuminate\Http\Request;
use App\Models\PenggunaanBahanBaku;
use App\Models\Pengiriman;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function ingredientsUsageReport(Request $request)
    {
        $startDate = $request->query('start-date');
        $endDate = $request->query('end-date');

        $ingredients = PenggunaanBahanBaku::get()->whereBetween('tanggal_penggunaan', [$startDate, $endDate]);
        $groupedRecipes = $ingredients->groupBy('id_bahan_baku')->map(function ($items) {
            return [
                'id_penggunaan_bahan_baku' => $items[0]->id_penggunaan_bahan_baku,
                'tanggal_penggunaan' => $items[0]->tanggal_penggunaan,
                'jumlah_penggunaan' => $items->sum('jumlah_penggunaan'),
                'bahan_baku' => $items[0]->bahanBaku
            ];
        })->values();


        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved ingredients usage report',
            'data' => ['usage' => $groupedRecipes]
        ]);
    }

    public function salesReport(Request $request)
    {
        $year = $request->query('year');

        $salesReport = [];

        for ($month = 1; $month <= 12; $month++) {
            $transactions = Transaksi::whereYear('tanggal_nota_dibuat', $year)
                ->whereMonth('tanggal_nota_dibuat', $month)
                ->where('status_transaksi', 'Completed')
                ->get();

            $transactionCount = $transactions->count();
            $totalSales = $transactions->sum('pembayaran.total_pembayaran');

            $salesReport[] = [
                'month' => $month,
                'transaction_count' => $transactionCount,
                'total_sales' => $totalSales
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved sales report',
            'data' => ['sales' => $salesReport]
        ]);
    }

    public function attendanceReport(Request $request)
    {
        $year = $request->query('year');

        $attendanceReport = [];

        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved attendance report',
            'data' => $attendanceReport
        ]);
    }

    public function expensesincomeReport(Request $request)
    {
        $year = $request->query('year');
        $month = $request->query('month');

        $transactions = Transaksi::whereYear('tanggal_nota_dibuat', $year)
            ->whereMonth('tanggal_nota_dibuat', $month)
            ->where('status_transaksi', 'Completed')
            ->get()->load('pembayaran', 'pengiriman');

        if ($transactions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No transactions found',
                'data' => ['report' => []],
            ]);
        }

        $pembayaran = $transactions->map(function ($transaction) {
            return $transaction->pembayaran;
        });

        $delivery = $transactions->map(function ($transaction) {
            return $transaction->pengiriman;
        });

        $otherExpenses = PengeluaranLainLain::whereYear('tanggal_pengeluaran', $year)
            ->whereMonth('tanggal_pengeluaran', $month)
            ->select('nama_pengeluaran', 'total_pengeluaran')
            ->get();

        $totalSales = $transactions->sum('total');
        $totalDelivery = $delivery->sum('biaya_pengiriman');
        $totalSales = $totalSales - $totalDelivery; // total sales minus delivery fee
        $totalTips = $pembayaran->sum('tip');

        $report =
            [
                [
                    'type' => 'Penjualan',
                    'income' => $totalSales,
                    'expenses' => 0,
                ],
                [
                    'type' => 'Tips',
                    'income' => $totalTips,
                    'expenses' => 0,
                ],
                [
                    'type' => 'Pengiriman',
                    'income' => $totalDelivery,
                    'expenses' => 0,
                ],
            ];

        foreach ($otherExpenses as $expense) {
            $report[] = [
                'type' => $expense->nama_pengeluaran,
                'income' => 0,
                'expenses' => $expense->total_pengeluaran,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved expenses and income report',
            'data' => ['report' => $report],
        ]);
    }
}
