<?php

namespace App\Http\Controllers;

use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login_form()
    {
        return view('login');
    }

    public function login()
    {
        $this->validate(request(), [
            'aday_no' =>'required|numeric',
            'password' => 'required'
        ]);

        $credentials = [
            'name' => request('aday_no'),
            'password' => request('password'),
            'authorization'=> true
        ];

        $kimlik = DB::table('student')->where('aday_no', request('aday_no'))->get();

        if (Auth::guard('admin')->attempt($credentials))
        {
            request()->session()->regenerate();
            return redirect()->intended('admin');
        }
        elseif (isset($kimlik[0]->aday_no) == request('aday_no') && Hash::check(request('password'), $kimlik[0]->password))
        {
            session_start();
            request()->session()->put('kimlik_no', $kimlik[0]->kimlik_no);
            request()->session()->put('email', $kimlik[0]->email);
            request()->session()->put('aday_no', request('aday_no'));
            request()->session()->put('password', request('password'));
            request()->session()->regenerate();
            return redirect()->intended('kullanici-dogrula');
        }
        else
        {
            $errors = ['Application number or password is incorrect!'];
            return back()->withErrors($errors);
        }
    }


    public function authetication_form()
    {
        $questions = [
            'Doğum yeriniz neresi?',
            'Babanızın adı nedir?',
            'Doğum tarihiniz nedir?'
        ];

        $lengthQuestions = count($questions);

        return view('loginv2', compact('questions'));
    }

    public function authetication()
    {
        $this->validate(request(), [
            'answer' =>'required'
        ]);

        $student = DB::table('student_info')->where('kimlik_no', session('kimlik_no'))->get();

        if (Auth::guard('student')->attempt(['email' => session('email'), 'password' => session('password'), 'authorization'=> false]))
        {
            if (strtolower($student[0]->baba_adi) == strtolower(request('answer')) || strtolower($student[0]->dogum_yeri) == strtolower(request('answer')) || strtolower($student[0]->dogum_tarihi) == strtolower(request('answer')))
            {
                return redirect()->intended('kullanici');
            }
            else
            {
                $errors = ['Answer is incorrect!'];
                return back()->withErrors($errors);
            }
        }
    }



    public function signout()
    {
        Auth::guard('admin')->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('giris');

    }
}
