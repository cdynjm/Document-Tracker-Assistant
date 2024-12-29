<table class="table align-items-center mb-0" id="user-account-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="5%">
                #
            </th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Account Name
            </th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Office Name
            </th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Action
            </th>
        </tr>
    </thead>
    <tbody>
        
        {{-- Group Users by Office --}}
        @foreach ($userAccounts as $officeID => $users)

        @php
            $count = 1;
        @endphp

            {{-- Display Office Header --}}
            <tr>
                <td colspan="4" class="bg-light text-start font-weight-bolder">
                    {{ $users->first()->Section->Office->office ?? 'Unassigned Office' }}
                </td>
            </tr>

            {{-- Loop Through Users Under Each Office --}}
            @foreach ($users->sortBy('name') as $ua)
                <tr>
                    <td class="text-center text-sm"
                        id="{{ $aes->encrypt($ua->id) }}"
                        name="{{ $ua->name }}"
                        section="{{ $aes->encrypt($ua->sectionID) }}"
                        email="{{ $ua->email }}"
                        special="{{ $ua->special }}"
                        >
                        {{ $count }}
                    </td>
                    <td>
                        <a wire:navigate href="{{ route('user-logs-history', ['id' => $aes->encrypt($ua->id)]) }}?key={{ \Str::random(50) }}">

                        <div class="d-flex px-2 py-1" title="View User Logs" data-toggle="tooltip">
                                <div>
                                    <img src="{{ asset('assets/profile.png') }}"
                                        class="avatar avatar-sm me-3" alt="user1">
                                </div>
                            
                            <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $ua->name }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $ua->email }}</p>
                                
                            </div>
                        </div>
                    </a>
                    </td>
                    <td>
                        <a>
                            <h6 class="mb-1 mt-1 text-sm">{{ $ua->Section->Office->office ?? 'Unassigned Office' }}</h6>
                            <p class="text-sm text-secondary mb-0">{{ $ua->Section->section ?? 'Unassigned Section' }}</p>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="javascript:;" id="edit-user-account" class="text-secondary font-weight-bold text-xs me-2"
                            data-toggle="tooltip">
                            <i class="fas fa-pen-alt text-sm"></i>
                        </a>
                        <a href="javascript:;" id="delete-user-account" class="text-secondary font-weight-bold text-xs"
                            data-toggle="tooltip">
                            <i class="fas fa-trash-alt text-sm"></i>
                        </a>
                    </td>
                </tr>
                @php
                    $count += 1;
                @endphp
            @endforeach
        @endforeach
    </tbody>
</table>
