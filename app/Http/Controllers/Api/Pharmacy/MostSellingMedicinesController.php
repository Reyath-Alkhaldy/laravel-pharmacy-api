<?php

namespace App\Http\Controllers\Api\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderMedicine;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MostSellingMedicinesController extends Controller
{
    public function mostSellingMedicines(Request $request)
    {
        // $pharmacyId =  Auth::guard('sanctum')->id();
        // $pharmacyId = 1;
        // $medicines = Medicine::with(['orderMedicines' => function ($q) use ($pharmacyId) {
        //     $q->select('order_id');
        // }])
        //     ->select('filtered_medicines.*', 'medicine_id', DB::raw('SUM(quantity) AS total_sales'))
        //     ->from(function ($query) use ($pharmacyId) {
        //         $query->select('*')->from('medicines')->where('pharmacy_id', $pharmacyId);
        //     }, 'filtered_medicines')  // Define subquery alias
        //     ->join('order_medicines', 'order_medicines.medicine_id',   'filtered_medicines.id')
        //     ->groupBy('medicine_id')
        //     ->orderBy('total_sales', 'desc')
        //     ->limit(10)
        //     ->get();
        // return response()->json([
        //     'status' => 'success',
        //     'pharmacy_id' => $pharmacyId,
        //     'data' => $medicines,
        // ]);

        $pharmacyId =  Auth::guard('sanctum')->id();
        $pharmacyId = 1;

        $mostSellingMedicines =  OrderMedicine::with('medicine')
            ->join('medicines', 'order_medicines.medicine_id', 'medicines.id')

            ->selectRaw('pharmacy_id,medicine_id,SUM(quantity) AS total_sales,SUM(order_medicines.price * order_medicines.quantity) AS total_price')
            ->groupBy('medicine_id','pharmacy_id')
            ->having('pharmacy_id', $pharmacyId)
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            // ->dd();
            ->get();

            $ordersDetails = Order::where('pharmacy_id',$pharmacyId)->selectRaw('sum(total) as sum_total,count(id) as order_count')->first();
            $medicinesCount = Medicine::where('pharmacy_id',$pharmacyId)->count();
        return response()->json([
            'status' => 'success',
            'ordersDetails' => $ordersDetails,
            'medicinesCount' => $medicinesCount,
            // 'pharmacy_id' => $pharmacyId,
            'data' => $mostSellingMedicines,
        ]);
    }

    
}
