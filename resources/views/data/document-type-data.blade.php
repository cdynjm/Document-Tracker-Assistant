<table class="table table-hover align-items-center mb-0" id="document-type-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="5%">
                #</th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Document Type</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Action</th>
        </tr>
    </thead>
    <tbody>
       @php
           $count = 1;
       @endphp
       @foreach ($docType as $dt)
           <tr>
                <td id="{{ $aes->encrypt($dt->id) }}" class="text-center text-sm">{{ $count++ }}</td>
                <td class="fw-bold text-sm">
                    <div class="d-flex align-items-center">
                        <iconify-icon icon="line-md:my-location-loop" width="22" height="22" class="me-1"></iconify-icon> <div>{{ $dt->name }}</div>
                    </div>
                </td>
                <td class="text-center">
                    <a wire:navigate href="{{ route('edit-document-type', ['id' => $aes->encrypt($dt->id)]) }}?key={{ \Str::random(50) }}" class="text-secondary font-weight-bold text-xs me-2"
                        data-toggle="tooltip">
                        <i class="fas fa-pen-alt text-sm"></i>
                    </a>
                    <a href="javascript:;" id="delete-document-type" class="text-secondary font-weight-bold text-xs"
                        data-toggle="tooltip">
                        <i class="fas fa-trash-alt text-sm"></i>
                    </a>
                </td>
           </tr>
       @endforeach
    </tbody>
</table>