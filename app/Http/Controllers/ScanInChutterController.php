<?php

namespace App\Http\Controllers;

use App\Models\Ekanban\chuter_in_out_log;
use App\Models\Ekanban\ekanban_chutter_fgout;
use App\Models\Ekanban\ekanban_fg_chuter_tbl;
use App\Models\Ekanban\ekanban_fgin_tbl;
use App\Models\Ekanban\Ekanban_fgout_tbl;
use App\Models\Ekanban\ekanban_stock_limit;
use App\Models\Ekanban\Master_access_chuter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class ScanInChutterController extends Controller
{
    //
    public function index()
    {
        return view('scan-in-chutter.index');
    }

    public function validasi_access_account(Request $request)
    {
        $cut_code = $request->getCustcode;

        $get_user = Auth::user()->user;
        $status = 'ACTIVE';
        // dd($cut_code);
        $validasi_custcode = Master_access_chuter::where('user', $get_user)
            ->where('status', $status)
            ->select('access_cust')
            ->first();

        // $response = []; // Initialize the response array

        // Validate that the result is not null and access_cust is not empty
        if ($validasi_custcode !== null && !empty($validasi_custcode->access_cust)) {
            // Split the access_cust string into an array
            $accessCustArray = explode(',', $validasi_custcode->access_cust);

            // Check if the cut_code is in the array
            if (in_array($cut_code, $accessCustArray)) {
                // Prepare the success response
                $response = ["message" => "success"];
            } else {
                // Prepare the error response if the code is not found
                $response = ["message" => "error", "detail" => "User Login No Access For This Customer"];
            }
        } else {
            // Prepare the error response if no record is found or access_cust is empty
            $response = ["message" => "error", "detail" => "No valid User Login"];
        }

        // Debugging: Dump the response array
        // dd($response);

        // Return the response as JSON
        return response()->json($response);
    }

    public function validasi_access_account2(Request $request)
    {
        $cut_code = $request->getCustcode;

        $get_user = Auth::user()->user;
        $status = 'ACTIVE';
        // dd($cut_code);
        $validasi_custcode = Master_access_chuter::where('user', $get_user)
            ->where('status', $status)
            ->select('access_cust')
            ->first();

        // $response = []; // Initialize the response array

        // Validate that the result is not null and access_cust is not empty
        if ($validasi_custcode !== null && !empty($validasi_custcode->access_cust)) {
            // Split the access_cust string into an array
            $accessCustArray = explode(',', $validasi_custcode->access_cust);

            // Check if the cut_code is in the array
            if (in_array($cut_code, $accessCustArray)) {
                // Prepare the success response
                $response = ["message" => "success"];
            } else {
                // Prepare the error response if the code is not found
                $response = ["message" => "error", "detail" => "User Login No Access For This Customer"];
            }
        } else {
            // Prepare the error response if no record is found or access_cust is empty
            $response = ["message" => "error", "detail" => "No valid User Login"];
        }

        // Debugging: Dump the response array
        // dd($response);

        // Return the response as JSON
        return response()->json($response);
    }
    public function validasi_fgout1(Request $request)
    {

        $getKanban = $request->getKanban;
        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $validasi = ekanban_chutter_fgout::where('item_code', $getItemcode)
            ->where('seq', $getSquence)
            ->where('kanban_no', $getKanban)
            ->select('item_code')
            ->first();
        if (is_null($validasi)) {
            $validasi = "";
        }
        // dd($validasi);
        return response()->json($validasi);
    }

    public function validasi_fgin1(Request $request)
    {
        // dd($request);
        $getKanban = $request->getKanban;
        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;

        $getChutterforfgin = ekanban_fgin_tbl::where('item_code', $getItemcode)
            ->where('kanban_no', $getKanban)
            ->where('seq', $getSquence)
            ->select('chutter_address')
            ->first();

        if ($getChutterforfgin == null) {
            // data tidak ada di tabel
            $response = ["message" => "data_not"];
        } elseif ($getChutterforfgin->chutter_address === null) {
            // colum chuter address null
            $response = ["message" => "null"];
        } else {
            // colum chuter sudah ada
            $response = ["message" => "not_null"];
        }
        // dd($response);
        return response()->json($response);
    }

    public function validasi_chuteraddress(Request $request)
    {
        // dd($request);
        $getItemcode = $request->getItemcode;
        $is_active = 1;
        $getchuter = ekanban_stock_limit::where('itemcode', $getItemcode)
            ->select('chutter_address')
            ->where('is_active', $is_active)
            ->first();
        // dd($getchuter);
        if ($getchuter == null) {

            $response = ["message" => "data_null"];
        } else {

            $response = ["message" => "not_null"];
        }
        // dd($response);
        return response()->json($response);
    }
    public function validasi_max_chuter(Request $request)
    {
        // dd($request);
        date_default_timezone_set("Asia/Jakarta");
        $mpname = Carbon::now()->format('m-Y');
        $is_active = 1;
        $getItemcode = $request->getItemcode;
        $resultQty = intval($request->resultQty);

        $get_stock = ekanban_fg_chuter_tbl::where('item_code', $getItemcode)
            // ->where('mpname', $mpname)
            ->orderBy('creation_date', 'desc')
            ->select('balance')
            ->first();
        // dd($get_stock);
        $stock = $get_stock->balance;
        $result_stock = $resultQty + $stock;
        // GET qty stock max pada ekanban stock limit
        $getMax = ekanban_stock_limit::select('max')
            ->where('itemcode', $getItemcode)
            ->where('is_active', $is_active)
            ->first();
        $max = $getMax->max;
        // dd($get_stock);
        if ($max < $result_stock) {
            $response = ["message" => "error"];
        } else {
            // dd('masuk');
            $response = ["message" => "success"];
        }
        // dd($response);
        return response()->json($response);
    }
    public function validasi_overflow(Request $request)
    {
        // dd($request);
        $getKanban = $request->getKanban;
        $getSquence = $request->getSquence;
        // dd($getSquence);
        // Cek date kanban input
        $getDateforinput = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
        })
            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
            })
            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
            })
            ->selectRaw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date')
            ->where('ekanban_fgin_tbl.kanban_no', '=', $getKanban)
            ->where('ekanban_fgin_tbl.seq', '=', $getSquence)
            ->whereNull('ekanban_fgin_tbl.last_updated_date')
            ->whereNull('ekanban_fgin_tbl.chutter_address')
            ->first();
        // dd($getDateforinput);
        // cutoff date kanbaan pada kolom
        $cutOffdate = '2024-05-15';

        $getDatafordatabase = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
        })
            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
            })
            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
            })
            ->selectRaw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date')
            ->where('ekanban_fgin_tbl.kanban_no', $getKanban)
            ->whereNull('ekanban_fgin_tbl.last_updated_date')
            ->whereNull('ekanban_fgin_tbl.chutter_address')
            ->where('ekanban_fgin_tbl.creation_date', '>', $cutOffdate) // Use '>' comparison here
            ->orderBy('ekanban_fgin_tbl.creation_date', 'asc')
            ->first();


        $creationDate = $getDateforinput->creation_date;

        // Mengekstrak tanggal dari "creation_date"
        $dateParts = explode(" ", $creationDate);
        $dateInput = $dateParts[0];
        // dd($)
        $creationDate1 = $getDatafordatabase->creation_date;

        // Mengekstrak tanggal dari "creation_date"
        $dateParts = explode(" ", $creationDate1);
        $dateBase = $dateParts[0];
        // dd($dateBase);
        if ($dateInput === $dateBase) {
            // Data cocok, gunakan data dari $selectedData
            $response = ["message" => "success"];
        } else {
            // Data tidak cocok
            $response = ["message" => "error",  "date" => $dateBase];
        }
        // dd($response);
        return response()->json($response);
    }
    public function validasi_date(Request $request)
    {
        // dd($request);
        $colKanban = $request->colKanban;
        $colSeq = $request->colSeq;
        $getKanban = $request->getKanban;
        $getSquence = $request->getSquence;
        // dd($getSquence);
        // Cek date kanban input
        $getDateforinput = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
        })
            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
            })
            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
            })
            ->selectRaw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date')
            ->where('ekanban_fgin_tbl.kanban_no', '=', $getKanban)
            ->where('ekanban_fgin_tbl.seq', '=', $getSquence)
            ->whereNull('ekanban_fgin_tbl.last_updated_date')
            ->whereNull('ekanban_fgin_tbl.chutter_address')
            ->first();

        // Cek date kanbaan pada kolom
        $getDateforcol = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
        })
            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
            })
            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
            })
            ->selectRaw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date')
            ->where('ekanban_fgin_tbl.kanban_no', '=', $colKanban)
            ->where('ekanban_fgin_tbl.seq', '=', $colSeq)
            ->whereNull('ekanban_fgin_tbl.last_updated_date')
            ->whereNull('ekanban_fgin_tbl.chutter_address')
            ->first();

        $creationDate = $getDateforinput->creation_date;

        // Mengekstrak tanggal dari "creation_date"
        $dateParts = explode(" ", $creationDate);
        $dateInput = $dateParts[0];
        // dd($)
        $creationDate1 = $getDateforcol->creation_date;

        // Mengekstrak tanggal dari "creation_date"
        $dateParts = explode(" ", $creationDate1);
        $dateCol = $dateParts[0];
        // dd($dateCol);
        if ($dateInput === $dateCol) {
            // Data cocok, gunakan data dari $selectedData
            $response = ["message" => "success"];
        } else {
            // Data tidak cocok
            $response = ["message" => "error"];
        }
        // dd($response);
        return response()->json($response);
    }
    public function validasi_fgout2(Request $request)
    {

        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $validasi = ekanban_chutter_fgout::where('item_code', $getItemcode)
            ->where('seq', $getSquence)
            ->select('item_code')
            ->first();
        if (is_null($validasi)) {
            $validasi = "";
        }
        // dd($validasi);
        return response()->json($validasi);
    }
    public function validasi_fgin2(Request $request)
    {
        // dd($request);
        $getSquence = $request->getSquence;
        $getItemcode = $request->getItemcode;
        $getKanban = $request->getKanban;
        // dd($getSquence);
        $getChutterforfgin = ekanban_fgin_tbl::where('kanban_no', $getKanban)
            ->where('seq', $getSquence)
            ->select('chutter_address')
            ->first();

        if ($getChutterforfgin == null) {
            // data tidak ada di tabel
            $response = ["message" => "data_not"];
        } elseif ($getChutterforfgin->chutter_address === null) {
            // colum chuter address null
            $response = ["message" => "null"];
        } else {
            // colum chuter sudah ada
            $response = ["message" => "not_null"];
        }
        // dd($getChutterforfgin);
        return response()->json($response);
    }
    // public function validasi_fgin3(Request $request)
    // {
    //     // dd($request);
    //     $getSquence = $request->getSquence1;
    //     $getItemcode = $request->getItemcode1;
    //     // dd($getSquence);
    //     $getChutterforfgin = ekanban_fgin_tbl::where('item_code', $getItemcode)
    //         ->where('seq', $getSquence)
    //         ->select('chutter_address')
    //         ->first();
    //     // dd($getChutterforfgin);
    //     if ($getChutterforfgin == null) {
    //         // data tidak ada di tabel
    //         $response = ["message" => "data_not"];
    //     } elseif ($getChutterforfgin->chutter_address === null) {
    //         // colum chuter address null
    //         $response = ["message" => "null"];
    //     } else {
    //         // colum chuter sudah ada
    //         $response = ["message" => "not_null"];
    //     }
    //     // dd($response);
    //     return response()->json($response);
    // }
    public function validasi_date1(Request $request)
    {
        // dd($request);
        $colKanban = $request->colKanban;
        $colSeq = $request->colSeq;
        $getKanban = $request->getKanban;
        $getSquence = $request->getSquence;
        // dd($getSquence);
        // Cek date kanban input
        $getDateforinput = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
        })
            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
            })
            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
            })
            ->selectRaw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date')
            ->where('ekanban_fgin_tbl.kanban_no', '=', $getKanban)
            ->where('ekanban_fgin_tbl.seq', '=', $getSquence)
            ->whereNull('ekanban_fgin_tbl.last_updated_date')
            ->whereNull('ekanban_fgin_tbl.chutter_address')
            ->first();

        // Cek date kanbaan pada kolom
        $getDateforcol = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
        })
            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
            })
            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
            })
            ->selectRaw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date')
            ->where('ekanban_fgin_tbl.kanban_no', '=', $colKanban)
            ->where('ekanban_fgin_tbl.seq', '=', $colSeq)
            ->whereNull('ekanban_fgin_tbl.last_updated_date')
            ->whereNull('ekanban_fgin_tbl.chutter_address')
            ->first();
        // dd($getDateforcol);
        $creationDate = $getDateforinput->creation_date;

        // Mengekstrak tanggal dari "creation_date"
        $dateParts = explode(" ", $creationDate);
        $dateInput = $dateParts[0];

        $creationDate1 = $getDateforcol->creation_date;

        // Mengekstrak tanggal dari "creation_date"
        $dateParts = explode(" ", $creationDate1);
        $dateCol = $dateParts[0];
        if ($dateInput === $dateCol) {
            // Data cocok, gunakan data dari $selectedData
            $response = ["message" => "success"];
        } else {
            // Data tidak cocok
            $response = ["message" => "error"];
        }
        // dd($response);
        return response()->json($response);
    }
    public function validasi_itemcode(Request $request)
    {
        $itemcodeChutter = $request->itemcodeChutter;
        // dd($itemcodeChutter);
        $getChutterforstocklimit = ekanban_stock_limit::where('itemcode', $itemcodeChutter)
            ->where('chutter_address', '!=', null)
            ->select('chutter_address')
            ->first();
        // dd($getChutterforstocklimit);
        $getChutterforstocklimit = $getChutterforstocklimit ? $getChutterforstocklimit->chutter_address : "";
        return response()->json($getChutterforstocklimit);
    }

    public function get_chutterinput2(Request $request)
    {
        // dd($request);
        $itemLokal = $request->itemLokal;
        $getChutter = ekanban_stock_limit::where('itemcode', $itemLokal)
            ->where('chutter_address', '!=', null)
            ->select('chutter_address')
            ->first();
        // dd($getChutter);s
        return response()->json($getChutter);
    }
    public function add_chutteraddress(Request $request)

    {
        // dd($request);
        date_default_timezone_set("Asia/Jakarta");
        DB::connection('ekanban')->beginTransaction();

        try {
            $itemcodes = $request->input('Itemcode');
            $firstItemcode = $itemcodes[0];
            $partNos = $request->input('part_no');
            $Qty = $request->input('Qty');
            $squences = $request->input('Squence');
            $Kanban_no = $request->input('Kanban_no');
            $colKanban = $Kanban_no[0];
            $colSeq = $squences[0];

            // dd($squences);
            $check_kanban = ekanban_fgin_tbl::where('kanban_no', $colKanban)
                ->where('seq', $colSeq)
                ->select('kanban_no')
                ->first();
            // dd($check_kanban);
            if ($check_kanban == null) {
                // Jika kanban nya null, kirim pesan kesalahan
                // echo "kanban_error";
                $response = ["message" => "kanban_error"];
            } else {
                // echo "masuk";
                // mpname terbaru
                $mpname_now = Carbon::now()->format('m-Y');

                // cek mpname terbaru pada ekanban_fgin_tbl
                $getMpnamefgin = ekanban_fgin_tbl::where('item_code', $firstItemcode)
                    ->orderBy('creation_date', 'desc')
                    ->first();

                $getItemcode = $getMpnamefgin->item_code;
                // dd($getItemcode);
                // get mpname pada ekanban fg
                $getMpnamefg = ekanban_fg_chuter_tbl::where('item_code', $getItemcode)
                    ->select('mpname')
                    ->orderBy('creation_date', 'desc')
                    ->first();
                // get mpname pada getMpnamefg
                // $mpname_fg = $getMpnamefg->mpname;
                // dd($getMpnamefg);
                // jika mpaname tidak ada pada tbl ekanban fg langsung entry data di ekanban fg
                if ($getMpnamefg === null || $getMpnamefg->mpname === null) {
                    // echo "masuk validasi mpname";
                    // menghitung qty dengan where no kanban
                    // menghitung semua qty pada kanban chuter dengan where no kanban
                    $getQty = ekanban_fgin_tbl::select(DB::raw('SUM(ekanban_fgin_tbl.qty) as total_qty'))
                        ->where('ekanban_fgin_tbl.item_code', '=', $getItemcode)
                        ->whereNull('ekanban_fgin_tbl.last_updated_date')
                        ->whereNotNull('ekanban_fgin_tbl.chutter_address')
                        ->first();
                    // Inisialisasi $Qty_now dengan nilai 0
                    $Qty_now = 0;
                    // dd($getQty);
                    // Cek apakah hasil query ketiga atau $getQty adalah null atau total_qty nya null
                    if ($getQty === null || $getQty->total_qty === null) {
                        // Jika null, maka isi $Qty_now dengan nilai 0
                        $Qty_now = 0;
                    } else {
                        // Jika tidak null, maka isi $Qty_now dengan total_qty dari hasil query
                        $Qty_now = $getQty->total_qty;
                    }

                    // Ambil data dari variabel $getMpnamefg
                    $part_no = $getMpnamefgin->part_no;
                    $item_code = $getMpnamefgin->item_code;
                    $stock_awal = $Qty_now;
                    $mpname = $mpname_now;
                    $created_by = Auth::user()->user;
                    $creation_date = Carbon::now();

                    // Buat entri baru dalam tabel ekanban_fg_chuter_tbl
                    $create_fg = ekanban_fg_chuter_tbl::create([
                        'item_code' => $item_code,
                        'part_no' => $part_no,
                        'stock_awal' => $stock_awal,
                        'mpname' => $mpname,
                        'created_by' => $created_by,
                        'creation_date' => $creation_date
                    ]);
                    // get kanban print dari 3 database
                    $getDateforcol = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
                        $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                            ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
                    })
                        ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                                ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
                        })
                        ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
                        })
                        ->select(DB::raw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date'))
                        ->where('ekanban_fgin_tbl.kanban_no', '=',  $colKanban)
                        ->where('ekanban_fgin_tbl.seq', $colSeq)
                        ->whereNull('ekanban_fgin_tbl.last_updated_date')
                        ->whereNull('ekanban_fgin_tbl.chutter_address')
                        ->first();

                    // dd($getDateforcol);
                    //  Cek kanban print pertama untuk $getDatafordatabase
                    $getDatafordatebase = ekanban_fgin_tbl::select('kanban_print')
                        ->where('kanban_no', '=', $colKanban)
                        ->whereNull('last_updated_date')
                        ->whereNotNull('chutter_address')
                        ->orderBy('kanban_print', 'desc')
                        ->first();
                    // dd($getDatafordatebase);

                    //  validasi menentukan penempatan kanban
                    if ($getDatafordatebase == null) {
                        $response = ["message" => "first_date"];
                    } else {
                        $creationDateForCol = $getDateforcol->creation_date;
                        $formattedDateForCol = Carbon::parse($creationDateForCol)->format('Y-m-d');

                        // Mengambil creation_date dari $getDatafordatebase
                        $creationDateForDatabase = $getDatafordatebase->kanban_print;
                        $formattedDateForDatabase = Carbon::parse($creationDateForDatabase)->format('Y-m-d');
                        // Membandingkan tanggal
                        if ($formattedDateForCol < $formattedDateForDatabase) {
                            // Tanggal pertama lebih awal
                            $response = ["message" => "first_date"];
                        } else {
                            // Tanggal pertama lebih besar atau sama dengan tanggal kedua
                            $response = ["message" => "end_date", "formattedDateForDatabase" => $formattedDateForDatabase];
                        }
                    }

                    // get date print kanban
                    // Ambil creation_date dari join
                    $get_print_kanban = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
                        $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                            ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
                    })
                        ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                                ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
                        })
                        ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
                        })
                        ->select(
                            'ekanban_fgin_tbl.kanban_no',
                            'ekanban_fgin_tbl.seq',
                            DB::raw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date')
                        )
                        ->whereIn('ekanban_fgin_tbl.kanban_no', $Kanban_no)
                        ->whereIn('ekanban_fgin_tbl.seq', $squences)
                        ->whereNull('ekanban_fgin_tbl.last_updated_date')
                        ->whereNull('ekanban_fgin_tbl.chutter_address')
                        ->get();


                    // dd($get_print_kanban);
                    // looping kanban print pada $get_print_kanban
                    foreach ($get_print_kanban as $print_kanban) {
                        $kanban_no = $print_kanban->kanban_no;
                        $seq = $print_kanban->seq;

                        // Ambil creation_date dari hasil join, sesuaikan prioritas yang diinginkan
                        $kanban_print = $print_kanban->creation_date ?? $print_kanban->entry_print_creation_date ?? $print_kanban->fgprinted_creation_date;
                        $chutterAddres = $request->chutter_address;
                        // Update data pada ekanban fg in
                        $updateFgin = ekanban_fgin_tbl::where('kanban_no', $kanban_no)
                            ->where('seq', $seq)
                            ->update([
                                'chutter_address' => $chutterAddres,
                                'kanban_print' => $kanban_print,
                            ]);
                        // dd($updateFgin);
                    }
                    // Lakukan entry pada in out chuter log
                    $in_date = Carbon::now();
                    $created_by = Auth::user()->user;

                    $dataToInsert = [];

                    foreach ($Kanban_no as $key => $kanban) {
                        $dataToInsert[] = [
                            'kanban_no' => $kanban,
                            'chuter_address' => $chutterAddres,
                            'seq' => $squences[$key],
                            'in_datetime' => $in_date,
                            'created_by' => $created_by
                        ];
                    }

                    chuter_in_out_log::insert($dataToInsert);

                    // update stock pada ekanban fg
                    $getfgTbl = ekanban_fg_chuter_tbl::where('item_code', $firstItemcode)
                        // ->whereIn('part_no', $partNos)
                        ->where('mpname', $mpname)
                        ->select('stock_awal', 'in', 'out', 'id')
                        ->first();
                    $id_fg = $getfgTbl->id;
                    $stock_awal = $getfgTbl->stock_awal;
                    $in = $getfgTbl->in;
                    $out = $getfgTbl->out;
                    // Lakukan update pada balance ekanban fg
                    $totalIn = array_sum(array_map('intval', $Qty));

                    // Tambahkan totalIn ke currentIn
                    $newIn = $in + $totalIn;
                    // dd($newIn);
                    $balance =  $stock_awal +  $newIn -  $out;
                    // dd($stock_awal);
                    $updateBalance = ekanban_fg_chuter_tbl::where('id', $id_fg)
                        ->update([
                            'in' => $newIn,
                            'balance' => $balance
                        ]);
                    // dd($resulIn);
                } else {
                    // Jika $getMpnamefg tidak null, bandingkan nilai mpname_now dengan $mpname_fg
                    $mpname_fg = $getMpnamefg->mpname;
                    // dd($mpname_fg);
                    if ($mpname_now != $mpname_fg) {
                        // echo "validasi mmpname tidak sama";
                        // Lakukan tindakan jika nilai mpname_now tidak sama dengan $mpname_fg
                        // menghitung semua qty pada kanban chuter dengan where no kanban
                        // $get_ekanbanfg = ekanban_fg_chuter_tbl::select(
                        //     'ekanban_fg_chuter_tbl.item_code',
                        //     DB::raw('MAX(ekanban_fg_chuter_tbl.part_no) as part_no'),
                        //     DB::raw('MAX(ekanban_fg_chuter_tbl.mpname) as mpname'),
                        //     DB::raw('MAX(ekanban_fg_chuter_tbl.balance) as balance')
                        //     // DB::raw('MAX(COALESCE(filtered_fgin_tbl.total_qty, 0)) as total_qty')
                        // )
                        //     ->leftJoin(
                        //         DB::raw('(SELECT item_code, SUM(qty) as total_qty
                        //               FROM ekanban_fgin_tbl
                        //               WHERE last_updated_date IS NULL
                        //                 AND chutter_address IS NOT NULL
                        //               GROUP BY item_code) as filtered_fgin_tbl'),
                        //         'ekanban_fg_chuter_tbl.item_code',
                        //         '=',
                        //         'filtered_fgin_tbl.item_code'
                        //     )
                        //     ->groupBy('ekanban_fg_chuter_tbl.item_code')
                        //     ->orderBy(DB::raw('(SELECT MAX(creation_date)
                        //                     FROM ekanban_fg_chuter_tbl
                        //                     WHERE item_code = ekanban_fg_chuter_tbl.item_code)'), 'desc')
                        //     ->get();

                        $get_ekanbanfg = ekanban_fg_chuter_tbl::select(
                            'item_code',
                            DB::raw('MAX(part_no) as part_no'), // Ambil part_no yang paling terakhir
                            DB::raw('MAX(mpname) as mpname'), // Ambil mpname yang paling terakhir
                            DB::raw('MAX(balance) as balance') // Ambil balance yang paling terakhir
                        )
                            ->groupBy('item_code') // Hanya group by item_code
                            ->orderBy('mpname', 'desc') // Menambahkan urutan berdasarkan mpname
                            ->get();

                        // Debug dengan dd() untuk melihat hasil query yang diambil
                        // dd($get_ekanbanfg->toArray());

                        // dd($get_ekanbanfg);
                        // Get the current month and year formatted as 'm-Y'
                        $mpname = Carbon::now()->format('m-Y');
                        // Get the current authenticated user and date
                        $created_by = "chuter_in"; // Truncate to fit column length
                        $creation_date = Carbon::now();

                        // Loop through the retrieved data and insert into the table
                        foreach ($get_ekanbanfg as $record) {
                            // Create a new entry in the table
                            $create_fg = ekanban_fg_chuter_tbl::create([
                                'item_code' => $record->item_code,
                                'part_no' => $record->part_no,
                                'stock_awal' => $record->balance,
                                'balance' => $record->balance,
                                'mpname' => $mpname,
                                'created_by' => $created_by,
                                'creation_date' => $creation_date
                            ]);
                        }
                        //GET untuk mengambil data yang belum ter update mpname
                        // get kanban print dari 3 database
                        $getDateforcol = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
                            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
                        })
                            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
                            })
                            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
                            })
                            ->select(DB::raw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date'))
                            ->where('ekanban_fgin_tbl.kanban_no', '=',  $colKanban)
                            ->where('ekanban_fgin_tbl.seq', $colSeq)
                            ->whereNull('ekanban_fgin_tbl.last_updated_date')
                            ->whereNull('ekanban_fgin_tbl.chutter_address')
                            ->first();


                        // dd($getDateforcol);
                        //  Cek kanban print pertama untuk $getDatafordatabase
                        $getDatafordatebase = ekanban_fgin_tbl::select('kanban_print')
                            ->where('kanban_no', '=', $colKanban)
                            ->whereNull('last_updated_date')
                            ->whereNotNull('chutter_address')
                            ->orderBy('kanban_print', 'desc')
                            ->first();
                        // dd($getDatafordatebase);

                        //  validasi menentukan penempatan kanban
                        if ($getDatafordatebase == null) {
                            $response = ["message" => "first_date"];
                        } else {
                            $creationDateForCol = $getDateforcol->creation_date;
                            $formattedDateForCol = Carbon::parse($creationDateForCol)->format('Y-m-d');

                            // Mengambil creation_date dari $getDatafordatebase
                            $creationDateForDatabase = $getDatafordatebase->kanban_print;
                            $formattedDateForDatabase = Carbon::parse($creationDateForDatabase)->format('Y-m-d');
                            // Membandingkan tanggal
                            if ($formattedDateForCol < $formattedDateForDatabase) {
                                // Tanggal pertama lebih awal
                                $response = ["message" => "first_date"];
                            } else {
                                // Tanggal pertama lebih besar atau sama dengan tanggal kedua
                                $response = ["message" => "end_date", "formattedDateForDatabase" => $formattedDateForDatabase];
                            }
                        }

                        // get date print kanban
                        // Ambil creation_date dari join
                        $get_print_kanban = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
                            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
                        })
                            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
                            })
                            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
                            })
                            ->select(
                                'ekanban_fgin_tbl.kanban_no',
                                'ekanban_fgin_tbl.seq',
                                DB::raw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date')
                            )
                            ->whereIn('ekanban_fgin_tbl.kanban_no', $Kanban_no)
                            ->whereIn('ekanban_fgin_tbl.seq', $squences)
                            ->whereNull('ekanban_fgin_tbl.last_updated_date')
                            ->whereNull('ekanban_fgin_tbl.chutter_address')
                            ->get();


                        // dd($get_print_kanban);
                        // looping kanban print pada $get_print_kanban
                        foreach ($get_print_kanban as $print_kanban) {
                            $kanban_no = $print_kanban->kanban_no;
                            $seq = $print_kanban->seq;

                            // Ambil creation_date dari hasil join, sesuaikan prioritas yang diinginkan
                            $kanban_print = $print_kanban->creation_date ?? $print_kanban->entry_print_creation_date ?? $print_kanban->fgprinted_creation_date;
                            $chutterAddres = $request->chutter_address;
                            // Update data pada ekanban fg in
                            $updateFgin = ekanban_fgin_tbl::where('kanban_no', $kanban_no)
                                ->where('seq', $seq)
                                ->update([
                                    'chutter_address' => $chutterAddres,
                                    'kanban_print' => $kanban_print,
                                ]);
                            // dd($updateFgin);
                        }
                        // Lakukan entry pada in out chuter log
                        $in_date = Carbon::now();
                        $created_by = Auth::user()->user;

                        $dataToInsert = [];

                        foreach ($Kanban_no as $key => $kanban) {
                            $dataToInsert[] = [
                                'kanban_no' => $kanban,
                                'chuter_address' => $chutterAddres,
                                'seq' => $squences[$key],
                                'in_datetime' => $in_date,
                                'created_by' => $created_by
                            ];
                        }

                        chuter_in_out_log::insert($dataToInsert);

                        // get stock pada ekanban fg
                        $getfgTbl = ekanban_fg_chuter_tbl::where('item_code', $firstItemcode)
                            // ->whereIn('part_no', $partNos)
                            ->where('mpname', $mpname)
                            ->select('stock_awal', 'in', 'out', 'id')
                            ->first();
                        $id_fg = $getfgTbl->id;
                        $stock_awal = $getfgTbl->stock_awal;
                        $in = $getfgTbl->in;
                        $out = $getfgTbl->out;
                        // Lakukan update pada balance ekanban fg
                        $totalIn = array_sum(array_map('intval', $Qty));

                        // Tambahkan totalIn ke currentIn
                        $newIn = $in + $totalIn;
                        // dd($newIn);
                        $balance =  $stock_awal +  $newIn -  $out;
                        // dd($stock_awal);
                        $updateBalance = ekanban_fg_chuter_tbl::where('id', $id_fg)
                            ->update([
                                'in' => $newIn,
                                'balance' => $balance
                            ]);
                    } else {
                        // echo "validasi mpaname sama ";
                        // Lakukan tindakan jika nilai mpname_now sama dengan $mpname_fg

                        // get kanban print dari 3 database
                        $getDateforcol = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
                            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
                        })
                            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
                            })
                            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
                            })
                            ->select(DB::raw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date'))
                            ->where('ekanban_fgin_tbl.kanban_no', '=',  $colKanban)
                            ->where('ekanban_fgin_tbl.seq', $colSeq)
                            ->whereNull('ekanban_fgin_tbl.last_updated_date')
                            ->whereNull('ekanban_fgin_tbl.chutter_address')
                            ->first();
                        // dd($getDateforcol);
                        //  Cek kanban print pertama untuk $getDatafordatabase
                        $getDatafordatebase = ekanban_fgin_tbl::select('kanban_print')
                            ->where('kanban_no', '=', $colKanban)
                            ->whereNull('last_updated_date')
                            ->whereNotNull('chutter_address')
                            ->orderBy('kanban_print', 'desc')
                            ->first();
                        // dd($getDatafordatebase);

                        //  validasi menentukan penempatan kanban
                        if ($getDatafordatebase == null) {
                            $response = ["message" => "first_date"];
                        } else {
                            $creationDateForCol = $getDateforcol->creation_date;
                            $formattedDateForCol = Carbon::parse($creationDateForCol)->format('Y-m-d');

                            // Mengambil creation_date dari $getDatafordatebase
                            $creationDateForDatabase = $getDatafordatebase->kanban_print;
                            $formattedDateForDatabase = Carbon::parse($creationDateForDatabase)->format('Y-m-d');
                            // Membandingkan tanggal
                            if ($formattedDateForCol < $formattedDateForDatabase) {
                                // Tanggal pertama lebih awal
                                $response = ["message" => "first_date"];
                            } else {
                                // Tanggal pertama lebih besar atau sama dengan tanggal kedua
                                $response = ["message" => "end_date", "formattedDateForDatabase" => $formattedDateForDatabase];
                            }
                        }

                        // get date print kanban
                        // Ambil creation_date dari join
                        $get_print_kanban = ekanban_fgin_tbl::leftJoin('ekanban_piprodinlog_tbl', function ($join) {
                            $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_piprodinlog_tbl.ekanban_no')
                                ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_piprodinlog_tbl.seq');
                        })
                            ->leftJoin('hyundai.entry_print_kanban', function ($join) {
                                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'entry_print_kanban.ekanban_no')
                                    ->on('ekanban_fgin_tbl.seq', '=', 'entry_print_kanban.seq');
                            })
                            ->leftJoin('ekanban_fgprinted_log_tbl', function ($join) {
                                $join->on('ekanban_fgin_tbl.kanban_no', '=', 'ekanban_fgprinted_log_tbl.ekanban_no')
                                    ->on('ekanban_fgin_tbl.seq', '=', 'ekanban_fgprinted_log_tbl.seq');
                            })
                            ->select(
                                'ekanban_fgin_tbl.kanban_no',
                                'ekanban_fgin_tbl.seq',
                                DB::raw('COALESCE(ekanban_piprodinlog_tbl.creation_date, entry_print_kanban.creation_date, ekanban_fgprinted_log_tbl.creation_date) as creation_date')
                            )
                            ->whereIn('ekanban_fgin_tbl.kanban_no', $Kanban_no)
                            ->whereIn('ekanban_fgin_tbl.seq', $squences)
                            ->whereNull('ekanban_fgin_tbl.last_updated_date')
                            ->whereNull('ekanban_fgin_tbl.chutter_address')
                            ->get();


                        // dd($get_print_kanban);
                        // looping kanban print pada $get_print_kanban
                        foreach ($get_print_kanban as $print_kanban) {
                            $kanban_no = $print_kanban->kanban_no;
                            $seq = $print_kanban->seq;

                            // Ambil creation_date dari hasil join, sesuaikan prioritas yang diinginkan
                            $kanban_print = $print_kanban->creation_date ?? $print_kanban->entry_print_creation_date ?? $print_kanban->fgprinted_creation_date;
                            $chutterAddres = $request->chutter_address;
                            // Update data pada ekanban fg in
                            $updateFgin = ekanban_fgin_tbl::where('kanban_no', $kanban_no)
                                ->where('seq', $seq)
                                ->update([
                                    'chutter_address' => $chutterAddres,
                                    'kanban_print' => $kanban_print,
                                ]);
                            // dd($updateFgin);
                        }
                        // Lakukan entry pada in out chuter log
                        $in_date = Carbon::now();
                        $created_by = Auth::user()->user;

                        $dataToInsert = [];

                        foreach ($Kanban_no as $key => $kanban) {
                            $dataToInsert[] = [
                                'kanban_no' => $kanban,
                                'chuter_address' => $chutterAddres,
                                'seq' => $squences[$key],
                                'in_datetime' => $in_date,
                                'created_by' => $created_by
                            ];
                        }

                        chuter_in_out_log::insert($dataToInsert);
                        $mpname = Carbon::now()->format('m-Y');
                        // update stock pada ekanban fg
                        $getfgTbl = ekanban_fg_chuter_tbl::where('item_code', $firstItemcode)
                            // ->whereIn('part_no', $partNos)
                            ->where('mpname', $mpname)
                            ->select('stock_awal', 'in', 'out', 'id')
                            ->first();
                        $id_fg = $getfgTbl->id;
                        $stock_awal = $getfgTbl->stock_awal;
                        $in = $getfgTbl->in;
                        $out = $getfgTbl->out;
                        // Lakukan update pada balance ekanban fg
                        $totalIn = array_sum(array_map('intval', $Qty));

                        // Tambahkan totalIn ke currentIn
                        $newIn = $in + $totalIn;
                        // dd($newIn);
                        $balance =  $stock_awal +  $newIn -  $out;
                        // dd($stock_awal);
                        $updateBalance = ekanban_fg_chuter_tbl::where('id', $id_fg)
                            ->update([
                                'in' => $newIn,
                                'balance' => $balance
                            ]);
                        // dd($balance);
                    }
                }

                // perbandingan date kanban print antara kolom inputan dan database
                // Cek pertama untuk $getDateforcol

            }
            DB::connection('ekanban')->commit();
            return response()->json($response);
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::connection('ekanban')->rollback();

            // Handle the error, log it, or throw an exception if needed
            return response()->json(["message" => "Error: " . $e->getMessage()], 400);
        }
    }
}
