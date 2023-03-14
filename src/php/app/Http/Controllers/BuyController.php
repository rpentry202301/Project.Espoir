<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Topping;
use App\Models\OrderTopping;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Payjp\Charge;
use App\Exceptions\BuyException;
use App\Models\Ipcontent;

class BuyController extends Controller
{
    public function showBuyForm()
    {
        // 既にカートに商品が存在しているかどうか判別。
        session_start();
        //セッションを切りたくなったら
        // unset($_SESSION["orderItemList"]);
        // unset($_SESSION["orderToppingList"]);
        $priceIncludeTax = 0;
        if (isset($_SESSION['orderItemList'])) {
            $orderItemList = $_SESSION['orderItemList'];
            foreach ($orderItemList as $orderItem) {
                $priceIncludeTax += $orderItem->customed_price * $orderItem->quantity;
            }
        } else {
            $orderItemList = array();
        }

        if (isset($_SESSION['orderToppingList'])) {
            $orderToppingList = $_SESSION['orderToppingList'];
            foreach ($orderToppingList as $orderTopping) {
            }
        } else {
            $orderToppingList = array();
        }

        return view('buy-form', ['orderItemList' => $orderItemList, 'orderToppingList' => $orderToppingList, 'priceIncludeTax' => $priceIncludeTax]);
    }

    public function buyOrderItems(Request $request)
    {
        $token = $request->input('card-token');
        try {
            if ($token == null) {
                $token = 0;
            }
            $this->settlement($token, $request);
        } catch (BuyException $e) {
            return redirect()->back()
                ->with('type', 'danger')
                ->with('message', 'カートに商品が追加されていません');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()
                ->with('type', 'danger')
                ->with('message', '購入処理が失敗しました。');
        }
        // 購入完了したらIPContentをランダムで一つ、ユーザーに付与する
        $user = Auth::user();
        $IPContent = Ipcontent::inRandomOrder()->first();
        $user->ipcontents()->sync($IPContent->id,false);

        return redirect()->back()->with('status', '購入完了しました');
    }

    private function settlement($token, $request)
    {
        DB::beginTransaction();

        try {
            //orderをテーブルにinsert
            $order = new Order();
            $order->user_id = Auth::id();
            $order->delivery_destination_id; #TODO delivery_destinationsのidをもってくる。もしformで選択されていなかったらnullが入るようにする。
            $order->price_include_tax = $request->price_include_tax;
            $order->order_date = Carbon::now();
            $order->delivery_destination_name = $request->delivery_destination_name;
            $order->zipcode = $request->zipcode;
            $order->address = $request->address;
            $order->telephone = $request->telephone;
            $order->payment_method = $request->payment_method;
            $order->save();

            //もし商品がカートに存在しない場合
            if ($request->item_id == null) {
                throw new BuyException;
            }

            //order_itemをテーブルにinsert。orderItemListを1回回している中に、orderToppingListをn回回す必要があると思う。
            for ($i = 0; $i < count($request->onetime_id); $i++) {
                $orderItem = new OrderItem();
                $orderItem->item_id = $request->item_id[$i];
                $orderItem->order_id = DB::table('orders')->latest('id')->value('id');
                $orderItem->customed_price = $request->customed_price[$i];
                $orderItem->quantity = $request->quantity[$i];
                $orderItem->save();

                //order_toppingをテーブルにinsert
                if ($request->topping_id != null) {
                    for ($j = 0; $j < count($request->topping_id); $j++) {
                        if ($request->order_item_id[$j] == $request->onetime_id[$i]) {
                            $orderTopping = new OrderTopping();
                            $orderTopping->order_item_id = DB::table('order_items')->latest('id')->value('id');
                            $orderTopping->topping_id = $request->topping_id[$j];
                            $orderTopping->save();
                        }
                    }
                }
            }

            if ($token != 0) {
                $charge = Charge::create([
                    'card'     => $token,
                    'amount'   => $request->price_include_tax,
                    'currency' => 'jpy'
                ]);
                if (!$charge->captured) {
                    throw new \Exception('支払い確定失敗');
                }
            }

            //セッションを切って、カートの中を空にする
            session_start();
            unset($_SESSION["orderItemList"]);
            unset($_SESSION["orderToppingList"]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }
}
