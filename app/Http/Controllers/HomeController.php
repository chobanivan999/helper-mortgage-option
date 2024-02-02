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
        $banks    = [
            [
                "name" => "Maybank",
                "image"=> "https://www.maybank.com/iwov-resources/images/icons/maybank_logo.svg"
            ],
            [
                "name" => "OCBC",
                "image"=> "https://www.ocbc.com/iwov-resources/sg/ocbc/gbc/img/logo_ocbc.png"
            ],
            [
                "name" => "DBS",
                "image"=> "https://www.dbs.com/iwov-resources/flp/images/dbs_logo.svg"
            ],
            [
                "name" => "HSBC",
                "image"=> "https://www.hsbc.com/-/files/hsbc/header/hsbc-logo-200x25.svg?h=25&la=en-GB&hash=EFB19274CD17649AE659D3351B595180"
            ],
            [
                "name" => "Citibank",
                "image"=> "https://www.citi.com/CBOL/IA/Angular/assets/citiredesign.svg"
            ],
            [
                "name" => "Standard Chartered",
                "image"=> "https://av.sc.com/corp-en/nr/content/images/sc-lock-up-english-rgb-thumbnail-750x422.jpg"
            ],
            [
                "name" => "CIMB Bank",
                "image"=> "https://www.cimbbank.com.ph/content/dam/cimbph/images/global/logo-cimb-islamic.svg"
            ],
            [
                "name" => "Bank of China",
                "image"=> "https://www.boc.cn/en/images/bankofchina_LOGO.gif"
            ],
            [
                "name" => "Hong Leong Finance",
                "image"=> "https://www.hlf.com.sg/assets/images/home/logo.png"
            ],
            [
                "name" => "Singapura Finance Ltd",
                "image"=> "https://www.singapurafinance.com.sg/img/logo.png"
            ],
            [
                "name" => "State Bank of India",
                "image"=> "https://sbi.co.in/o/SBI-Theme/images/custom/logo.png"
            ],
            [
                "name" => "UOB",
                "image"=> "https://www.uob.com.sg/assets/iwov-resources/assets/BrandAssets/UOB_Logo.svg"
            ],
            [
                "name" => "RHB",
                "image"=> "https://www.rhbgroup.com/images/global/logo-mobile_default.png"
            ]
        ];
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
