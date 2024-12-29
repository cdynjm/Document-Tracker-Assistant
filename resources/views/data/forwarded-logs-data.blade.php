<table class="table align-items-center mb-0" id="forwarded-logs-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                #</th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="40%">
                Code</th>
            <th
                class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Type</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Forwarded To</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Source Office</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Date & Time</th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 1;
        @endphp
        @foreach ($user as $us)
            
                <tr>
                    <td class="text-center text-sm">
                    {{ $count }}</td>
                    <td>
                        <div class="d-flex px-2 py-1 text-wrap align-items-center">
                            <div class="me-2">
                                {!! QrCode::size(35)->generate($us->Document->qrcode) !!}
                            </div>
                            
                                <a>
                                    <h6 class="mb-0 text-sm">{{ $us->Document->qrcode }}</h6>
                                </a>
                            
                        </div>
                    </td>
                    <td class="">
                        <span class="text-sm fw-bold">
                            {{ $us->Document->type->name }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($us->sectionID != null)
                            @if($us->pending == 0)
                            <div class="text-center text-sm fw-bolder">
                                {{ $us->Section->section }}
                            
                            </div>
                            
                            <span class="text-xs fw-bold text-dark text-start">
                                @if($us->officeID == null)
                                    From the Source Office
                                @else
                                    Status: Received
                                @endif
                            </span>
                            @else
                            <div class="text-center">
                                <small class="text-danger fw-bold">
                                    En Route to Next Station:
                                </small>
                                <div class="d-flex align-items-center mt-2 justify-content-center">
                                    <img src="{{ asset('storage/images/paper-plane.gif') }}" class="avatar avatar-sm me-2" alt="">
                                <!-- <i class="fas fa-paper-plane text-info text-lg me-3"></i> -->
                                    <div>
                                        <h6 class="mb-0 text-sm">{{ $us->Section->Office->office }}</h6>
                                        <p class="text-sm mb-0">{{ $us->Section->section }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                        @else

                        @if($us->pending == 0)
                            <div class="text-center text-sm fw-bolder">
                                {{ 'Source Office' }}
                            </div>
                            
                            <span class="text-xs fw-bold text-dark text-start">
                                @if($us->officeID == null)
                                    From the Source Office
                                @else
                                    Status: Received
                                @endif
                            </span>
                            @else
                            <div class="text-center">
                                <small class="text-danger fw-bold">
                                    En Route to Next Station:
                                </small>
                                <div class="d-flex align-items-center mt-2 justify-content-center">
                                    <img src="{{ asset('storage/images/paper-plane.gif') }}" class="avatar avatar-sm me-2" alt="">
                                <!-- <i class="fas fa-paper-plane text-info text-lg me-3"></i> -->
                                    <div>
                                        <h6 class="mb-0 text-sm">{{ $us->Document->Office->office }}</h6>
                                        <p class="text-sm mb-0">{{ 'Office Receiver' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                        @endif

                    </td>
                    <td class="text-wrap text-center">
                        <h4 class="text-sm fw-bold text-success">
                            {{ $us->User->name }}
                            <div class="text-xs">
                                {{ $us->User->Office->office }}
                            </div>
                        </h4>
                    </td>
                    <td class="text-center">
                        <span class="text-xs fw-bold">
                            {{ date('M. d, Y | h:i A', strtotime($us->updated_at)) }}
                        </span>
                    </td>
                </tr>
                @php
                    $count += 1;
                @endphp
               
        @endforeach
    </tbody>
</table>