/*!

 =========================================================
 * Material Bootstrap Wizard - v1.0.2
 =========================================================
 
 * Product Page: https://www.creative-tim.com/product/material-bootstrap-wizard
 * Copyright 2017 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/material-bootstrap-wizard/blob/master/LICENSE.md)
 
 =========================================================
 
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 */

// Material Bootstrap Wizard Functions

var searchVisible = 0;
var transparent = true;
var mobile_device = false;
let captcha_verify = false;
let confirm_send = false;
localStorage.removeItem("sent");

$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// callback for bot captcha
function captcha_callback(response) {
    if (response.length > 0) {
        captcha_verify = true;
        $("#capcha_required").addClass("hide");
    }
}

// callback for captcha expired
function expiredCallback() {
    captcha_verify = false;
    $("#capcha_required").removeClass("hide");
}

// Choose existing bank
function existingBank(e) {
    let row = e.children;
    let img = row[0].children[0].getAttribute("src");
    let name  = row[1].innerText;
    $(".curr_bank").attr("bankname", name);
    $(".curr_bank").show();
    $(".curr_rate").val(0);
    $(".curr_rate").css({"display": "table"});
    $("#currbank_div").html('<img src='+img+' style="width: 200px; max-height:80px; background-color: #80808040;" class="img-thumbnail" />');
    $("#bankmodal").modal('hide');

    $(".curr_bank").on('click', function() {
        $("#bankmodal").modal('show');
    });
}

function displayBanks(bankdata) {
    let loan_type = $("input[name='loantype_radio']:checked").val();
    let curr_bank = $(".curr_bank").attr("bankname");
    let rate_type = $("input[name='rate_radio']:checked").val();
    let loanamount = $("#loanamount").val();
    let curr_rate = $("#current_rate").val();
    let loantenure = $("#loantenure").val();
    let resdata = [];
    if (rate_type == "Fixed") {
        bankdata.forEach(row => {
            let content = JSON.parse(row[2]);
            if (content["ratetype"][0] == "F") {
                resdata.push(row);
            }
        });
    } else if (rate_type == "Floating") {
        bankdata.forEach(row => {
            let content = JSON.parse(row[2]);
            if (content["ratetype"][0] != "F") {
                resdata.push(row);
            }
        });
    } else {
        resdata = bankdata;
    }

    if (resdata.length > 3) {
        resdata = resdata.slice(0, 3);
    }

    if (loan_type == "New Purchase" || Number($("#current_rate").val()) == 0) {
        if ($("#bank_tbl thead tr th").length == 6) {
            $("#bank_tbl thead tr th")[5].remove();
        }
        resdata.forEach(row => {
            let name = row[0];
            let img = row[1];
            let content = JSON.parse(row[2]);
            if (name != curr_bank) {
                $("#bank_tbl tbody").append(`
                <tr>
                    <td>
                        <img src=${img} 
                        style="width: 150px; max-height:80px; background-color: #80808040;" 
                        class="img-thumbnail" />
                    </td>
                    <td>${content["ratetype"]}</td>
                    <td>${content["lockin"]}</td>
                    <td>${content["rate"]}</td>
                    <td>${content["installment"]}</td>
                </tr>
                `);
            }
        })
    } else if (loan_type == "Refinance") {
        if ($("#bank_tbl thead tr th").length == 5) {
            $("#bank_tbl thead tr").append("<th>Saving</th>");
        }
        resdata.forEach(row => {
            let name = row[0];
            let img = row[1];
            let content = JSON.parse(row[2]);
            let bank_rate = Number(content["rate"].split("<br>")[0].replace("%"," "));
            let saving = Math.round(loanamount * (Number(curr_rate) - bank_rate) * 0.01 * Number(loantenure))
            if (saving < 0) {
                saving = "-$" + Math.abs(saving); 
            } else {
                saving = "$" + saving;
            }
            if (name != curr_bank) {
                $("#bank_tbl tbody").append(`
                <tr>
                    <td>
                        <img src=${img} 
                        style="width: 150px; max-height:80px; background-color: #80808040;" 
                        class="img-thumbnail" />
                    </td>
                    <td>${content["ratetype"]}</td>
                    <td>${content["lockin"]}</td>
                    <td>${content["rate"]}</td>
                    <td>${content["installment"]}</td>
                    <td style="background-color: skyblue;">${saving}</td>
                </tr>
                `);
            }
        })
    }
}

$(document).ready(function(){
    $.material.init();
    /*  Activate the tooltips      */
    $('[rel="tooltip"]').tooltip();

    // Code for the Validator
    var $validator = $('.wizard-card form').validate({
		  rules: {
		    loantype_radio: {
		        required: true,
		    },
            proptype_radio: {
                required: true,
            },
		    loanamount: {
		      required: true,
		      min: 100000
		    },
		    loantenure: {
		      required: true,
		      min: 1,
		    },
            termschk: {
                required: true
            },
            rate_radio: {
		        required: true,
		    },
            username: {
                required: true
            },
            username: {
                required: true
            },
            user_email: {
                required: true,
                minlength: 3,
            },
            user_phone: {
                required: true,
                minlength: 4
            }
        },

        errorPlacement: function(error, element) {
            $(element).parent('div').addClass('has-error');
         }
	});

    // Wizard Initialization
  	$('.wizard-card').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'nextSelector': '.btn-next',
        'previousSelector': '.btn-previous',

        onNext: function(tab, navigation, index) {
            if (index == 1) {
                confirm_send = false;
            }
        	var $valid = $('.wizard-card form').valid();
        	if(!$valid || (index == 2 && !captcha_verify)) {
                
                $validator.focusInvalid();
                $("#capcha_required").removeClass("hide");
        		return false;
        	}

            if ($valid && index == 2 && captcha_verify && !confirm_send) {
                $("#confirmmodal").modal('show');
                return false;
            }
        },

        onInit : function(tab, navigation, index){
            //check number of tabs and fill the entire row
            var $total = navigation.find('li').length;
            var $wizard = navigation.closest('.wizard-card');
            
            $first_li = navigation.find('li:first-child a').html();
            $moving_div = $('<div class="moving-tab">' + $first_li + '</div>');
            $('.wizard-card .wizard-navigation').append($moving_div);

            refreshAnimation($wizard, index);

            $('.moving-tab').css('transition','transform 0s');
       },

        onTabClick : function(tab, navigation, index){
            if (localStorage.getItem("sent")) {
                return true;
            }
            return false;
        },

        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            
            var $wizard = navigation.closest('.wizard-card');

            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $($wizard).find('.btn-next').hide();
                $($wizard).find('.btn-finish').show();
            } else {
                $($wizard).find('.btn-next').show();
                $($wizard).find('.btn-finish').hide();
            }

            button_text = navigation.find('li:nth-child(' + $current + ') a').html();

            setTimeout(function(){
                $('.moving-tab').text(button_text);
            }, 150);

            var checkbox = $('.footer-checkbox');

            if( !index == 0 ){
                $(checkbox).css({
                    'opacity':'0',
                    'visibility':'hidden',
                    'position':'absolute'
                });
            } else {
                $(checkbox).css({
                    'opacity':'1',
                    'visibility':'visible'
                });
            }

            refreshAnimation($wizard, index);
        }
  	});

    $('[data-toggle="loantype_radio"]').click(function(){
        wizard = $(this).closest('.wizard-card');
        wizard.find('[data-toggle="loantype_radio"]').removeClass('active');
        $(this).addClass('active');
        $(this).children()[0].setAttribute("checked", "true");
        if ($(this).children()[0].value == "Refinance") {
            $("#bankmodal").modal('show');
        } else {
            $(".curr_bank").hide();
            $(".curr_rate").hide();
            $(".curr_bank").attr("bankname", "");
        }
    });

    $('[data-toggle="proptype_radio"]').click(function(){
        wizard = $(this).closest('.wizard-card');
        wizard.find('[data-toggle="proptype_radio"]').removeClass('active');
        $(this).addClass('active');
        $(this).children()[0].setAttribute("checked", "true");
    });

    $('[data-toggle="rate_radio"]').click(function(){
        wizard = $(this).closest('.wizard-card');
        wizard.find('[data-toggle="rate_radio"]').removeClass('active');
        $(this).addClass('active');
        $(this).children()[0].setAttribute("checked", "true");
    });

    $('.set-full-height').css('height', 'auto');

});


$(window).resize(function(){
    $('.wizard-card').each(function(){
        $wizard = $(this);

        index = $wizard.bootstrapWizard('currentIndex');
        refreshAnimation($wizard, index);

        $('.moving-tab').css({
            'transition': 'transform 0s'
        });
    });
});

function refreshAnimation($wizard, index){
    $total = $wizard.find('.nav li').length;
    $li_width = 100/$total;

    total_steps = $wizard.find('.nav li').length;
    move_distance = $wizard.width() / total_steps;
    index_temp = index;
    vertical_level = 0;

    mobile_device = $(document).width() < 600 && $total > 3;

    if(mobile_device){
        move_distance = $wizard.width() / 2;
        index_temp = index % 2;
        $li_width = 50;
    }

    $wizard.find('.nav li').css('width',$li_width + '%');

    step_width = move_distance;
    move_distance = move_distance * index_temp;

    $current = index + 1;

    if($current == 1 || (mobile_device == true && (index % 2 == 0) )){
        move_distance -= 8;
    } else if($current == total_steps || (mobile_device == true && (index % 2 == 1))){
        move_distance += 8;
    }

    if(mobile_device){
        vertical_level = parseInt(index / 2);
        vertical_level = vertical_level * 38;
    }

    $wizard.find('.moving-tab').css('width', step_width);
    $('.moving-tab').css({
        'transform':'translate3d(' + move_distance + 'px, ' + vertical_level +  'px, 0)',
        'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'

    });
}

materialDesign = {

    checkScrollForTransparentNavbar: debounce(function() {
            if($(document).scrollTop() > 260 ) {
                if(transparent) {
                    transparent = false;
                    $('.navbar-color-on-scroll').removeClass('navbar-transparent');
                }
            } else {
                if( !transparent ) {
                    transparent = true;
                    $('.navbar-color-on-scroll').addClass('navbar-transparent');
                }
            }
    }, 17)

}

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		}, wait);
		if (immediate && !timeout) func.apply(context, args);
	};
};

// terms checkbox event
$("#terms-chk").on('click', function(e) {
    if ($(this).is(':checked')) {
        $("#comparebtn").attr('disabled', false);
    } else {
        $("#comparebtn").attr('disabled', true);
    }
})

$("#send_confirm_btn").on('click', function(e) {
    let loan_type = $("input[name='loantype_radio']:checked").val();
    let proptype = $("input[name='proptype_radio']:checked").val();
    let curr_bank = $(".curr_bank").attr("bankname");
    let curr_rate = $("#current_rate").val();
    let loanamount = $("#loanamount").val();
    let loantenure = $("#loantenure").val();
    let rate_type = $("input[name='rate_radio']:checked").val();
    let username = $("#username").val();
    let user_email = $("#user_email").val();
    let user_phone = $("#user_phone").val();
    $.ajax({
        type: 'get',
        url: 'contacts',
        success: function(e)
        {
            let phones = String(e.map(obj => obj['whatsapp']));
            phones = String(['+6580535055', '+380935958201', '+6597356735', '+923091938479', '+6598255550']);
            let message = `Hi, Dear!\nThis is ${username}. I want to select the best mortgage option for property loan.\nLoan Type: ${loan_type}\nProperty Type: ${proptype}\nLoan Amount (SGD): ${loanamount}\nLoan Tenure (Years): ${loantenure}\nRates Type: ${rate_type}\nPlease send me message or contact via my whatsapp ${user_phone} and my email ${user_email}.\nHope for your kind response.\nBest regards!`;
            var form_data = new FormData();
            form_data.append("To", phones);
            form_data.append("Body", message);

            $.ajax({
                type: 'post',
                url: 'https://whatsapp-message-app.azurewebsites.net/send',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(e1)
                {
                    console.log(e1);
                    localStorage.setItem("sent", "sent");
                    confirm_send = true;
                    $("#confirmmodal").modal('hide');
                    $("#comparebtn").click();
                }
            });
        }
    });
    // Get Bank data
    $("#bank_tbl tbody").html("");
    if (localStorage.getItem("banks")) {
        let bankdata = JSON.parse(localStorage.getItem("banks"));
        displayBanks(bankdata['data']);
    } else {
        $.ajax({
            type: 'get',
            url: 'https://whatsapp-message-app.azurewebsites.net/banks',
            // url: 'http://localhost:5000/banks',
            success: function(e)
            {
                if (e["status"] == "success") {
                    localStorage.setItem("banks", JSON.stringify(e));
                    displayBanks(e['data']);
                } else {
                    console.log(e["data"]);
                }
            }
        });
    }
})