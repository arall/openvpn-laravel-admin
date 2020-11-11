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
     * @var string
     */
    public $sortField = 'id';

    /**
     * @var string
     */
    public $sortDirection = 'asc';

    /**
     * @var string[]
     */
    public $queryString = ['sortField', 'sortDirection'];

    /**
     * Render the view.
     *
     * @return View
     */
    public function render()
    {
        $query = User::search($this->search);

        if ($this->isOnline) {
            $query->online($this->isOnline);
        }

        return view('livewire.admin.users.list', [
            'users' => $query->orderBy($this->sortField, $this->sortDirection)->paginate(5),
            'total' => User::all()->count(),
            'online' => User::online(1)->count(),
            'offline' => User::online(0)->count(),
        ]);
    }

    /**
     * Sort columns.
     *
     * @param $field
     */
    public function sortBy($field)
    {
        if ($this->sortField == $field) {
            $this->sortDirection = $this->sortDirection ===  'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }
}
