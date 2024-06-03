<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenggunaanBahanBaku;
use App\Models\DetailTransaksi;
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

    public function monthlySalesProductReport(Request $request)
{
    try {
        $month = $request->query('month');
        $year = $request->query('year');
        
        $products = DetailTransaksi::with('produk')
            ->whereHas('transaksi', function ($query) use ($month, $year) {
                $query->where('status_transaksi', 'Completed')
                    ->whereMonth('tanggal_nota_dibuat',$month)
                    ->whereYear('tanggal_nota_dibuat',$year);
            })
            ->get()
            ->map(function ($products) {
                $qty = $products->jumlah_item;
                $price = $products->harga_satuan;
                $total = $qty * $price;
                return [
                    'product_name' => $products->produk->nama_produk,
                    'qty' => $qty,
                    'price' => $price,
                    'total' => $total
                ];
            });
        
        $grandTotal = $products->sum('total');
        
        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved product sales report',
            'data' => $products,
            'grand_total' => $grandTotal
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to retrieve sales data',
            'error' => $e->getMessage(),
            'data' => null
        ], 500);
    }
}


}
