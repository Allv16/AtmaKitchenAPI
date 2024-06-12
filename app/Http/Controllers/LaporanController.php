<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pembayaran;
use App\Models\pembelianBahanBaku;
use App\Models\PengeluaranLainLain;
use Illuminate\Http\Request;
use App\Models\PenggunaanBahanBaku;
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
            $totalSales = $transactions->sum('total');

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
        $month = $request->query('month');

        $countDays = Carbon::createFromDate($year, $month)->daysInMonth;

        $presensi = Karyawan::with(['presensiKaryawan' => function ($query) use ($year, $month) {
            $query->whereYear('tanggal_absen', $year)
                ->whereMonth('tanggal_absen', $month);
        }])->get();

        $presensi = $presensi->map(function ($karyawan) use ($countDays) {
            $presensiKaryawan = $karyawan->presensiKaryawan;
            $totalAbsent = $presensiKaryawan->count();
            $totalPresent = $countDays - $totalAbsent;
            $bonus = 0;
            if ($totalAbsent < 5) {
                $bonus = $karyawan->bonus_gaji_karyawan;
            }

            return [
                'id_karyawan' => $karyawan->id_karyawan,
                'nama_karyawan' => $karyawan->nama_karyawan,
                'total_present' => $totalPresent,
                'total_absent' => $totalAbsent,
                'honor' => $karyawan->gaji_karyawan * $totalPresent,
                'bonus' => $bonus,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved attendance report',
            'data' => $presensi
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

        // Gaji

        $presensi = Karyawan::with(['presensiKaryawan' => function ($query) use ($year, $month) {
            $query->whereYear('tanggal_absen', $year)
                ->whereMonth('tanggal_absen', $month);
        }])->get();

        $countDays = Carbon::createFromDate($year, $month)->daysInMonth;

        $sumSalary = $presensi->map(function ($karyawan) use ($countDays) {
            $presensiKaryawan = $karyawan->presensiKaryawan;
            $totalAbsent = $presensiKaryawan->count();
            $totalPresent = $countDays - $totalAbsent;
            $bonus = 0;
            if ($totalAbsent < 5) {
                $bonus = $karyawan->bonus_gaji_karyawan;
            }

            return $karyawan->gaji_karyawan * $totalPresent + $bonus;
        });

        // Pembelian Bahan Baku
        $ingredientsPurchases =  pembelianBahanBaku::whereYear('tanggal_pembelian', $year)
            ->whereMonth('tanggal_pembelian', $month)
            ->get()
            ->sum(function ($purchase) {
                return $purchase->jumlah_pembelian * $purchase->harga_beli;
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
                [
                    'type' => 'Gaji Karyawan',
                    'income' => 0,
                    'expenses' => $sumSalary->sum(),
                ],
                [
                    'type' => 'Pembelian Bahan Baku',
                    'income' => 0,
                    'expenses' => $ingredientsPurchases,
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


        return response()->json([
            'success' => true,
            'message' => 'Monthly transaction report generated successfully',
            'data' => [
                'Report' => $report,
            ],
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
                        ->whereMonth('tanggal_nota_dibuat', $month)
                        ->whereYear('tanggal_nota_dibuat', $year);
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
