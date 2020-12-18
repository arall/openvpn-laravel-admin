<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('user'), 'password' => $request->input('password')])) {
            return response('ok', 200);
        } else {
            return response('ko', 403);
        }
    }

    public function connect(Request $request)
    {
        $user = User::where('email', $request->input('user'))->firstOrFail();

        $user->logs()->create([
            'client_ip' => $request->input('client_ip'),
            'client_port' => $request->input('client_port'),
            'remote_ip' => $request->input('remote_ip'),
            'remote_port' => $request->input('remote_port'),
            'bytes_received' => $request->input('bytes_received'),
            'bytes_sent' => $request->input('bytes_sent'),
        ]);

        $user->setOnline();

        return response('ok', 200);
    }

    public function disconnect(Request $request)
    {
        $user = User::where('email', $request->input('user'))->firstOrFail();

        $log = $user->logs()->active(true)->where('remote_ip', $request->input('remote_ip'))->firstOrFail();

        $log->bytes_received = $request->input('bytes_received');
        $log->bytes_sent = $request->input('bytes_sent');
        $log->end_time = Carbon::now();
        $log->save();

        if ($user->logs()->whereNull('end_time')->doesntExist()) {
            $user->setOffline();
        }

        return response('ok', 200);
    }
}
