@extends('layouts.app')

@section('content')
@if (!$is_admin)
    <style>
        td.shift1,td.shift2,td.shift3 {
            cursor: pointer;
        }
    </style>
@endif
<div class="container">
    <div class="row">
        <div class="{{ $is_admin ? 'col-md-8' : 'col-md-8 col-md-offset-2' }}">
            <div class="panel {{ $is_admin ? 'panel-info' : 'panel-primary' }}">
                <div class="panel-heading">
                    <i class="fa fa-ambulance"></i>
                    @if ($is_admin)
                        אישור משמרות אמבולנס
                        <strong>{{ $is_admin ? '- מנהל סידור' : '' }}</strong>
                    @else
                        טבלת משמרות אמבולנס
                    @endif
                </div>

                <div class="panel-body">
                    @if ($can_admin)
                        @if ($is_admin)
                            <a href="/?next={{ (int) !$is_current_month }}" class="btn btn-primary">מעבר לתצוגה רגילה</a><br /><br />
                        @else
                            <a href="/?admin=1&next={{ (int) !$is_current_month }}" class="btn btn-primary">
                                <i class="fa fa-cog"></i>
                                ניהול משמרות
                            </a><br /><br />
                        @endif
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">תאריך</th>
                            <th class="text-center">יום</th>
                            <th class="text-center">לילה</th>
                            <th class="text-center">בוקר</th>
                            <th class="text-center">ערב</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shifts as $shift)
                        <tr data-date="{{ $shift['date'] }}" class="{{ strtotime($shift['date']) == strtotime(date('j.n.y')) ? 'success' : '' }}">
                            <td style="width: 40px;" class="text-center {{ $shift['shift1']['saturday'] ? 'active' : '' }}">{{ $shift['date_without_year'] }}</td>
                            <td style="width: 40px;" class="text-center {{ $shift['shift1']['saturday'] ? 'active' : '' }}">{{ $shift['day_of_week'] }}</td>
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
                    @if ($is_current_month)
                        <a class="btn btn-primary btn-block" href="/?next=1">
                            למעבר לחודש הבא
                            <i class="fa fa-hand-o-left"></i>
                        </a>
                    @else
                        <a class="btn btn-primary btn-block" href="/">
                            <i class="fa fa-hand-o-right"></i>
                            מעבר לחודש הנוכחי
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @if ($is_admin)
            <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <i class="fa fa-users"></i>
                    כל המשתמשים
                </div>

                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">שם</th>
                            <th class="text-center">טלפון</th>
                            <th class="text-center">פעולות</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="{{$user->is_admin ? 'active' : '' }}">
                                    <td>
                                        @if ($user->is_admin)
                                            <strong>{{ $user->name }}</strong>
                                            <i class="fa fa-ambulance"></i>
                                        @else
                                            {{ $user->name }}
                                        @endif
                                    </td>
                                    <td class="text-left">{{ $user->phone }}</td>
                                    <td class="text-center">
                                        @if ($user->id != \Illuminate\Support\Facades\Auth::user()->id)
                                            <a class="btn btn-xs btn-danger" href="delete-user/{{ $user->id }}" onclick="return confirm('הזהר! אתה באמת רוצה למחוק את המשתמש הזה?');">מחק</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<script>
    window.isAdmin = {{ $is_admin ? 'true' : 'false' }};
</script>
@endsection
