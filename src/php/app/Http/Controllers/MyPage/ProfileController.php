<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Mypage\Profile\EditRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\DeliveryDestination;

class ProfileController extends Controller
{
    public function showProfileEditForm()
    {
        return view('mypage.profile_edit_form');
        // ->with('user', Auth::user());
    }

    public function editProfile(EditRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->save();

        $user_id = Auth::id();
        $delivery_destination_name = $request->input('delivery_destination_name');

        $deliverydestination = DeliveryDestination::where('delivery_destination_name', $delivery_destination_name)->first();
        // dd($deliverydestination);
        if ($deliverydestination == null) {
            $deliverydestination = new DeliveryDestination();
        }
        $deliverydestination->user_id = Auth::id();
        $deliverydestination->delivery_destination_name = $request->input('delivery_destination_name');
        $deliverydestination->zipcode = $request->input('zipcode');
        $deliverydestination->address = $request->input('address');
        $deliverydestination->telephone = $request->input('telephone');
        $deliverydestination->save();

        return redirect()->back()
            ->with('status', 'プロフィールを変更しました。');
    }
}
