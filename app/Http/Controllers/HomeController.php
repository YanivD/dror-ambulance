<?php

namespace App\Http\Controllers;

use App\Shift;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $is_current_month = !request()->get('next');
        $days_in_month = date('t', strtotime($is_current_month ? 'now' : '+1 month'));
        $month_number  = date('n', strtotime($is_current_month ? 'now' : '+1 month'));
        $year_number   = date('y', strtotime($is_current_month ? 'now' : '+1 month'));

        $shifts = [];

        foreach (range(1,$days_in_month) as $day_number) {
            $date = mktime(0, 0, 0, $month_number, $day_number, $year_number);

            $shifts[date('j.n.y', $date)] = [
                'date_without_year' => date('j.n', $date),
                'date' => date('j.n.y', $date),
                'day_of_week' => str_replace(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], ['ראשון', 'שני', 'שלישי', 'רביעי', 'חמישי', 'שישי', 'שבת'], date('l', $date)),
                'shift1' => [
                    'saturday' => date('w', $date) == 6,
                    'title' => NULL,
                    'users' => []
                ],
                'shift2' => [
                    'saturday' => date('w', $date) == 6,
                    'title' => NULL,
                    'users' => []
                ],
                'shift3' => [
                    'saturday' => date('w', $date) == 5 || date('w', $date) == 6,
                    'title' => NULL,
                    'users' => []
                ],
            ];
        }

        $registered = Shift::with('user')
            ->where('date_str', 'LIKE', "%.$month_number.$year_number")
            ->get();

        foreach ($registered as $register) {
            $shifts[$register['date_str']]['shift'.$register['shift_id']]['users'][] = [
                'user_id' => $register['user_id'],
                'status'  => $register['status'],
                'name'    => $register['user']['name'],
            ];
        }

        $is_admin = request()->get('admin') && Auth::user()->is_admin;

        return view('home')
            ->with('shifts', array_values($shifts))
            ->with('current_user_id', Auth::user()->id)
            ->with('is_current_month', $is_current_month)
            ->with('can_admin', Auth::user()->is_admin)
            ->with('users', $is_admin ? User::orderBy('name')->get() : [])
            ->with('is_admin', $is_admin);
    }
}
