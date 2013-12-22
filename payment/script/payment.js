
$(document).ready(function(){

//-------------------------
//Script Run when Page Load
init();
//-------------------------


//-------------------------
//Event

//Everytime change tab
$('section#maxpoint_center_tabs>input').click(function(){
	reloadBalance();
    $('section input').val('');
});

$('#truemoney_fill').click(function(){
    fill_truemoney();
    return false;
});

$('.my_account_tab').click(function(){
    getTransactionHistory();
});

$('.transfer_tab').click(function(){
    $('#transfer_friends p img').removeClass('friend_selected');
    //getOnlineUsers("291fe6047a06471c9609c1c4e073750d");
    getFollowing();
});

$(document).on('click', '#transfer_friends p img', function(e) { 
    $('#transfer_friends p img').removeClass('friend_selected');
    $(this).addClass('friend_selected');
});

//กดปุ่มโอน
$('#maxpoint_transfer_button').click(function(){
    amount_maxpoint = $("input#maxpoint_to_transfer").val(); 
    to_uid = $('#transfer_friends p.fbox img.friend_selected').attr('user-id');
alert(to_uid);
     $.ajax({
        type: "POST",
        dataType: 'json',
        url: "api/center.php?action=maxpointtransfer",
        data:  {
            "amount_maxpoint": amount_maxpoint,
            "to_uid": to_uid
        },
        success : function(data){
            console.log(data);
            alert(data['message']);
            reloadBalance();
        }
        });

     return false;
});

$('#acc_no_button').click(function(){
    $('.popup').css('display','block');
    $('#fade').css('display','block');

    return false;
});


$(document).on('click', '.popup .close', function(e) { 
    $('.popup').css('display','none');
    $('#fade').css('display','none');
});

$('#send_to_verify').click(function(){
    bank_id = $('select#bank').val();
    acc_no = $('#account_verify').val();
    mobile = $('#mobile_verify').val();

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "api/center.php?action=accountverify",
        data:  {
            "bank_id":bank_id,
            "acc_no":acc_no,
            "mobile":mobile
        },
        success : function(data){
            console.log(data);

            if(data['status']==1)
            {
                var element = "รหัส OTP <br><br><input class='input-big' type='text' id='otp_verify' name='otp_verify'>&nbsp;<a href='#'' id='send_otp_to_verify' class='btn'>ยืนยัน</a>";
                $('div.popup').html(element);
            }
            else
            {
                alert(data['message']);
            }
        }
        });

     return false;

});

$(document).on('click', '#send_otp_to_verify', function(e) { 
    otp = $('#otp_verify').val();

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "api/center.php?action=accountverify",
        data:  {
            "otp": otp
        },
        success : function(data){
            console.log(data);

            alert(data['message'])

             $('.popup').css('display','none');

             location.reload();
        }
        });

     return false;
});

$('#exchange_mp').change(function(){
    $('#exchange_baht').val($(this).val()/10);
});

$('#exchange_baht').change(function(){
    $('#exchange_mp').val($(this).val()*10);
});


$('#exchange').click(function(){
    amount_maxpoint = $('#exchange_mp').val();
    amount_baht = $('#exchange_baht').val();
    current_rate = 10;
    withdraw_fee = 10;

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "api/center.php?action=withdraw",
        data:  {
            "amount_maxpoint":amount_maxpoint,
            "amount_baht":amount_baht,
            "current_rate":current_rate,
            "withdraw_fee":withdraw_fee
        },
        success : function(data){
            console.log(data);
            if(data['status']==1)
            {
                var element = "รหัส OTP <br><br><input class='input-big' type='text' id='otp_verify' name='otp_verify'>&nbsp;<a href='#'' id='exchange_otp_verify' class='btn'>ยืนยัน</a>";
                $('div.popup').html(element);
                $('.popup').css('display','block');
            }
            else
            {
                alert(data['message']);
            }
        }
        });
    
});

$(document).on('click', '#exchange_otp_verify', function(e) { 
    otp = $('#otp_verify').val();

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "api/center.php?action=withdraw",
        data:  {
            "otp": otp
        },
        success : function(data){
            console.log(data);

            alert(data['message']);

             $('.popup').css('display','none');

             reloadBalance();
        }
        });

     return false;
});

//-------------------------
//Function

function init()
{
	reloadBalance();
	reloadPopularItem();
}

function addSpinner(target)
{
	// htmlcode = "";
	// htmlcode +=
}

function reloadBalance()
{
	 $.ajax({
        type: "POST",
        dataType: 'json',
        url: "api/center.php?action=getbalance",
        data:  {
        },
        success : function(data){
        	$('.maxpoint_balance').html(data['current_amount']);
        }

        });
}

function reloadPopularItem()
{
	$.ajax({
        type: "POST",
        dataType: 'json',
        url: "api/center.php?action=getpopularitem",
        success : function(data){
        	console.log(data);
        	htmlcode = "";
        	$.each(data, function(index,item){
        		htmlcode += "<img src='"+item['imgpath']+"'/>";
        	});

        	$(".popular_items").html(htmlcode);
        }
    });
}

function fill_truemoney()
{
    pass = $('#true_pass_tmp').val();
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "api/center.php?action=fillpoint",
        data:  {
            "true_pass_tmp": pass,
            "channel_id":1
        },
        success : function(data){
            console.log(data);
        }
    });
}

function getTransactionHistory()
{
    alert('getTransactionHistory');
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "api/center.php?action=transactionhistory",
        data:  {
        },
        success : function(data){
            console.log(data);

            //Assign to table
            fill = data['fill'];
            transfer = data['maxpoint_transfer'];
            withdraw = data['withdraw'];

            //FILL TABLE
            var htmlcode = "";
            if(fill)
            {
                $.each(fill, function(index, row){
                   htmlcode += "<tr>"; 
                   htmlcode += "<td>"+row['name']+"</td>";
                   htmlcode += "<td>"+row['desc']+"</td>";
                   htmlcode += "<td>"+row['amount_maxpoint']+"</td>";
                   htmlcode += "<td>"+row['fill_date']+"</td>";
                   htmlcode += "</tr>"; 
                });
            }

             if(htmlcode=="")
                htmlcode = "<tr><td colspan='4'>ยังไม่มีรายการ</tr>";
            $('.my_account_fill tbody').html(htmlcode);

            //TRANSFER TABLE
            var htmlcode = "";
            if(transfer)
            {
                $.each(transfer, function(index, row){
                   htmlcode += "<tr>"; 
                   htmlcode += "<td></td>";
                   htmlcode += "<td>"+row['to_uid']+"</td>";
                   htmlcode += "<td>"+row['amount']+"</td>";
                   htmlcode += "<td>"+row['transfer_date']+"</td>";
                   htmlcode += "</tr>"; 
                });
            }


            if(htmlcode=="")
                htmlcode = "<tr><td colspan='4'>ยังไม่มีรายการ</tr>";
            $('.my_account_transfer tbody').html(htmlcode);

            //WITHDRAW TABLE
            var htmlcode = "";
            if(withdraw)
            {
                $.each(withdraw, function(index, row){
                   htmlcode += "<tr>"; 
                   htmlcode += "<td></td>";
                   htmlcode += "<td>"+row['name']+"</td>";
                   htmlcode += "<td>"+row['acc_no']+"</td>";
                   htmlcode += "<td>"+row['amount_maxpoint']+"</td>";
                   htmlcode += "<td>"+row['amount_baht']+"</td>";
                   htmlcode += "<td>"+row['withdraw_fee']+"</td>";
                   htmlcode += "<td>"+row['withdraw_date']+"</td>";
                   htmlcode += "</tr>"; 
                });
            }
             if(htmlcode=="")
                htmlcode = "<tr><td colspan='7'>ยังไม่มีรายการ</tr>";
            $('.my_account_withdraw tbody').html(htmlcode);
        }
    });
}

function getOnlineUsers(tokenid)
{
    //alert('getOnlineUser');
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://api.vdomax.com/?action=getonlineuser",
        data:  {
            "tokenid":tokenid
        },
        success : function(data){
            console.log(data);

            htmlcode = "";
            $.each(data, function(index,row){
                htmlcode += '<img user-id="'+row['UserID']+'" src="'+row['UserAvatarPathSmall']+'"/>';
            });

            $("#transfer_friends p").html(htmlcode);

        }
    });
}

function getFollowing()
{
    //alert('getOnlineUser');
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://www.vdomax.com/payment/api/center.php?action=getUserDetail",

        success : function(json){
            console.log(json);

            htmlcode = "";
            $.each(json.data['following'], function(index,row){
                imgpath = "../"+row['UserAvatarPathSmall'];
                imgpath = imgpath.replace("_small", "");
                htmlcode += '<img alt="'+row['UserName']+'" username="'+row['UserName']+'" user-id="'+row['UserID']+'" src="'+imgpath+'"/>';
            });

            $("#transfer_friends .fbox").html(htmlcode);

        }
    });
}

//Create Alert Modal
function showAlert(text)
{
    htmlcode = "";
    htmlcode = "<div class='popup'>";
    htmlcode = "<p style='display:block;'>"+text+"</p>";
    htmlcode = "<button class='close'>Close</button>"
    htmlcode = "<div>";

    $('body').append(htmlcode);
}


//End document.ready
});





(function($){
    $.fn.serializeObject = function(){

        var self = this,
            json = {},
            push_counters = {},
            patterns = {
                "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                "push":     /^$/,
                "fixed":    /^\d+$/,
                "named":    /^[a-zA-Z0-9_]+$/
            };


        this.build = function(base, key, value){
            base[key] = value;
            return base;
        };

        this.push_counter = function(key){
            if(push_counters[key] === undefined){
                push_counters[key] = 0;
            }
            return push_counters[key]++;
        };

        $.each($(this).serializeArray(), function(){

            // skip invalid keys
            if(!patterns.validate.test(this.name)){
                return;
            }

            var k,
                keys = this.name.match(patterns.key),
                merge = this.value,
                reverse_key = this.name;

            while((k = keys.pop()) !== undefined){

                // adjust reverse_key
                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                // push
                if(k.match(patterns.push)){
                    merge = self.build([], self.push_counter(reverse_key), merge);
                }

                // fixed
                else if(k.match(patterns.fixed)){
                    merge = self.build([], k, merge);
                }

                // named
                else if(k.match(patterns.named)){
                    merge = self.build({}, k, merge);
                }
            }

            json = $.extend(true, json, merge);
        });

        return json;
    };
})(jQuery);