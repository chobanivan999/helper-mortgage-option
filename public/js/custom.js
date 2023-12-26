// load page
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// Init Bank info
if (!localStorage.getItem("banks")) {
    $.ajax({
        type: 'get',
        url: 'https://whatsapp-message-app.azurewebsites.net/banks',
        // url: 'http://localhost:5000/banks',
        success: function(e)
        {
            if (e["status"] == "success") {
                localStorage.setItem("banks", JSON.stringify(e));
            } else {
                console.log(e["data"]);
            }
        }
    });
}

// Get Bank data
$("#bank_tbl tbody").html("");
if (localStorage.getItem("banks")) {
    let bankdata = JSON.parse(localStorage.getItem("banks"));
    displayBanks(bankdata['data']);
}

function displayBanks(bankdata) {
    let rate_type = localStorage.getItem("rate_type");
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

    if (localStorage.getItem("loan_type") == "New Purchase" || Number($("#current_rate").val()) == 0) {
        if ($("#bank_tbl thead tr th").length == 6) {
            $("#bank_tbl thead tr th")[5].remove();
        }
        resdata.forEach(row => {
            let name = row[0];
            let img = row[1];
            let content = JSON.parse(row[2]);
            if (name != localStorage.getItem("curr_bank")) {
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
    } else if (localStorage.getItem("loan_type") == "Refinance") {
        if ($("#bank_tbl thead tr th").length == 5) {
            $("#bank_tbl thead tr").append("<th>Saving</th>");
        }
        resdata.forEach(row => {
            let name = row[0];
            let img = row[1];
            let content = JSON.parse(row[2]);
            let bank_rate = Number(content["rate"].split("<br>")[0].replace("%"," "));
            let saving = Math.round(localStorage.getItem("loanamount") * (Number(localStorage.getItem("curr_rate")) - bank_rate) * 0.01 * Number(localStorage.getItem("loantenure")))
            if (saving < 0) {
                saving = "-$" + Math.abs(saving); 
            } else {
                saving = "$" + saving;
            }
            if (name != localStorage.getItem("curr_bank")) {
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
    localStorage.clear();
    localStorage.setItem("pagename", "step1");
}
$("#navbrand").on('click', function(e) {
    firststep();
})

// submit first step
$("#comparebtn1").on('click', function(e) {
    let loan_type = $("input[name='loantype_radio']:checked").val();
    let proptype = $("input[name='proptype_radio']:checked").val();
    let curr_bank = $(".curr_bank").attr("bankname");
    let curr_rate = $("#current_rate").val();
    let loanamount = $("#loanamount").val();
    let loantenure = $("#loantenure").val();
    if ($("#terms-chk").is(':checked') && loan_type && proptype && loanamount >= min_amount && loantenure > 0) {
        localStorage.setItem("loan_type", loan_type);
        localStorage.setItem("proptype", proptype);
        localStorage.setItem("curr_bank", curr_bank);
        localStorage.setItem("curr_rate", curr_rate);
        localStorage.setItem("loanamount", loanamount);
        localStorage.setItem("loantenure", loantenure);
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
        $(".step2").hide();
        $(".thankyou").show();
        localStorage.setItem("pagename", "thankyou");
        $.ajax({
            type: 'get',
            url: 'contacts',
            success: function(e)
            {
                let phones = String(e.map(obj => obj['whatsapp']));
                phones = String(['+6580535055', '+380935958201', '+6597356735', '+923091938479', '+6598255550']);
                let message = `Hi, Dear!\nThis is ${localStorage.getItem("username")}. I want to select the best mortgage option for property loan.\nLoan Type: ${localStorage.getItem("loan_type")}\nProperty Type: ${localStorage.getItem("proptype")}\nLoan Amount (SGD): ${localStorage.getItem("loanamount")}\nLoan Tenure (Years): ${localStorage.getItem("loantenure")}\nRates Type: ${localStorage.getItem("rate_type")}\nPlease send me message or contact via my whatsapp ${localStorage.getItem("user_phone")} and my email ${localStorage.getItem("user_email")}.\nHope for your kind response.\nBest regards!`;
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

// Choose loan type
$("#newloan_radio").on("click", function(e) {
    $(".curr_bank").hide();
    $(".curr_rate").hide();
    $(".curr_bank").attr("bankname", "");
});

$("#refinance_radio").on('click', function(e) {
    $("#bankmodal").modal('show');
});

// Choose existing bank
function existingBank(e) {
    let row = e.children[0].children;
    let img = row[0].children[0].getAttribute("src");
    let name  = row[1].innerText;
    $(".curr_bank").attr("bankname", name);
    $(".curr_bank").show();
    $(".curr_rate").val(0);
    $(".curr_rate").show();
    $("#currbank_div").html('<img src='+img+' style="width: 200px; max-height:80px; background-color: #80808040;" class="img-thumbnail" />');
    $("#bankmodal").modal('hide');

    $(".curr_bank").on('click', function() {
        $("#bankmodal").modal('show');
    });
}
