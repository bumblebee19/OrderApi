<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class ChartController extends Controller
{
    public function index()
    {
        return \view('welcome');
    }

    public function total(Request $request)
    {
        $orderOne = Order::selectRaw("COUNT(*) as total, DATE_FORMAT(created_at, '%Y-%m-%d') date")
            ->groupBy('date')
            ->get();
        $orderTwo = Order::selectRaw("SUM(total)/COUNT(*) as sum, DATE_FORMAT(created_at, '%Y-%m-%d') date")
            ->groupBy('date')
            ->get();

        if (!empty($request->get('startDate')) && !empty($request->get('endDate'))) {
            $orderOne->DateBetween($request);
            $orderTwo->DateBetween($request);
        }

        $total = [];
        $sum = [];
        $date = [];
        foreach ($orderOne as $item) {
            $total[] = $item['total'];
        }
        foreach ($orderTwo as $item) {
            $sum[] = $item['sum'];
            $date[] = $item['date'];
        }

        return [
            'total' => $total,
            'sum' => $sum,
            'date' => $date,
        ];
    }

    public function popular()
    {
        $items = OrderItem::selectRaw("COUNT(product_id) as statistic, product_id")
            ->with('product')
            ->orderBy('statistic', 'desc')
            ->take(10)
            ->groupBy('product_id')
            ->get();

        $statistics = [];
        $products = [];
        foreach ($items as $item) {
            $statistics[] = $item['statistic'];
            $products[] = $item['product']['name'];
        }

        return [
            'statistics' => $statistics,
            'products'   => $products,
        ];
    }
}
