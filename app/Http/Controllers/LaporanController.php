<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pembayaran;
use App\Models\PengeluaranLainLain;
use Illuminate\Http\Request;
use App\Models\PenggunaanBahanBaku;
use App\Models\Pengiriman;
use App\Models\Penitip;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
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
        $totalSales = $totalSales - $totalDelivery;
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

        if (!$otherExpenses->isEmpty()) {
            foreach ($otherExpenses as $expense) {
                $report[] = [
                    'type' => $expense->nama_pengeluaran,
                    'income' => 0,
                    'expenses' => $expense->total_pengeluaran,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved expenses and income report',
            'data' => [
                'report' => $report,
            ],
        ]);
    }

    public function partnerTransactionReport(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $query = Penitip::join('produk', 'penitip.id_penitip', '=', 'produk.id_penitip')
            ->join('detail_transaksi', 'detail_transaksi.id_produk', '=', 'produk.id_produk')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->where('transaksi.status_transaksi', 'Completed')
            ->whereYear('transaksi.tanggal_nota_dibuat', $year)
            ->whereMonth('transaksi.tanggal_nota_dibuat', $month)
            ->select('penitip.nama_penitip', 'produk.nama_produk', 'produk.harga', 'penitip.id_penitip')
            ->get();

        $grouped = $query->groupBy(['nama_penitip', 'nama_produk',]);

        $report = $grouped->map(function ($items, $nama_penitip) {
            return [
                'nama_penitip' => $nama_penitip,
                'id_penitip' => $items->first()->first()->id_penitip,
                'products' => $items->map(function ($items, $nama_produk) {
                    return [
                        'nama_produk' => $nama_produk,
                        'harga' => $items->first()->harga,
                        'sold' => $items->count(),
                    ];
                })->values(),
            ];
        })->values();

        // $transactions = DetailTransaksi::whereHas('transaksi', function($query) use ($year, $month) {
        //         $query->whereYear('tanggal_nota_dibuat', $year)
        //             ->whereMonth('tanggal_nota_dibuat', $month);
        //     })
        //     ->whereHas('produk', function($query) {
        //         $query->whereNotNull('id_penitip');
        //     })
        //     ->with(['produk', 'produk.penitip']) 
        //     ->get();

        // $report = [];

        // foreach ($transactions as $transaction) {
        //     $partnerId = $transaction->produk->penitip->id_penitip;

        //     if (!isset($report[$partnerId])) {
        //         $report[$partnerId] = [
        //             'Partner' => [
        //                 'id_penitip' => $partnerId,
        //                 'nama_penitip' => $transaction->produk->penitip->nama_penitip,
        //                 'Products' => []
        //             ],
        //         ];
        //     }

        //     $productName = $transaction->produk->nama_produk;

        //     if (!isset($report[$partnerId]['Partner']['Products'][$productName])) {
        //         $report[$partnerId]['Partner']['Products'][$productName] = [
        //             'nama_produk' => $productName,
        //             'qty' => $transaction->jumlah_item,
        //             'harga_satuan' => $transaction->harga_satuan,
        //             'total' => $transaction->jumlah_item * $transaction->harga_satuan,
        //             'komisi' => ($transaction->jumlah_item * $transaction->harga_satuan) * 0.20,
        //             'diterima' => ($transaction->jumlah_item * $transaction->harga_satuan) * 0.80,
        //         ];
        //     } else {
        //         $report[$partnerId]['Partner']['Products'][$productName]['qty'] += $transaction->jumlah_item;
        //         $report[$partnerId]['Partner']['Products'][$productName]['total'] += $transaction->jumlah_item * $transaction->harga_satuan;
        //         $report[$partnerId]['Partner']['Products'][$productName]['komisi'] += ($transaction->jumlah_item * $transaction->harga_satuan) * 0.20;
        //         $report[$partnerId]['Partner']['Products'][$productName]['diterima'] += ($transaction->jumlah_item * $transaction->harga_satuan) * 0.80;
        //     }
        // }

        return response()->json([
            'success' => true,
            'message' => 'Monthly transaction report generated successfully',
            'data' => [
                'Report' => $report,
            ],
        ]);
    }
}
