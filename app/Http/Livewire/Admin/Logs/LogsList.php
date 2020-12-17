<?php


namespace App\Http\Livewire\Admin\Logs;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Log;

class LogsList extends Component
{
    use WithPagination;

    /**
     * Active filter
     *
     * @var bool
     */
    public $isActive = 0;

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
        $query = Log::query();

        if ($this->isActive) {
            $query->active($this->isActive);
        }

        return view('livewire.admin.logs.list', [
            'logs' => $query->orderBy($this->sortField, $this->sortDirection)->paginate(20),
            'total' => Log::all()->count(),
            'active' => Log::active(1)->count(),
            'inactive' => Log::active(0)->count(),
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
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }
}
