<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PurchaseHistoryController extends Controller
{
    //
    public function showPurchaseHistory()
    {
        $orders = DB::table('orders')->where('user_id', Auth::id())->get();
        foreach ($orders as $order) {
            if ($order->payment_method == 1) {
                $order->payment_method = '代金引換';
            } else if ($order->payment_method == 2) {
                $order->payment_method = 'クレジットカード';
            }
        }

        $users = DB::table('users')->get();
        foreach ($orders as $order) {
            foreach ($users as $user) {
                if ($user->id == $order->user_id) {
                    $order->user_id = $user->name;
                }
            }
        }

        $orderItems = DB::table('order_items')->get();
        $items = DB::table('items')->get();
        foreach ($orderItems as $orderItem) {
            foreach ($items as $item) {
                if ($orderItem->item_id == $item->id) {
                    $orderItem->name = $item->name;
                }
            }
        }

        $orderToppings = DB::table('order_toppings')->get();
        $toppings = DB::table('toppings')->get();
        foreach ($orderToppings as $orderTopping) {
            foreach ($toppings as $topping) {
                if ($orderTopping->topping_id == $topping->id) {
                    $orderTopping->name = $topping->name;
                }
            }
        }

        foreach ($orderItems as $orderItem) {
            foreach ($orderToppings as $orderTopping) {
                if ($orderItem->id == $orderTopping->order_item_id) {
                }
            }
        }

        return view('purchase-history')->with(['orders' => $orders, 'orderItems' => $orderItems, 'orderToppings' => $orderToppings]);
    }

    public function cvsExport()
    {
        $date = Carbon::now(); // 現在時刻

        $response = new StreamedResponse(function () {

            //orderクラスのcsvHeaderメソッドを使用するためにインスタンス化
            $order = new Order();
            //ファイルに書き込みできるようにする
            $stream = fopen('php://output', 'w');
            //DBから商品のレコードを全件配列として取得する。
            $query = Order::query();
            $orders = $query->get()->toArray();

            // 文字化け回避（第2引数に下記を指定することで、マルチバイト文字が入っていても文字化けがでないように対策）
            stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');

            // ヘッダー行を追加
            fputcsv($stream, $order->csvHeader());

            foreach ($orders as $order) {
                fputcsv($stream, $order);
            }
            fclose($stream);

            //期間を指定するために必要。
            // $results = $items->getCsvData($post['start_date'], $post['end_date']);
            // if (empty($results[0])) {
            //     fputcsv($stream, [
            //         'データが存在しませんでした。',
            //     ]);
            // } else {
            //     foreach ($results as $row) {
            //         fputcsv($stream, $items->csvRow($row));
            //     }
            // }
            // fclose($stream);
        });

        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('content-disposition', 'attachment; filename=' . $date .  '注文履歴一覧.csv');
        return $response;
    }
}
