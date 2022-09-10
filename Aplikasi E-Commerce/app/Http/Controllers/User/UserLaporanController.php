<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Penjualan;
use App\PenjualanDetail;
use Carbon\Carbon;

class UserLaporanController extends Controller
{
    public function index()
    {
        $date = Carbon::now();
        $date_start = $date->startOfMonth()->toDateTimeString();
        $date_end = $date->endOfMonth()->toDateTimeString();

        $data['model'] = Penjualan::where('created_at', '>=', $date_start)
        ->where('created_at', '<=', $date_end)->get();

        $data['pemasukan_harian'] = 0;
        $data['pemasukan_bulanan'] = 0;

        // start handle area chart
        $year = $date->format('Y');
        $penjualan = Penjualan::whereYear('created_at', $year)->get();

        $jan = 0;
        $feb= 0;
        $mar= 0;
        $apr= 0;
        $mei= 0;
        $jun= 0;
        $jul= 0;
        $ags= 0;
        $sep= 0;
        $okt= 0;
        $nov = 0;
        $des = 0;

        foreach ($penjualan as $key => $item) {
            $month = $item->created_at->format('m');
            if($month == '01'){
                $jan += $item->total;
            }else if($month == '02'){
                $feb += $item->total;
            }else if($month == '03'){
                $mar += $item->total;
            }else if($month == '04'){
                $apr += $item->total;
            }else if($month == '05'){
                $mei += $item->total;
            }else if($month == '06'){
                $jun += $item->total;
            }else if($month == '07'){
                $jul += $item->total;
            }else if($month == '08'){
                $ags += $item->total;
            }else if($month == '09'){
                $sep += $item->total;
            }else if($month == '10'){
                $okt += $item->total;
            }else if($month == '11'){
                $nov += $item->total;
            }else if($month == '12'){
                $des += $item->total;
            }
        }
        $data['data_area_chart'] = array($jan, $feb, $mar, $apr, $mei, $jun, $jul, $ags, $sep, $okt, $nov, $des);
        // end handle area chart

        foreach ($data['model'] as $key => $item) {
            $data['pemasukan_bulanan'] += $item->total;

            if($item->created_at->format('Y-m-d') == Carbon::now()->format('Y-m-d')){
                $data['pemasukan_harian'] += $item->total;
            }
        }

        return view('user.user_laporan_form', $data);
    }

    public function store(Request $request)
    {
        $data['tgl_awal'] = $request->tgl_awal;
        $data['tgl_akhir'] = $request->tgl_akhir;
        $data['pemasukan_harian'] = 0;
        $data['pemasukan_bulanan'] = 0;

        if(date('Y', strtotime($data['tgl_awal'])) != date('Y', strtotime($data['tgl_akhir']))){
            toast('Tahun awal dan tahun akhir harus sama', 'error');
            return back();
        }

        $data['model'] = Penjualan::where('created_at', '>=', $data['tgl_awal'])
        ->where('created_at', '<=', $data['tgl_akhir'])->get();

        if($data['model']->count()){
            foreach ($data['model'] as $key => $item) {
                $data['pemasukan_bulanan'] += $item->total;
            }
    
            $data['pemasukan_harian'] = (int)($data['pemasukan_bulanan'] / $data['model']->count());
        }

        // start handle area cart
        $year = date('Y', strtotime($data['tgl_awal']));
        $penjualan = Penjualan::whereYear('created_at', $year)->get();

        $jan = 0;
        $feb= 0;
        $mar= 0;
        $apr= 0;
        $mei= 0;
        $jun= 0;
        $jul= 0;
        $ags= 0;
        $sep= 0;
        $okt= 0;
        $nov = 0;
        $des = 0;

        foreach ($penjualan as $key => $item) {
            $month = $item->created_at->format('m');
            if($month == '01'){
                $jan += $item->total;
            }else if($month == '02'){
                $feb += $item->total;
            }else if($month == '03'){
                $mar += $item->total;
            }else if($month == '04'){
                $apr += $item->total;
            }else if($month == '05'){
                $mei += $item->total;
            }else if($month == '06'){
                $jun += $item->total;
            }else if($month == '07'){
                $jul += $item->total;
            }else if($month == '08'){
                $ags += $item->total;
            }else if($month == '09'){
                $sep += $item->total;
            }else if($month == '10'){
                $okt += $item->total;
            }else if($month == '11'){
                $nov += $item->total;
            }else if($month == '12'){
                $des += $item->total;
            }
        }
        $data['data_area_chart'] = array($jan, $feb, $mar, $apr, $mei, $jun, $jul, $ags, $sep, $okt, $nov, $des);
        // end handle area chart

        return view('user.user_laporan_form', $data);
    }

    public function laporanPDF($id)
    {
        $data['penjualan'] = Penjualan::findOrFail($id);
        $data['penjualanDetail'] = $data['penjualan']->penjualanDetails;

        return view('user.user_laporan_pdf', $data);
    }
}
