@php
    use App\Models\User;
   
    use App\Models\Documents;
    
    $offices = User::where(['role' => 2])->get();

@endphp

<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-md my-3 fixed-start ms-4" style="position: fixed; z-index: 600;"
    id="sidenav-main">
    <div class="sidenav-header bg-white rounded" style="position: fixed; padding-bottom: 100px; padding-right: 7.5px; z-index: 1" >
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a wire:navigate class="align-items-center d-flex mt-3" href="/">
            <img style="width: 50px; height: 50px;" src="{{ asset('Province-Logo.png') }}" class="ms-4 mb-4 mt-2" alt="...">
            <span class="ms-3 sidebar-text fw-bolder fs-4">
                DoTA
            <p style="font-size: 11px;">Document Tracking Assistant</p>
          </span>
        </a>
    </div>

    

    @can('accessAdmin', Auth::user())
        <div class="collapse navbar-collapse  w-auto h-auto " style="margin-top: 100px;" id="sidenav-collapse-main">
            <hr class="horizontal dark mt-0">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'admin-dashboard' ? 'active bg-gray text-dark' : '' }}" href="{{ route('admin-dashboard') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <iconify-icon icon="ic:round-dashboard" width="24" height="24" class="text-secondary"></iconify-icon>
                        </div>
                       
                        <span class="nav-link-text ms-1">Dashboard</span>
                        
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'offices' ? 'active bg-gray text-dark' : '' }}" href="{{ route('offices') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <iconify-icon icon="ph:office-chair-duotone" width="24" height="24" class="text-secondary"></iconify-icon>
                        </div>
                        <span class="nav-link-text ms-1">Offices</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'office-sections' ? 'active bg-gray text-dark' : '' }}" href="{{ route('office-sections') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <iconify-icon icon="uim:window-section" width="24" height="24" class='text-secondary'></iconify-icon>
                        </div>
                        <span class="nav-link-text ms-1">Sections</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'office-accounts' ? 'active bg-gray text-dark' : '' }}" href="{{ route('office-accounts') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <iconify-icon icon="fluent:person-accounts-20-filled" width="24" height="24" class="text-secondary"></iconify-icon>
                        </div>
                        <span class="nav-link-text ms-1">Office Accounts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'user-accounts' ? 'active bg-gray text-dark' : '' }}" href="{{ route('user-accounts') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <iconify-icon icon="solar:user-check-rounded-bold-duotone" width="24" height="24" class="text-secondary"></iconify-icon>
                        </div>
                        <span class="nav-link-text ms-1">User Accounts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'document-type' ? 'active bg-gray text-dark' : '' }}" href="{{ route('document-type') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <iconify-icon icon="solar:documents-bold-duotone" width="24" height="24" class="text-secondary"></iconify-icon>
                        </div>
                        <span class="nav-link-text ms-1">Document Type</span>
                    </a>
                </li>
            </ul>
        </div>
    @endcan

    @can('accessOffice', Auth::user())
    <div class="collapse navbar-collapse  w-auto h-auto " style="margin-top: 100px;" id="sidenav-collapse-main">
        <hr class="horizontal dark mt-0">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'office-dashboard' ? 'active bg-gray text-dark' : '' }}" href="{{ route('office-dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <iconify-icon icon="ic:round-dashboard" width="24" height="24" class="text-secondary"></iconify-icon>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'archives' ? 'active bg-gray text-dark' : '' }}" href="{{ route('archives') }}">
                    <div
                        class="icon icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:inbox-archive-bold-duotone" width="24" height="24" class="text-secondary"></iconify-icon>
                    </div>
                    <span class="nav-link-text ms-1">Archives (Completed)</span>
                </a>
            </li>
        </ul>
    </div>
    @endcan

    @can('accessUser', Auth::user())
    <div class="collapse navbar-collapse w-auto h-auto" style="margin-top: 100px;" id="sidenav-collapse-main">
        <hr class="horizontal dark mt-0">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'user-dashboard' ? 'active bg-gray text-dark' : '' }}" href="{{ route('user-dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <iconify-icon icon="ic:round-dashboard" width="24" height="24" class="text-secondary"></iconify-icon>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'batch-documents' ? 'active bg-gray text-dark' : '' }}" href="{{ route('batch-documents') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <iconify-icon icon="material-symbols:cell-merge-rounded" width="24" height="24" class="text-secondary"></iconify-icon>
                    </div>
                    <span class="nav-link-text ms-1">Batch Documents</span>

                    @php
                        // Retrieve documents with specific conditions
                        $documentCount = Documents::where('status', 1)
                            ->where('pending', 0)
                            ->where('download', 1)
                            ->where('merged', 1)
                            ->get();

                        // Group the matching trackers by docType
                        $trackerData = \App\Models\Tracker::whereIn('docType', $documentCount->pluck('docType'))
                            ->where('sectionID', auth()->user()->sectionID)
                            ->get()
                            ->groupBy('docType');

                        $count = 0;

                        // Loop through documents and count matching trackers
                        foreach ($documentCount as $doc) {
                            if (isset($trackerData[$doc->docType])) {
                                foreach ($trackerData[$doc->docType] as $tracker) {
                                    if ($tracker->trackerID == $doc->trackerID) {
                                        $count++;
                                    }
                                }
                            }
                        }
                    @endphp
                    <span class="ms-3">
                        @if ($count > 0)
                        <span class="badge bg-danger">
                            {{ $count }}
                            </span>
                        @endif
                    </span>
                </a>
            </li>

        @if(Auth::user()->special == null)
            <hr class="horizontal dark">
            <li class="nav-item">
                <h6 class="text-xs ms-4">Offices</h6>
            </li>

            @php
                // Find the active office
                $activeOffice = $offices->firstWhere(fn($of) => Request::url() == route('directory-offices', $aes->encrypt($of->id)));
                $remainingOffices = $offices->reject(fn($of) => $of->id === optional($activeOffice)->id);
            @endphp

            @if ($activeOffice)
                <li class="nav-item">
                    <a wire:navigate class="nav-link active bg-gray text-dark fw-normal"
                        href="{{ route('directory-offices', ['id' => $aes->encrypt($activeOffice->id)]) }}?key={{ \Str::random(50) }}">
                        <div
                            class="icon icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <iconify-icon icon="ph:office-chair-fill" width="24" height="24" class="text-secondary"></iconify-icon>
                        </div>
                        <div class="ms-1 text-wrap">
                            <!-- Name -->
                            <span class="nav-link-text text-sm fw-bold d-block">{{ $activeOffice->name }}</span>
                            <!-- Office -->
                            <small class="text-muted d-block">{{ $activeOffice->Office->office }}</small>
                        </div>
                        @php
                          
                            $documentCount = Documents::where(['userID' => $activeOffice->id])->where(['status' => 1])->where('pending', 0)->where('download', null)->get();
                            $dataID = $aes->encrypt($activeOffice->id);
                        @endphp
                        @include('data.count-data')
                    </a>
                </li>
                <hr class="horizontal dark">
            @endif

            @foreach ($remainingOffices->sortBy('name') as $of)
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Request::url() == route('directory-offices', $aes->encrypt($of->id)) ? 'active bg-gray text-dark fw-normal' : '' }}"
                        href="{{ route('directory-offices', ['id' => $aes->encrypt($of->id)]) }}?key={{ \Str::random(50) }}">
                        <div
                            class="icon icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <iconify-icon icon="ph:office-chair-fill" width="24" height="24" class="text-secondary"></iconify-icon>
                        </div>
                        <div class="ms-1 text-wrap">
                            <!-- Name -->
                            <span class="nav-link-text text-sm fw-bold d-block">{{ $of->name }}</span>
                            <!-- Office -->
                            <small class="text-muted d-block">{{ $of->Office->office }}</small>
                        </div>
                        @php
                           
                            $documentCount = Documents::where(['userID' => $of->id])->where(['status' => 1])->where('pending', 0)->where('download', null)->get();
                            $dataID = $aes->encrypt($of->id);
                        @endphp
                        @include('data.count-data')
                    </a>
                </li>
            @endforeach

            @endif
        </ul>
    </div>
@endcan

</aside>
