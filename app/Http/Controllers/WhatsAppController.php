<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Notifications\NewUserNotification;
use App\Services\UserServices;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    public function __construct(protected  UserServices $userServices)
    {}

    public function newMessage(Request $request)
    {
        $phone = "+" . $request->post('WaId');

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            $user = $this->userServices->store($request->all());
        }

        $user->notify(new NewUserNotification($user->name, 'cs_test_a1alksakldaksldlasldlasldalsdlaalsdaldldks'));
    }
}
