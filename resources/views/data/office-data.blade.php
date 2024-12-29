<table class="table table-hover align-items-center mb-0" id="office-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="5%">
                #</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Office Name</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
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

                <td class="text-sm"
                id="{{ $aes->encrypt($of->id) }}"
                office="{{ $of->office }}"
                >
                    <span class="ms-3">
                        {{ $of->office }}
                    </span>
                </td>
                <td class="text-center">
                    <a href="javascript:;" id="edit-office" class="text-secondary font-weight-bold text-xs me-2"
                        data-toggle="tooltip">
                        <i class="fas fa-pen-alt text-sm"></i>
                    </a>
                    <a href="javascript:;" id="delete-office" class="text-secondary font-weight-bold text-xs"
                        data-toggle="tooltip">
                        <i class="fas fa-trash-alt text-sm"></i>
                    </a>
                </td>
            </tr>
            @php
                $count += 1;
            @endphp
        @endforeach
    </tbody>
</table>