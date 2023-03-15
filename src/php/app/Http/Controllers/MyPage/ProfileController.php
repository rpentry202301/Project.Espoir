<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mypage\Profile\EditRequest;
use App\Http\Requests\Mypage\Profile\DestinationEditRequest;
use App\Models\DeliveryDestination;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    // プロフィール編集フォーム
    public function showProfileEditForm()
    {
        $user = Auth::user();

        return view('mypage.profile_edit_form')->with([
            'user' => $user,
        ]);
    }

    // プロフィール編集
    public function editProfile(EditRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->save();

        return redirect()->back()
            ->with('status', 'プロフィールを変更しました。');
    }

    // お届け先一覧画面
    public function showDestinationList()
    {
        $user = Auth::user();

        $deliverydestinations = DeliveryDestination::where('user_id', $user->id)->orderBy('id', 'ASC')->get();

        return view('mypage.destination_list')
            ->with('deliverydestinations', $deliverydestinations);
    }

    // お届け先編集フォーム
    public function showDestinationEditForm(DeliveryDestination $deliverydestination)
    {
        return view('mypage.destination_edit_form')
            ->with('deliverydestination', $deliverydestination);
    }

    // お届け先編集
    public function editDestination(DestinationEditRequest $request)
    {
        $deliverydestination_id = $request->input('id');
        $deliverydestination = DeliveryDestination::where('id', $deliverydestination_id)->first();

        $deliverydestination->user_id = Auth::id();
        $deliverydestination->delivery_destination_name = $request->input('delivery_destination_name');
        $deliverydestination->zipcode = $request->input('zipcode');
        $deliverydestination->address = $request->input('address');
        $deliverydestination->telephone = $request->input('telephone');

        $deliverydestination->save();

        return redirect('/mypage/destination-list')
            ->with('status', 'お届け先を編集しました。');
    }

    // お届け先登録フォーム
    public function showDestinationRegisterForm()
    {
        $this_url = url()->previous();
        return view('mypage.destination_register_form')
            ->with('this_url', $this_url);
    }

    // お届け先登録
    public function registerDestination(DestinationEditRequest $request)
    {
        $this_url = $request->input('this_url');

        $deliverydestination = new DeliveryDestination();

        $deliverydestination->user_id = Auth::id();
        $deliverydestination->delivery_destination_name = $request->input('delivery_destination_name');
        $deliverydestination->zipcode = $request->input('zipcode');
        $deliverydestination->address = $request->input('address');
        $deliverydestination->telephone = $request->input('telephone');

        $deliverydestination->save();

        return redirect($this_url)
            ->with('status', 'お届け先を登録しました。');
    }

    // お届け先削除
    public function destroy($id)
    {
        $deliverydestination = DeliveryDestination::find($id);
        $deliverydestination->delete();
        return redirect()->route('mypage.destination-list');
    }
}
