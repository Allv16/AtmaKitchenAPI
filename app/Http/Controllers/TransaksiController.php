<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Validator;
use App\Models\Pembayaran;
use App\Models\Keranjang;
use App\Models\Pengiriman;
use App\Models\DetailTransaksi;
use Carbon\Carbon;


class TransaksiController extends Controller
{
    public function getAllTransactionByIdCustomer($id_customer)
    {
        try {
            $transaksi = Transaksi::where('id_customer', $id_customer)->orderBy('tanggal_nota_dibuat', 'desc')->get();
            return response()->json([
                'success' => true,
                'message' => 'Transaction Successfully Retrieved',
                'data' => ['transaksi' => $transaksi->load(['detailTransaksi.produk', 'pembayaran'])]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive transaction',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getHistoryTransactionByIdCustomer($id_customer)
    {
        try {
            $transaksi = Transaksi::where('id_customer', $id_customer)->where(function ($query) {
                $query->where('status_transaksi', 'Selesai')->orWhere('status_transaksi', 'Ditolak');
            })->get()->load('detailTransaksi.produk');
            return response()->json([
                'success' => true,
                'message' => 'Transaction Successfully Retrieved',
                'data' => $transaksi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive transaction',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    private function generateInvoiceNumber()
    {
        // Get the current year and month
        $year = date('y');
        $month = date('m');

        $lastTransaction = Transaksi::where('id_transaksi', 'like', $year . '.' . $month . '%')->orderBy('id_transaksi', 'desc')->first();
        $lastIncrement = '001';
        if ($lastTransaction) {
            $lastIncrement = substr($lastTransaction->id_transaksi, -3);
            $newIncrement = str_pad((int) $lastIncrement + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // If there are no transactions yet, start with 001
            $newIncrement = '001';
        }



        // Combine the year, month, and incremented number
        $newId = $year . '.' . $month . '.' . $newIncrement;

        return $newId;
    }

    private function getTotalPoints($total, $isBirthday = false)
    {
        $points = 0;

        if ($total >= 1000000) {
            $multiple = floor($total / 1000000);
            $points += $multiple * 200;
            $total -= $multiple * 1000000;
        }

        if ($total >= 500000) {
            $multiple = floor($total / 500000);
            $points += $multiple * 75;
            $total -= $multiple * 500000;
        }

        if ($total >= 100000) {
            $multiple = floor($total / 100000);
            $points += $multiple * 15;
            $total -= $multiple * 100000;
        }

        if ($total >= 10000) {
            $multiple = floor($total / 10000);
            $points += $multiple;
            $total -= $multiple * 10000;
        }

        if ($isBirthday) {
            $points *= 2;
        }

        return $points;
    }

    private function isBirthDay($birthDayDate)
    {
        // Parse the provided date
        $providedDate = Carbon::parse($birthDayDate);

        // Get today's date
        $today = Carbon::today();

        // Extract month and day for comparison
        $providedMonthDay = Carbon::createFromDate($today->year, $providedDate->month, $providedDate->day);
        $startMonthDay = $today->copy()->subDays(3);
        $endMonthDay = $today->copy()->addDays(3);

        // Check if the provided month and day is within the range
        return $providedMonthDay->between($startMonthDay, $endMonthDay);
    }

    private function countDiscount($points)
    {
        return 100 * $points;
    }


    public function addTransaction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tanggal_keranjang' => 'required',
            'tanggal_ambil' => 'required',
            'poin_digunakan' => 'required',
            'jenis_pengiriman' => 'required | in:Pickup,Delivery',
            'id_customer' => 'required',
            'jenis_pembayaran' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        }
        try {
            $pembayaran = Pembayaran::create([
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'total_pembayaran' => 0,
                'tip' => 0,
                'id_customer' => $request->id_customer,
            ]);
            $id = $this->generateInvoiceNumber();
            $birthday = Customer::find($request->id_customer)->tanggal_lahir;

            $transaksi = Transaksi::create([
                'id_transaksi' => $id,
                'tanggal_nota_dibuat' => date('Y-m-d H:i:s'),
                'tanggal_ambil' => $request->tanggal_ambil,
                'poin_digunakan' => $request->poin_digunakan,
                'poin_diperoleh' => 0,
                'jenis_pengiriman' => $request->jenis_pengiriman,
                'id_customer' => $request->id_customer,
                'id_pembayaran' => $pembayaran->id_pembayaran,
                'total' => 0,
                'status_transaksi' => 'Unpaid'
            ]);

            $pembayaran->save();
            $transaksi->save();

            if ($transaksi->jenis_pengiriman == 'Delivery') {
                $pengiriman = Pengiriman::create([
                    'kurir' => 'Andi',
                    'alamat_tujuan' => 'Jl. Raya Kuta No. 1',
                    'id_transaksi' => $transaksi->id_transaksi
                ]);
                $pengiriman->save();
                $transaksi->status_transaksi = 'Inputing Range';
                $transaksi->save();
            }

            $keranjang = Keranjang::where('id_customer', $request->id_customer)
                ->whereDate('tanggal_keranjang', $request->tanggal_keranjang)
                ->get();

            $total = 0;
            foreach ($keranjang as $item) {
                $detailTransaksi = DetailTransaksi::Create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'harga_satuan' => $item->produk->harga,
                    'jumlah_item' => $item->jumlah_item_keranjang,
                    'id_produk' => $item->id_produk
                ]);
                $detailTransaksi->save();
                $total += $item->produk->harga * $item->jumlah_item_keranjang;
                $item->delete();
            }

            $transaksi->total = $total;
            $transaksi->poin_diperoleh = $this->getTotalPoints($total, $this->isBirthDay($birthday));
            $transaksi->save();

            return response()->json([
                'success' => true,
                'message' => 'Transaction Successfully Added',
                'data' => ['transaksi' => $transaksi->load(['detailTransaksi.produk', 'pembayaran'])]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add transaction',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getTransactionForAdminToDo()
    {
        try {
            $transaksi = Transaksi::where('status_transaksi', 'Inputing Range')
                ->orWhere('status_transaksi', 'Paid')
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Transaction Successfully Retrieved',
                'data' => ['transaksi' => $transaksi->load(['detailTransaksi.produk', 'pembayaran', 'customer', 'pengiriman'])]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive transaction',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function updateDeliveryRange(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jarak_pengiriman' => 'required',
            'biaya_pengiriman' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $transaksi = Transaksi::find($id);

            $pengiriman = $transaksi->pengiriman;
            $pengiriman->jarak_pengiriman = $request->jarak_pengiriman;
            $pengiriman->biaya_pengiriman = $request->biaya_pengiriman;
            $pengiriman->save();

            $transaksi->status_transaksi = 'Unpaid';
            $transaksi->total += $request->biaya_pengiriman;
            $transaksi->save();

            return response()->json([
                'success' => true,
                'message' => 'Delivery Range Successfully Updated',
                'data' => ['transaksi' => $transaksi->load(['detailTransaksi.produk', 'pembayaran', 'customer', 'pengiriman'])]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update delivery range',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getTransactionById($id)
    {
        try {
            $transaksi = Transaksi::find($id);
            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction Not Found',
                    'data' => null
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Transaction Successfully Retrieved',
                'data' => ['transaksi' => $transaksi->load(['detailTransaksi.produk', 'pembayaran', 'pengiriman', 'customer'])]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive transaction',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getTransactionOnProcess()
    {
        try {
            $transaksi = Transaksi::where('status_transaksi', 'On Process')
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Transaction Successfully Retrieved',
                'data' => ['transaksi' => $transaksi->load(['detailTransaksi.produk', 'pembayaran', 'customer', 'pengiriman'])]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive transaction',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function updateTransactionToReady($id)
    {
        try {
            $transaksi = Transaksi::find($id);
            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction Not Found',
                    'data' => null
                ], 404);
            }
            $transaksi->status_transaksi = 'Ready';
            $transaksi->tanggal_siap = date('Y-m-d H:i:s');
            $transaksi->save();
            return response()->json([
                'success' => true,
                'message' => 'Transaction Successfully Updated',
                'data' => ['transaksi' => $transaksi->load(['detailTransaksi.produk', 'pembayaran', 'pengiriman', 'customer'])]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update transaction',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
