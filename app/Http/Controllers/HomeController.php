<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

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
        return view('home', ['contacts' => $contacts]);
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
