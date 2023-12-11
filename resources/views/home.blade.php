@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card step1 card_hide">
                <div class="card-header"><h3>What are you looking for?</h3></div>
                <div class="card-body">
                    Simply fill in the form below to use our free loan comparison service.
                    <div class="mb-3 mt-3">
                        <label for="loantype" class="form-label"><b>Loan Type</b></label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="loantype_radio" value="New Loan" checked>New Loan
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="loantype_radio" value="Refinance">Refinance
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="proptype" class="form-label"><b>Property Type</b></label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="proptype_radio" value="Private Residential" checked>Private Residential
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="proptype_radio" value="HDB">HDB
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="proptype_radio" value="Commercial">Commercial
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="proppurchase" class="form-label"><b>Property Purchase</b></label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="purchase_radio" value="Yes" checked>Yes
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="purchase_radio" value="No">No
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="loanamount" class="form-label"><b>Loan Amount (SGD)</b></label>
                        <input type="number" class="form-control" id="loanamount" value="100000" min="100000">
                    </div>
                    <div class="mb-3">
                        <label for="loantenure" class="form-label"><b>Loan Tenure (Years)</b></label>
                        <input type="number" class="form-control" id="loantenure" value="30" min="1">
                    </div>
                    <div class="form-check mb-3">
                        <label class="form-check-label">
                        <input class="form-check-input" id="terms-chk" type="checkbox">
                        <span>
                            I consent to the collection, use and disclosure of my personal data for the purposes set in our <a href="#" id="privacy-link">Privacy Notice</a> as required by the Personal Data Protection Act 2012.
                        </span>
                    </div>
                    <button class="btn btn-primary" id="comparebtn1" disabled>COMPARE RATES</button>
                </div>
            </div>
            <div class="card step2 card_hide">
                <div class="card-header"><h3>Step 2 out of 2</h3></div>
                <div class="card-body">
                    <div class="mb-3 mt-3">
                        <label class="form-label">
                            <b>
                                Fixed or Floating Rates<br>
                                (Do you prefer fixed or floating rates?)
                            </b>
                        </label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="rate_radio" value="Fixed and Floating" checked>Both
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="rate_radio" value="Fixed">Fixed
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="rate_radio" value="Floating">Floating
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="username" class="form-label"><b>Name</b></label>
                        <input type="text" class="form-control" id="username">
                    </div>
                    <div class="mb-3">
                        <label for="user_email" class="form-label"><b>Email</b></label>
                        <input type="email" class="form-control" id="user_email">
                    </div>
                    <div class="mb-3">
                        <label for="user_phone" class="form-label"><b>Contact Number</b></label>
                        <input type="text" class="form-control" id="user_phone">
                    </div>
                    <div class="mb-3">
                        <div class="g-recaptcha" id="g-recaptcha" data-sitekey="{{ config('app.GOOGLE_RECAPTCHA_KEY') }}" data-callback="captcha_callback" data-expired-callback="expiredCallback"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="text-primary goback">Go Back</label>
                    </div>
                    <button class="btn btn-primary" id="comparebtn2">COMPARE RATES</button>
                    <div class="m-3">
                    <p class="info_kept">All information is kept private in accordance with our 
                    <a href="#" id="accept-link"><span>privacy policy</span></a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="m-4 p-5 bg-default rounded thankyou card_hide">
                <h1>Thank you for your enquiry.</h1>
                <p>We are processing your entry to provide an accurate quote for you ASAP.</p>
                <!-- <p>Please check the table below on prevailing rates updated weekly. The monthly instalments are calculated assuming a <b>$100,000 loan over 30 years</b>. The wide range of rates are for all types of properties such as HDB, private residential and commercial property for both personal and business use.</p> -->
                <p>We sent your enquiry message via Whatsapp to bellow advisors of the several banks.</p>
                <p>We will get back to you to advise on the best deal available for your property.</p>
                <br>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Bank</th>
                            <th>Advisor</th>
                            <th>Whatsapp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $contact->bankname }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->whatsapp }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    <div class="m-1">
                        <button class="btn btn-success" id="downloadBtn">Download Excel File</button>
                    </div>
                    <table class="table" id="bank_tbl">
                        <thead class="table-dark">
                            <tr>
                                <th width="150px">Bank</th>
                                <th>Rate Type</th>
                                <th>Lock In</th>
                                <th>Interest Rate</th>
                                <th>Monthly Installments</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
