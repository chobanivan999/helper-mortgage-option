<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Bank;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $contacts = Contact::all();
        $banks    = Bank::orderBy('id')->groupBy("name")->get();
        foreach($banks as &$bank) {
            $bank->rate = json_decode($bank->content)->rate;
            $bank->ratetype = json_decode($bank->content)->ratetype;
            $bank->lockin = json_decode($bank->content)->lockin;
            $bank->installment = json_decode($bank->content)->installment;
        }
        return view('home', ['contacts' => $contacts, 'banks' => $banks]);
    }

    /**
     * Show the contacts
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getContacts()
    {
        $contacts = Contact::all();
        return $contacts;
    }
}
