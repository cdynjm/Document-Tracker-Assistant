<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\RecentLogs;
use Carbon\Carbon;

class SystemLogs extends Component
{
    public $recentLogs;
    public $filterDate;

    public function mount()
    {
        $this->filterDate = Carbon::now()->toDateString();
        $this->fetchRecentLogs();
    }

    public function updatedFilterDate() 
    {
        $this->fetchRecentLogs();
    }

    public function fetchRecentLogs()
    {
        $this->recentLogs = RecentLogs::query()
            ->when($this->filterDate, function ($query) {
                $query->whereDate('updated_at', $this->filterDate);
            })
            ->orderBy('updated_at', 'DESC')
            ->limit(200)
            ->get();
    }

    public function render()
    {
        return view('livewire.system-logs', [
            'recentLogs' => $this->recentLogs
        ]);
    }
}