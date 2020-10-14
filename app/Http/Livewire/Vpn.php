<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Hash;
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
        // TEST
        return response()->download(base_path('.gitignore'));
    }
}
