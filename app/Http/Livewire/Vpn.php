<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Vpn extends Component
{
    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [
        'password' => '',
        'password_confirmation' => ''
    ];

    public $showPassword = false;
    public $newPassword = null;

    protected $rules = [
        'password' => 'required', 'string', 'min:12', 'confirmed',
    ];

    public function render()
    {
        $this->newPassword = Session::pull('password');

        if ($this->newPassword) {
            $this->showPassword = true;
        }

        return view('livewire.vpn.show');
    }

    public function updatePassword()
    {
        $this->resetErrorBag();

        Validator::make($this->state, [
            'password' => $this->rules,
        ])->validateWithBag('updatePassword');

        auth()->user()->fill([
            'password' => Hash::make($this->state['password']),
        ])->save();

        $this->state = [
            'password' => '',
            'password_confirmation' => '',
        ];

        $this->emit('saved');
    }

    public function download()
    {
        $path = getenv('VPN_CLIENT_CONFIG_PATH');
        return response()->download($path, 'config.ovpn');
    }
}
