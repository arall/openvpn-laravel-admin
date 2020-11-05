<?php

namespace App\Http\Livewire\Admin\Users;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UsersList extends Component
{
    use WithPagination;

    /**
     * Search query
     *
     * @var string
     */
    public $search = '';

    /**
     * Online filter
     *
     * @var bool
     */
    public $isOnline = 0;

    /**
     * Render the view.
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.admin.users.list', [
            'users' => User::search($this->search)->online($this->isOnline)->paginate(5),
        ]);
    }
}
