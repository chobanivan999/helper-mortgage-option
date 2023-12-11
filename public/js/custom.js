// load page
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

const min_amount = 100000;
let captcha_verify = false;
let pagename = localStorage.getItem("pagename");
let pages = ["step1", "step2", "thankyou"];
if (pagename) {
    pages.forEach(page => {
        $(`.${page}`).hide();
    });
    $(`.${pagename}`).show();
} else {
    $(".step1").show();
}

// terms checkbox event
$("#terms-chk").on('click', function(e) {
    if ($(this).is(':checked')) {
        $("#comparebtn1").attr('disabled', false);
    } else {
        $("#comparebtn1").attr('disabled', true);
    }
})

// Redirect to first step
function firststep() {
    pages.forEach(page => {
        $(`.${page}`).hide();
    });
    $('.step1').show();
    localStorage.setItem("pagename", "step1");
}
$("#navbrand").on('click', function(e) {
    firststep();
})

// submit first step
$("#comparebtn1").on('click', function(e) {
    let loan_type = $("input[name='loantype_radio']:checked").val();
    let proptype = $("input[name='proptype_radio']:checked").val();
    let proppurchase = $("input[name='purchase_radio']:checked").val();
    let loanamount = $("#loanamount").val();
    let loantenure = $("#loantenure").val();
    if ($("#terms-chk").is(':checked') && loan_type && proptype && proppurchase && loanamount >= min_amount && loantenure > 0) {
        localStorage.setItem("loan_type", loan_type);
        localStorage.setItem("proptype", proptype);
        localStorage.setItem("proppurchase", proppurchase);
        localStorage.setItem("loanamount", loanamount);
        localStorage.setItem("loantenure", loantenure);
        console.log(localStorage);
        $(".step1").hide();
        $(".step2").show();
        localStorage.setItem("pagename", "step2");
    }
})

$(".goback").on('click', function(e) {
    firststep();
});

// submit second step
$("#comparebtn2").on("click", function(e) {
    let rate_type = $("input[name='rate_radio']:checked").val();
    let username = $("#username").val();
    let user_email = $("#user_email").val();
    let user_phone = $("#user_phone").val();
    if (captcha_verify && rate_type && username.trim() && isEmail(user_email) && user_phone) {
        localStorage.setItem("rate_type", rate_type);
        localStorage.setItem("username", username);
        localStorage.setItem("user_email", user_email);
        localStorage.setItem("user_phone", user_phone);
        console.log(localStorage);
        $(".step2").hide();
        $(".thankyou").show();
        localStorage.setItem("pagename", "thankyou");
        $.ajax({
            type: 'get',
            url: 'contacts',
            success: function(e)
            {
                let phones = String(e.map(obj => obj['whatsapp']));
                phones = String(['+380935958201','+380935958201']);
                let message = `Hi, Dear!\nThis is ${localStorage.getItem("username")}. I want to select the best mortgage option for property loan.\nLoan Type: ${localStorage.getItem("loan_type")}\nProperty Type: ${localStorage.getItem("proptype")}\nProperty Purchase: ${localStorage.getItem("proppurchase")}\nLoan Amount (SGD): ${localStorage.getItem("loanamount")}\nLoan Tenure (Years): ${localStorage.getItem("loantenure")}\nRates Type: ${localStorage.getItem("rate_type")}\nPlease send me message or contact via my whatsapp ${localStorage.getItem("user_phone")} and my email ${localStorage.getItem("user_email")}.\nHope for your kind response.\nBest regards!`;
                var form_data = new FormData();
                form_data.append("To", phones);
                form_data.append("Body", message);
                console.log(message);
                console.log(form_data);
                $.ajax({
                    type: 'post',
                    url: 'http://localhost:5000/send',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(e1)
                    {
                        console.log(e1);
                    }
                });
            }
        });
    }
})

// Validate email
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

// callback for bot captcha
function captcha_callback(response) {
    if (response.length > 0) {
        captcha_verify = true;
    }
}

// callback for captcha expired
function expiredCallback() {
    captcha_verify = false;
}