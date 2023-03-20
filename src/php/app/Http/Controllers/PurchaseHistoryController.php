<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\OrderTopping;
use App\Models\Topping;
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
        if (Auth::id() == 1) {
            $orders = DB::table('orders')->orderBy('id')->get();
        } else {
            $orders = DB::table('orders')->where('user_id', Auth::id())->orderBy('id')->get();
        }

        foreach ($orders as $order) {
            if ($order->payment_method == 1) {
                $order->payment_method = '店頭受け取り';
            } else if ($order->payment_method == 2) {
                $order->payment_method = 'クレジットカード';
            }
        }

        foreach ($orders as $order) {
            $zipcode = $order->zipcode;
            $zip1    = substr($zipcode, 0, 3);
            $zip2    = substr($zipcode, 3);
            $zipcode = $zip1 . "-" . $zip2;
            $order->zipcode = $zipcode;
        }

        $users = DB::table('users')->get();
        foreach ($orders as $order) {
            foreach ($users as $user) {
                if ($user->id == $order->user_id) {
                    $order->user_id = $user->name;
                }
            }
        }
        $user = DB::table('users')->where('id', Auth::id())->first();

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

        return view('purchase-history')->with(['orders' => $orders, 'orderItems' => $orderItems, 'orderToppings' => $orderToppings, 'user' => $user]);
    }

    public function csvExportOrder()
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


            foreach ($orders as $key => $onetime_order) {
                $zipcode = $onetime_order['zipcode'];
                $zip1    = substr($zipcode, 0, 3);
                $zip2    = substr($zipcode, 3);
                $zipcode = $zip1 . "-" . $zip2;
                $orders[$key]['zipcode'] = $zipcode;
            }

            foreach ($orders as $key => $onetime_order) {
                if ($onetime_order['payment_method'] == 1) {
                    $orders[$key]['payment_method'] = '店頭受け取り';
                } else if ($onetime_order['payment_method'] == 2) {
                    $orders[$key]['payment_method'] = 'クレジットカード';
                }
            }

            // 文字化け回避（第2引数に下記を指定することで、マルチバイト文字が入っていても文字化けがでないように対策）
            stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');

            // ヘッダー行を追加
            fputcsv($stream, $order->csvHeader());

            foreach ($orders as $order) {
                fputcsv($stream, $order);
            }
            fclose($stream);

            //期間を指定するために必要。
            // $results = $orders->getCsvData($post['start_date'], $post['end_date']);
            // if (empty($results[0])) {
            //     fputcsv($stream, [
            //         'データが存在しませんでした。',
            //     ]);
            // } else {
            //     foreach ($results as $row) {
            //         fputcsv($stream, $orders->csvRow($row));
            //     }
            // }
            // fclose($stream);
        });

        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('content-disposition', 'attachment; filename=' . $date .  '購入履歴一覧.csv');
        return $response;
    }

    public function csvExportItem()
    {
        $date = Carbon::now(); // 現在時刻

        $response = new StreamedResponse(function () {

            //orderクラスのcsvHeaderメソッドを使用するためにインスタンス化
            $orderItem = new OrderItem();
            //ファイルに書き込みできるようにする
            $stream = fopen('php://output', 'w');
            //DBから商品のレコードを全件配列として取得する。
            $query = OrderItem::query();
            $orderItems = $query->get()->toArray();
            $items = Item::query()->get();
            foreach ($orderItems as $key => $onetime_orderItem) {
                foreach ($items as $item) {
                    if ($item->id == $onetime_orderItem['item_id']) {
                        $orderItems[$key]['item_id'] = $item->name;
                        $orderItems[$key]['price'] = $item->price;
                    }
                }
            }

            // 文字化け回避（第2引数に下記を指定することで、マルチバイト文字が入っていても文字化けがでないように対策）
            stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');

            // ヘッダー行を追加
            fputcsv($stream, $orderItem->csvHeader());

            foreach ($orderItems as $orderItem) {
                fputcsv($stream, $orderItem);
            }
            fclose($stream);
        });

        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('content-disposition', 'attachment; filename=' . $date .  '購入商品一覧.csv');
        return $response;
    }

    public function csvExportTopping()
    {
        $date = Carbon::now(); // 現在時刻

        $response = new StreamedResponse(function () {

            //orderクラスのcsvHeaderメソッドを使用するためにインスタンス化
            $orderTopping = new OrderTopping();
            //ファイルに書き込みできるようにする
            $stream = fopen('php://output', 'w');
            //DBから商品のレコードを全件配列として取得する。
            $query = OrderTopping::query();
            $orderToppings = $query->get()->toArray();
            $toppings = Topping::query()->get();
            foreach ($orderToppings as $key => $onetime_orderTopping) {
                foreach ($toppings as $topping) {
                    if ($topping->id == $onetime_orderTopping['topping_id']) {
                        $orderToppings[$key]['topping_id'] = $topping->name;
                        $orderToppings[$key]['price'] = $topping->price;
                    }
                }
            }

            // 文字化け回避（第2引数に下記を指定することで、マルチバイト文字が入っていても文字化けがでないように対策）
            stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');

            // ヘッダー行を追加
            fputcsv($stream, $orderTopping->csvHeader());

            foreach ($orderToppings as $orderTopping) {
                fputcsv($stream, $orderTopping);
            }
            fclose($stream);
        });

        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('content-disposition', 'attachment; filename=' . $date .  '購入トッピング一覧.csv');
        return $response;
    }

    public static function recommendItem(int $itemId)
    {
        //該当の商品が購入されているorderItemを取得する
        $originItemList = DB::table('order_items')->where('item_id', $itemId)->get();
        $recommendItemList = array();

        $orderItems = DB::table('order_items')->get();
        $items = DB::table('items')->get();
        foreach ($orderItems as $orderItem) {
            //注文商品に商品名と画像データを入れるためのループ
            foreach ($items as $item) {
                if ($orderItem->item_id == $item->id) {
                    $orderItem->name = $item->name;
                    $orderItem->image_file = $item->image_file;
                }
            }

            //同時に買われていること＝同じOrderのidであるかどうか判別するループ
            foreach ($originItemList as $originItem) {
                //リコメンド商品と同様の商品は省く処理
                if ($orderItem->item_id == $originItem->item_id) {
                    continue;
                }

                if ($orderItem->order_id == $originItem->order_id) {
                    $recommendItemList[] = $orderItem;
                }
            }
        }
        //重複しているリコメンド商品を削除する
        $recommendItemCollection = collect($recommendItemList);
        $recommendItemCollection = $recommendItemCollection->unique('item_id');
        return $recommendItemCollection;
    }
}
