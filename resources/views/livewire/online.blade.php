<div wire:poll.visible.10s>
    <div class="user-list">
        @forelse($onlineUsers as $user)
            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                <div style="position: relative; margin-right: 0.75rem;">
                    <img src="{{ asset('assets/profile.png') }}" 
                         style="width: 40px; height:40px; padding: 3px; border-radius: 50%; object-fit: cover; border: 2px solid rgb(20, 103, 129)">
                         
                    <!-- Show status indicator only if last active is more than or equal to 1 minute ago -->
                    @if($user->last_active_time == 'Online')
                        <span style="position: absolute; bottom: 0; right: 0; width: 14px; height: 14px; background-color: #31a24c; border: 2px solid white; border-radius: 50%;"></span>
                    @endif
                </div>
                <div>
                    <h6 style="margin-bottom: 0; font-size: 0.875rem;">{{ $user->name }}</h6>
                    <!-- Display last active time, either in minutes or hours -->
                    <small style="color: #6c757d;">
                        {{ $user->last_active_time != 'Online' ? 'Active '. $user->last_active_time : '' }}
                    </small>
                </div>
            </div>
        @empty
            <div style="text-align: center; color: #6c757d; padding: 0.75rem;">
                No users online
            </div>
        @endforelse
    </div>
</div>
