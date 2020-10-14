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

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->state = auth()->user()->withoutRelations()->toArray();
    }

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
        // Include the cert, key and ca
        $data = file_get_contents(base_path('openvpn/clients/viscosity/client.ovpn'));
        $key = file_get_contents(base_path('openvpn/clients/pki/server.key'));
        $ca = file_get_contents(base_path('openvpn/clients/pki/ca.crt'));
        $crt = file_get_contents(base_path('openvpn/clients/pki/server.crt'));
        $data = str_replace('##KEY##', $key, $data);
        $data = str_replace('##CA##', $ca, $data);
        $data = str_replace('##CERT##', $crt, $data);

        return response()->streamDownload(function () use ($data) {
            echo $data;
        }, 'config.ovpn');
    }
}
