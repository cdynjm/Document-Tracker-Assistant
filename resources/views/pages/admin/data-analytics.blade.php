@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Data Analytics'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-radius-md">
                    <div class="card-header rounded-sm">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-3 text-sm text-dark me-3">Stations with Highest Average Time for Document Processing | <b>MONTHLY</b></h5>
                            </div>
                        </div>

                        <!-- Add Month and Year Select -->
                        <div class="d-flex justfiy-content-between align-items-center">
                            <!-- Month Select -->
                            <select id="month-select" class="form-select me-2">
                                <option value="01" {{ date('m') == 1 ? 'selected' : '' }}>January</option>
                                <option value="02" {{ date('m') == 2 ? 'selected' : '' }}>February</option>
                                <option value="03" {{ date('m') == 3 ? 'selected' : '' }}>March</option>
                                <option value="04" {{ date('m') == 4 ? 'selected' : '' }}>April</option>
                                <option value="05" {{ date('m') == 5 ? 'selected' : '' }}>May</option>
                                <option value="06" {{ date('m') == 6 ? 'selected' : '' }}>June</option>
                                <option value="07" {{ date('m') == 7 ? 'selected' : '' }}>July</option>
                                <option value="08" {{ date('m') == 8 ? 'selected' : '' }}>August</option>
                                <option value="09" {{ date('m') == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ date('m') == 10 ? 'selected' : '' }}>October</option>
                                <option value="11" {{ date('m') == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ date('m') == 12 ? 'selected' : '' }}>December</option>
                            </select>
                            
                            <!-- Year Select (PHP to generate years) -->
                            <select id="year-select" class="form-select">
                                @php
                                    // Get the current year
                                    $currentYear = date('Y');
                                @endphp
                                
                                @for ($year = 2024; $year <= $currentYear; $year++)
                                    <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                            <a href="javascript:;" class="nav-link cursor-pointer text-secondary" id="search-month-year">
                                <iconify-icon icon="si:search-fill" width="30" height="30"></iconify-icon>
                            </a>
                            
                        </div>

                    </div>
                    
                    <div class="card-body">
                        
                        @include('data.data-analytics')
                        
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
