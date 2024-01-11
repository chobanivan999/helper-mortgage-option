@extends('layouts.app')

@section('content')
<div class="image-container set-full-height" style="background-image: url('/img/wizard-book.jpg')">

	    <!--   Big container   -->
	    <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="confirmmodal" tabindex="-1" aria-labelledby="confirmmodallabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title fs-5" id="confirmmodallabel">Are you sure?</h3>
                        </div>
                        <div class="modal-body">
                            Your information will be sent to the banks. okay?
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" id="send_confirm_btn" style="margin-bottom: 10px;">Okay</button>
                        </div>
                    </div>
                </div>
            </div>
	        <div class="row">
		        <div class="col-sm-10 col-sm-offset-1">
		            <!--      Wizard container        -->
		            <div class="wizard-container">
		                <div class="card wizard-card" data-color="green" id="wizardProfile">
		                    <form action="" method="">
		                    	<div class="wizard-header">
		                        	<h3 class="wizard-title">
										What are you looking for?
		                        	</h3>
									<h5>Simply fill in the form below to use our free loan comparison service.</h5>
		                    	</div>
								<div class="wizard-navigation">
									<ul>
			                            <li><a href="#step1" data-toggle="tab">Step 1</a></li>
			                            <li><a href="#step2" data-toggle="tab">Step 2</a></li>
			                            <li><a href="#result" data-toggle="tab">Result</a></li>
			                        </ul>
								</div>

		                        <div class="tab-content">
		                            <div class="tab-pane" id="step1">
		                                <div class="row">
		                                	<div class="col-sm-10 col-sm-offset-1">
                                                <div class="row" style="display: flex; justify-content: space-evenly;">
                                                    <div class="col-sm-3" style="font-weight: bold; display: flex; align-items: center; justify-content: center;">Loan Type</div>
                                                    <div class="col-sm-3">
                                                        <div class="choice" data-toggle="loantype_radio" rel="tooltip" title="New Purchase">
                                                            <input type="radio" class="form-check-input" id="newloan_radio" name="loantype_radio" value="New Purchase">
                                                            <div class="icon">
                                                                <img src="/img/new_purchase.png" width="40px" style="margin-top: 10px;" />
                                                            </div>
                                                            <h6>New Purchase</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="choice" data-toggle="loantype_radio" rel="tooltip" title="Refinance">
                                                            <input type="radio" class="form-check-input" id="refinance_radio" name="loantype_radio" value="Refinance">
                                                            <div class="icon">
                                                                <img src="/img/refinance.png" width="40px" style="margin-top: 10px;" />
                                                            </div>
                                                            <h6>Refinance</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="display: flex; justify-content: space-evenly;">
                                                    <div class="col-sm-3" style="font-weight: bold; display: flex; align-items: center;     justify-content: flex-end;">Property Type</div>
                                                    <div class="col-sm-3 row">
                                                        <div class="choice" data-toggle="proptype_radio" rel="tooltip" title="Pte Residential">
                                                            <input type="radio" class="form-check-input" name="proptype_radio" value="Pte Residential">
                                                            <div class="icon">
                                                                <img src="/img/private_home.png" width="40px" style="margin-top: 10px;" />
                                                            </div>
                                                            <h6>Pte Residential</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 row">
                                                        <div class="choice" data-toggle="proptype_radio" rel="tooltip" title="HDB">
                                                            <input type="radio" class="form-check-input" name="proptype_radio" value="HDB">
                                                            <div class="icon">
                                                                <img src="/img/hdb.png" width="40px" style="margin-top: 10px;" />
                                                            </div>
                                                            <h6>HDB</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 row">
                                                        <div class="choice" data-toggle="proptype_radio" rel="tooltip" title="Commercial">
                                                            <input type="radio" class="form-check-input" name="proptype_radio" value="Commercial">
                                                            <div class="icon">
                                                                <img src="/img/commercial.png" width="40px" style="margin-top: 10px;" />
                                                            </div>
                                                            <h6>Commercial</h6>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="input-group">
                                                    <div class="curr_bank card_hide">
                                                        <label class="form-label"><b>Current Bank</b></label>
                                                        <div class="d-flex justify-content-center" id="currbank_div"></div>
                                                    </div>
                                                </div>
                                                <div class="input-group curr_rate card_hide">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">percent</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Current Rate</label>
                                                        <input type="number" class="form-control" min="0" max="100" id="current_rate" />
                                                    </div>
                                                </div>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">monetization_on</i>
													</span>
													<div class="form-group label-floating">
			                                          <label class="control-label">Loan Amount (SGD)</label>
			                                          <input type="number" class="form-control" id="loanamount" name="loanamount" value="100000" min="100000">
			                                        </div>
												</div>

												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">calendar_month</i>
													</span>
													<div class="form-group label-floating">
													  <label class="control-label">Loan Tenure (Years)</label>
													  <input type="number" class="form-control" id="loantenure" name="loantenure" min="1" value="30">
													</div>
												</div>
                                                <div class="input-group">
													<span class="input-group-addon">
                                                    <input class="form-check-input" id="terms-chk" name="termschk" type="checkbox">
													</span>
													<div class="form-group label-floating">
                                                    I consent to the collection, use and disclosure of my personal data for the purposes set in our <a href="#" id="privacy-link" style="font-weight: bold; color: blue;">Privacy Notice</a> as required by the Personal Data Protection Act 2012.
													</div>
												</div>
		                                	</div>
		                            	</div>
                                        
                                        <div class="modal fade" id="bankmodal" tabindex="-1" aria-labelledby="bankmodallabel" aria-hidden="true" style="z-index:1100;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h3 class="modal-title fs-5" id="bankmodallabel">Select your existing bank</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-hover banktbl">
                                                            @foreach($banks as $bank)
                                                            <tr onclick="existingBank(this)" class="row">
                                                                <th class="col-sm-6">
                                                                    <img src="{{$bank['image']}}" class="bank_img" />
                                                                </th>
                                                                <th class="col-sm-6">
                                                                    {{$bank['name']}}
                                                                </th>
                                                            </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
		                            </div>
		                            <div class="tab-pane" id="step2">
		                                <div class="row">
                                            <div class="col-sm-10 col-sm-offset-1">
                                                <div class="row" style="display: flex; justify-content: space-evenly;">
                                                    <div class="col-sm-3" style="font-weight: bold; display: flex; align-items: center;">Rate Type</div>
                                                    <div class="col-sm-2 row">
                                                        <div class="choice" data-toggle="rate_radio" rel="tooltip" title="Fixed and Floating">
                                                            <input type="radio" class="form-check-input" name="rate_radio" value="Fixed and Floating">
                                                            <div class="icon">
                                                                <img src="/img/both_rate.png" width="40px" style="margin-top: 10px;" />
                                                            </div>
                                                            <h6>Both</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2 row">
                                                        <div class="choice" data-toggle="rate_radio" rel="tooltip" title="Fixed">
                                                            <input type="radio" class="form-check-input" name="rate_radio" value="Fixed">
                                                            <div class="icon">
                                                                <img src="/img/fixed_rate.png" width="40px" style="margin-top: 10px;" />
                                                            </div>
                                                            <h6>Fixed</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2 row">
                                                        <div class="choice" data-toggle="rate_radio" rel="tooltip" title="Floating">
                                                            <input type="radio" class="form-check-input" name="rate_radio" value="Floating">
                                                            <div class="icon">
                                                                <img src="/img/floating_rate.png" width="40px" style="margin-top: 10px;" />
                                                            </div>
                                                            <h6>Floating</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">face</i>
													</span>
													<div class="form-group label-floating">
			                                          <label class="control-label">Name</label>
			                                          <input type="text" class="form-control" id="username" name="username">
			                                        </div>
												</div>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">email</i>
													</span>
													<div class="form-group label-floating">
			                                          <label class="control-label">Email</label>
			                                          <input type="email" class="form-control" id="user_email" name="user_email">
			                                        </div>
												</div>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">phone</i>
													</span>
													<div class="form-group label-floating">
			                                          <label class="control-label">Contact Number</label>
			                                          <input type="text" class="form-control" id="user_phone" name="user_phone">
			                                        </div>
												</div>
                                                <div class="input-group">
													<div class="form-group label-floating">
                                                        <div class="g-recaptcha" id="g-recaptcha" data-sitekey="{{ config('app.GOOGLE_RECAPTCHA_KEY') }}" data-callback="captcha_callback" data-expired-callback="expiredCallback"></div>
                                                        @if ($errors->has('g-recaptcha-response'))
                                                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                                        @endif
			                                        </div>
												</div>
		                                    </div>    
		                                </div>
		                            </div>
		                            <div class="tab-pane" id="result">
		                                <div class="row">
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <h3>Thank you for your enquiry.</h3>
                                            <p>We've identified the best deals for you and have forwarded your enquiry to the selected banks listed below.</p>
                                            <p>We will promptly update you with the most suitable package available.</p>
                                            <p>We will update you with advice on the best package available soonest.</p>
                                            <p>In the meantime, if you require any clarifications, please feel free to contact us at <code>+65 80535055</code> or email us at <a href = "mailto: atlasadvisorypl@gmail.com">atlasadvisorypl@gmail.com</a></p>
                                            <br>
                                            <div class="mt-3 bank_tbl">
                                                <table class="table text-center align-middle" id="bank_tbl">
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
		                        <div class="wizard-footer">
		                            <div class="pull-right">
		                                <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' value='Compare Rates' id="comparebtn" disabled />
		                            </div>

		                            <div class="pull-left">
		                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
		                            </div>
		                            <div class="clearfix"></div>
		                        </div>
		                    </form>
		                </div>
		            </div> <!-- wizard container -->
		        </div>
	        </div><!-- end row -->
	    </div> <!--  big container -->

	    <div class="footer">
	        <div class="container text-center">
	             2024
	        </div>
	    </div>
	</div>
@endsection
