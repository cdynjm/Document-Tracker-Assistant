<div>
    <div class="d-flex justify-content-between mb-3 mt-0">
        <div>
            <label for="filter-date" class="text-xs text-secondary">Search</label>
            <input 
                type="date" 
                wire:model.live="filterDate" 
                id="filter-date" 
                class="form-control form-control-sm"
            >
        </div>
    </div>
    
    <center>
        <!-- Loading Indicator -->
    <div wire:loading.delay wire:target="filterDate" class="text-center mb-3">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="text-secondary mt-2">Fetching logs...</p>
    </div>
    </center>
    

    <!-- Table Content (will be hidden during loading) -->
    <div wire:loading.delay.remove wire:target="filterDate">
        <div wire:poll.visible.10s="fetchRecentLogs">
            <table class="table align-items-center mb-0 text-nowrap">
                <!-- Rest of the table remains the same -->
                <thead>
                    <tr>
                        <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                        <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Browser</th>
                        <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Device</th>
                        <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Platform</th>
                        <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">IP Address</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Logged On</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @forelse ($recentLogs as $rl)
                        <tr>
                        
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="{{ asset('assets/profile.png') }}"
                                             class="avatar avatar-sm me-3" alt="user1">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $rl->name }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $rl->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-xs fw-normal">{{ $rl->browser }}</td>
                            <td class="text-xs fw-normal text-nowrap text-truncate" style="max-width: 150px;" title="{{ $rl->phone }} - {{ $rl->device }}">
                                {{ $rl->phone }} - {{ $rl->device }}
                            </td>
                            
                            <td class="text-xs fw-normal">{{ $rl->platform }}</td>
                            <td class="text-xs fw-normal">{{ $rl->ip_address }}</td>
                            <td class="text-xs text-center">
                                @if (\Carbon\Carbon::now()->diffInDays($rl->updated_at) >= 2)
                                    {{ date('M. d, Y | h:i A', strtotime($rl->updated_at)) }}
                                @else
                                    {{ \Carbon\Carbon::parse($rl->updated_at)->diffForHumans() }}
                                @endif
                            </td>
                        </tr>
                        @php
                            $count += 1;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary"><small>No logs found for the selected date.</small></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>