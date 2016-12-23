@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel {{ $is_admin ? 'panel-info' : 'panel-primary' }}">
                <div class="panel-heading">
                    <i class="fa fa-ambulance"></i>
                    סידור משמרות אמבולנס
                    <strong>{{ $is_admin ? '- מנהל סידור' : '' }}</strong>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>תאריך</th>
                            <th>יום</th>
                            <th>לילה</th>
                            <th>בוקר</th>
                            <th>ערב</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shifts as $shift)
                        <tr data-date="{{ $shift['date'] }}">
                            <td class="{{ $shift['shift1']['saturday'] ? 'active' : '' }}">{{ $shift['date_without_year'] }}</td>
                            <td class="{{ $shift['shift1']['saturday'] ? 'active' : '' }}">{{ $shift['day_of_week'] }}</td>
                            <td class="shift1 {{ $shift['shift1']['saturday'] ? 'active' : '' }}">
                                @foreach($shift['shift1']['users'] as $shift_user)
                                    @if ($shift_user['status'] == 1 || $is_admin || $current_user_id == $shift_user['user_id'])
                                        <button data-user="{{ $shift_user['user_id'] }}" class="btn {{ $shift_user['status'] ? 'btn-success' : 'btn-danger' }} btn-xs">
                                            {{ $shift_user['name'] }}
                                        </button>
                                    @endif
                                @endforeach
                            </td>
                            <td class="shift2 {{ $shift['shift2']['saturday'] ? 'active' : '' }}">
                                @foreach($shift['shift2']['users'] as $shift_user)
                                    @if ($shift_user['status'] == 1 || $is_admin || $current_user_id == $shift_user['user_id'])
                                        <button data-user="{{ $shift_user['user_id'] }}" class="btn {{ $shift_user['status'] ? 'btn-success' : 'btn-danger' }} btn-xs">
                                            {{ $shift_user['name'] }}
                                        </button>
                                    @endif
                                @endforeach
                            </td>
                            <td class="shift3 {{ $shift['shift3']['saturday'] ? 'active' : '' }}">
                                @foreach($shift['shift3']['users'] as $shift_user)
                                    @if ($shift_user['status'] == 1 || $is_admin || $current_user_id == $shift_user['user_id'])
                                        <button data-user="{{ $shift_user['user_id'] }}" class="btn {{ $shift_user['status'] ? 'btn-success' : 'btn-danger' }} btn-xs">
                                            {{ $shift_user['name'] }}
                                        </button>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.isAdmin = {{ $is_admin ? 'true' : 'false' }};
</script>
@endsection
