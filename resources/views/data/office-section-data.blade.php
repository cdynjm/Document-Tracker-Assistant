<table class="table table-hover align-items-center mb-0" id="office-section-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="5%">
                #</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="10%">
                Office</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Section Name</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 1;
        @endphp
        @foreach ($offices as $of)
            <tr>
                <td class="text-center text-sm">{{ $count }}</td>

                <td colspan="3" class="text-sm fw-bolder">
                    <span class="ms-3">
                        {{ $of->office }}
                    </span>
                </td>
            </tr>
            @foreach ($sections as $sec)
                @if($sec->officeID == $of->id)
                <tr>
                    <td class="text-center text-sm"></td>
                    <td class="text-center text-sm"></td>
                    <td colspan="" class="text-sm"
                    id="{{ $aes->encrypt($sec->id) }}"
                    officeID="{{ $aes->encrypt($sec->officeID) }}"
                    section="{{ $sec->section }}"
                    >
                        <span class="ms-3">
                            {{ $sec->section }}
                        </span>
                    </td>
                    <td class="text-center text-sm">
                        <a href="javascript:;" id="edit-section" class="text-secondary font-weight-bold text-xs me-2"
                            data-toggle="tooltip">
                            <i class="fas fa-pen-alt text-sm"></i>
                        </a>
                        <a href="javascript:;" id="delete-section" class="text-secondary font-weight-bold text-xs"
                            data-toggle="tooltip">
                            <i class="fas fa-trash-alt text-sm"></i>
                        </a>
                    </td>
                </tr>
                @endif
            @endforeach
            @php
                $count += 1;
            @endphp
        @endforeach
    </tbody>
</table>