<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pembayaran;
use App\Models\PengeluaranLainLain;
use Illuminate\Http\Request;
use App\Models\PenggunaanBahanBaku;
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

        $incomeReport = [];
        $expensesReport = [];

        $months = $month ? [$month] : range(1, 12);

        foreach ($months as $month) {
            $transactions = Transaksi::whereYear('tanggal_nota_dibuat', $year)
                ->whereMonth('tanggal_nota_dibuat', $month)
                ->where('status_transaksi', 'Completed')
                ->get();

            $tips = Pembayaran::whereYear('tanggal_pembayaran_valid', $year)
                ->whereMonth('tanggal_pembayaran_valid', $month)
                ->get();

            $otherExpenses = PengeluaranLainLain::whereYear('tanggal_pengeluaran', $year)
                ->whereMonth('tanggal_pengeluaran', $month)
                ->select('nama_pengeluaran', 'total_pengeluaran')
                ->get();

            $totalSales = $transactions->sum('total');
            $totalTips = $tips->sum('tip');

            $incomeReport[] = [
                'total_sales' => $totalSales,
                'tips' => $totalTips,
            ];

            foreach ($otherExpenses as $expense) {
                $expensesReport[] = [
                    'nama_pengeluaran' => $expense->nama_pengeluaran,
                    'total_expenses' => $expense->total_pengeluaran,
                ];
            }
        }

        $incomeExpense = [
            'year' => $year,
            'month' => $month,
            'income' => $incomeReport,
            'expenses' => $expensesReport,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved expenses and income report',
            'data' => ['IncomeExpense' => $incomeExpense],
        ]);
    }

}
