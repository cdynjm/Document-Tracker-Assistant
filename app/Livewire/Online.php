<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class Online extends Component
{
    public $onlineUsers = [];

    public function mount()
    {
        $this->getOnlineUsers();
    }

    public function getOnlineUsers()
    {
        // Fetch users who are online or have recent activity within 5 hours
        $this->onlineUsers = User::all()->filter(function ($user) {
            $cacheKey = 'user-online-' . $user->id;
    
            if (Cache::has($cacheKey)) {
                return true; // User is online
            }
    
            $cachedTime = Cache::get($cacheKey);
            if ($cachedTime instanceof DateTimeInterface || is_string($cachedTime)) {
                $cachedTime = now()->parse($cachedTime);
                return now()->diffInHours($cachedTime) <= 8; // Recently active
            }
    
            return false;
        })->map(function ($user) {
            $cacheKey = 'user-online-' . $user->id;
            $cachedTime = Cache::get($cacheKey);
    
            // Calculate the "last active" status
            if ($cachedTime) {
                $minutes = now()->diffInMinutes(now()->parse($cachedTime));
                $hours = now()->diffInHours(now()->parse($cachedTime));
    
                if ($hours > 0) {
                    $user->last_active_time = $hours . 'h ago';
                } elseif ($minutes >= 5) {
                    $user->last_active_time = $minutes . ' min ago';
                } else {
                    $user->last_active_time = 'Online'; // User is online
                }
            } else {
                $user->last_active_time = '5+ hours'; // Fallback for users who were last active more than 5 hours ago
            }
    
            return $user;
        });
    }

    public function refreshOnlineUsers()
    {
        User::all()->each(function ($user) {
            $cacheKey = 'user-online-' . $user->id;

            if (Cache::has($cacheKey)) {
                $cachedTime = Cache::get($cacheKey);

                if ($cachedTime instanceof DateTimeInterface || is_string($cachedTime)) {
                    $cachedTime = now()->parse($cachedTime);
                    if (now()->diffInMinutes($cachedTime) < 500) {
                        Cache::put($cacheKey, now(), now()->addMinutes(500));
                    }
                }
            }
        });
    }

    public function render()
    {
        // Refresh the cache and update the online users list on every poll
        $this->refreshOnlineUsers();
        $this->getOnlineUsers();

        return view('livewire.online', [
            'onlineUsers' => $this->onlineUsers
        ]);
    }
}
