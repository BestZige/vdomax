{include file='/home/new2/content/themes/vdomax/templates/headinclude.tpl'}
{include file='/home/new2/content/themes/vdomax/templates/header.tpl'}

<!-- Commom [apps] JS -->
<script type="text/javascript" src="{$SITE_URL}/js/core.apps.js"></script>
<script type="text/javascript" src="{$SITE_URL}/js/core.posts.js"></script>
<script type="text/javascript" src="{$SITE_URL}/js/core.publisher.js"></script>
<script type="text/javascript" src="{$SITE_URL}/js/core.tricker.js"></script>
<link rel="stylesheet" type="text/css" href="{$SITE_URL}/payment/css/style.css" />
<script type="text/javascript" src="script/payment.js"></script>

<!-- <script type="text/javascript" src="script/bootstrap.min.js"></script> -->

<!-- Commom [apps] JS -->

<!-- Content -->
<div class="contentWrapper">
    <div class="content">
        
        <table class="mainContent">
            <tr>
                <!-- Left Panel -->
                <td class="leftPanel">
                    {include file='/home/new2/content/themes/vdomax/templates/appsmenu.tpl'}
                </td>
                <!-- Left Panel -->
                
                <!-- Center Panel -->
                <td class="centerPanel">                    
                
                    
                    <div class="centerPanelContent">
        <div class="container">

            <header>
                <h1><span>MaxPoint</span> Center</h1>
            </header>
            <section class="tabs" id="maxpoint_center_tabs">
                <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1" checked="checked" />
                <label for="tab-1" class="tab-label-1">หน้าแรก</label>
        
                <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2" />
                <label for="tab-2" class="tab-label-2">เติม</label>
        
                <input id="tab-3" type="radio" name="radio-set" class="tab-selector-3 transfer_tab" />
                <label for="tab-3" class="tab-label-3">โอน</label>
            
                <input id="tab-4" type="radio" name="radio-set" class="tab-selector-4 my_account_tab" />
                <label for="tab-4" class="tab-label-4">บัญชีฉัน</label>
                
                 <input id="tab-5" type="radio" name="radio-set" class="tab-selector-5" />
                <label for="tab-5" class="tab-label-5">รับเงิน</label>
            
                <div class="clear-shadow"></div>
                
                <div class="content">
                    <div class="sub content-1">
                        <h2>MaxPoint คงเหลือ : <span class="maxpoint_balance">0</span> MP</h2>         
                        
                        <h3>Promotion</h3>
                        <p>
                            เติม MaxPoint ก่อน 31 ธ.ค. 56 แถมไอเท็มแจกสาวฟรี อัยย่ะ !<br/>
                        </p>
                        <h3>Item ยอดนิยม</h3>
                        <p class="items popular_items">
                            <img src="images/1-flower.png"/>
                            <img src="images/1-flower.png"/>
                            <img src="images/3-flower.png"/>
                            <img src="images/3-flower.png"/>
                            <img src="images/1-flower.png"/>
                            <img src="images/3-flower.png"/>
                            <img src="images/1-flower.png"/>
                        </p>
                    </div>
                    <div class="sub content-2">
                       <h2>MaxPoint คงเหลือ : <span class="maxpoint_balance">0</span> MP</h2>
                       <h3>ช่องทางการเติม MaxPoint</h3>
                        <p class="select"> 
                            <img class="channel truemoney" src="images/truemoney.jpg" />
                            <img class="channel paypal" src="images/paypal.jpg" />
                            <!--
                            <img class="channel paysbuy" src="images/paysbuy.png" />
                            <img class="channel kbank" src="images/kbank.jpg" />  
                            -->
                                                       
                        </p>
                        <div id="pay-channel-1" class="payform">
                        <h3>TRUEMONEY</h3>
                            <div style="float:left;width:400px;padding:35px;">
                                <span><input type="text" id="true_pass_tmp" name="true_pass_tmp"></span>
                                <a href="#" class="btn" id="truemoney_fill" >เติมเงิน</a>
                                <input type="hidden" name="channel_id" value="1">
                            </div>
                            <!--
                            <div style="float:left;width:200px">
                                100 THB = 1000 MP<br/>
                                200 THB = 2000 MP<br/>
                                500 THB = 5000 MP<br/>
                                1000 THB = 10000 MP<br/>
                            </div>
                            -->
                            </div>
                            <div id="pay-channel-2" class="payform">
                        <h3>PAYPAL</h3>
                         <div>
               
                            <script src="script/paypal-button.min.js?merchant=SDJSNF2VY4B34" 
    data-button="Topup" 
    data-name="VDOMax: MaxPoint 1000 MP" 
    data-quantity="1" 
    data-amount="100" 
    data-currency="THB" 
    data-shipping="0" 
    data-tax="0" 
    data-callback="http://www.vdomax.com/payment/api/paypal.php"
></script>
<script src="script/paypal-button.min.js?merchant=SDJSNF2VY4B34" 
    data-button="Topup" 
    data-name="VDOMax: MaxPoint 2000 MP" 
    data-quantity="1" 
    data-amount="200" 
    data-currency="THB" 
    data-shipping="0" 
    data-tax="0" 
    data-callback="http://www.vdomax.com/payment/api/paypal.php"
></script>
<script src="script/paypal-button.min.js?merchant=SDJSNF2VY4B34" 
    data-button="Topup" 
    data-name="VDOMax: MaxPoint 5000 MP" 
    data-quantity="1" 
    data-amount="500" 
    data-currency="THB" 
    data-shipping="0" 
    data-tax="0" 
    data-callback="http://www.vdomax.com/payment/api/paypal.php"
></script>
<script src="script/paypal-button.min.js?merchant=SDJSNF2VY4B34" 
    data-button="Topup" 
    data-name="VDOMax: MaxPoint 100000 MP" 
    data-quantity="1" 
    data-amount="1000" 
    data-currency="THB" 
    data-shipping="0" 
    data-tax="0" 
    data-callback="http://www.vdomax.com/payment/api/paypal.php"
></script>
</div>
                            </div>


                            


                        
                    </div>
                    <div class="sub content-3" id="transfer_friends">
                    <h2>MaxPoint คงเหลือ : <span class="maxpoint_balance">0</span> MP</h2>         
                        <h3>โอนให้เพื่อน (เลือกเพื่อนที่ต้องการจะโอน)</h3>
                        <p class="fbox">
                                 <img src="{$SITE_URL}/content/themes/vdomax/images/misc/no_avatar.png"/>
                            <img src="{$SITE_URL}/content/themes/vdomax/images/misc/no_avatar.png"/>
                            <img src="{$SITE_URL}/content/themes/vdomax/images/misc/no_avatar.png"/>
                        </p>
                        <h3>จำนวน Max Points</h3>
                        <p>
                            <span><input type="text" class="input-big" id="maxpoint_to_transfer" name="maxpoint_to_transfer"></span>
                                <a href="#" class="btn" id="maxpoint_transfer_button" >โอน</a>
                        </p>
                        
                    </div>
                    <div class="sub content-4">
                        <h2>MaxPoint คงเหลือ : <span class="maxpoint_balance">0</span> MP</h2>         
                        <h3>ประวัติการเติมเงิน</h3>
                        <table class="my_account_fill">
                            <thead><tr><th>ช่องทาง</th><th>รายละเอียด</th><th>จำนวน (MP)</th><th>เวลา</th></tr></thead>
                            <tbody>
                            <tr><td><img src="images/truemoney.jpg" height="30" /></td><td>บัตรเติมเงิน</td><td>20</td><td>12:13:14 วันที่ 24/12/2556</td></tr>
                            <tr><td><img src="images/paysbuy.png" height="30" /></td><td>Counter Service</td><td>20</td><td>12:13:14 วันที่ 24/12/2556</td></tr>
                            <tr><td><img src="images/kasikornbank_logo.gif" height="30" /></td><td>Direct Debit</td><td>20</td><td>12:13:14 วันที่ 24/12/2556</td></tr>
                            </tbody>
                        </table>
                        <h3>ประวัติการโอนเงิน</h3>
                        <table class="my_account_transfer">
                            <thead>
                                <tr><th colspan="2">โอนให้</th><th>จำนวน (MP)</th><th>เวลา</th></tr>
                            </thead>
                            <tbody>
                            <!-- <tr><td><img src="http://www.vdomax.com/content/themes/vdomax/images/misc/no_avatar.png" width="30" /></td><td>นาย ก.</td><td>20</td><td>12:13:14 วันที่ 24/12/2556</td></tr>
                            <tr><td><img src="http://www.vdomax.com/content/themes/vdomax/images/misc/no_avatar.png" width="30" /></td><td>นาย ข.</td><td>20</td><td>12:13:14 วันที่ 24/12/2556</td></tr>
                            <tr><td><img src="http://www.vdomax.com/content/themes/vdomax/images/misc/no_avatar.png" width="30" /></td><td>นาย ค.</td><td>20</td><td>12:13:14 วันที่ 24/12/2556</td></tr> -->
                            </tbody>
                        </table>
                        <h3>ประวัติการถอนเงิน</h3>
                        <table class="my_account_withdraw">
                            <thead>
                                <tr><th colspan="2">ธนาคาร</th><th>เลขบัญชี</th><th>จำนวน (MP)</th><th>คิดเป็นเงิน (THB)</th><th>ค่าบริการ</th><th>เวลา</th></tr>
                            </thead>
                            <tbody>
                           <!--  <tr><td><img src="images/logo_kbank.jpg" width="30" /></td><td>กสิกรไทย</td><td>123-432-1234</td><td>2000</td><td>200</td><td>15</td><td>12:13:14 วันที่ 24/12/2556</td></tr>
                            <tr><td><img src="images/logo_bbl.png" width="30" /></td><td>กรุงเทพ</td><td>123-432-1234</td><td>3000</td><td>300</td><td>15</td><td>12:13:14 วันที่ 24/12/2556</td></tr>
                            <tr><td><img src="images/logo_scb.png" width="30" /></td><td>ไทยพานิชย์</td><td>123-432-1234</td><td 10000</td><td>1000</td><td>10</td><td>12:13:14 วันที่ 24/12/2556</td></tr> -->
                            </tbody>
                        </table>
                    </div>
                    <div class="sub content-5">
                        <h2>MaxPoint คงเหลือ : <span class="maxpoint_balance">0</span> MP</h2> 
                        {if $is_acc_verify}
                            <h3>แลกเปลี่ยน Max Point เป็นเงินบาท</h3>
                            <p>
                                Max Point <input style="width:100px;" class="input-big" type="text" id="exchange_mp" name="exchange_mp"> >> <input style="width:100px;" class="input-big" type="text" id="exchange_baht" name="exchange_baht"> Baht
                                <br>
                                <br><br>
                                <a href="#" id="exchange" class="btn">แลกเปลี่ยน</a>
                            </p>
                        {else}
                            <h3>เลือกธนาคาร</h3>
                            <p>
                                <select id="bank" name="bank">
                                {foreach from=$banks item=bank}
                                    <option value="{$bank['id']}">{$bank['name']}</option>    
                                {/foreach}  
                                </select>
                            </p>
                            <h3>ใส่เลขบัญชีธนาคาร</h3>
                            <p style="float:left;width:600px;padding:35px;">
                                <span><input class="input-big" type="text" id="account_verify" name="account_verify"></span>
                            <a href="#" id="acc_no_button" class="btn">ใส่เลขบัญชีธนาคาร</a>
                            </p>
                            <p>หมายเหตุ: เมื่อใส่แล้ว ไม่สามารถเปลี่ยนเลขบัญชีสำหรับโอนเงินออกได้ </p>  
                        {/if}
                          
                            <div class="popup" style="display:none;">
                                กรอกเบอร์มือถือที่ท่านต้องการรับรหัส OTP
                                <br><br><input class="input-big" type="text" id="mobile_verify" name="mobile_verify">
                                &nbsp;<a href="#" id="send_to_verify" class="btn">ยืนยัน</a>
                            </div>
                    </div>
                </div>
            </section>
            
        </div>					
                                                
                    </div>
                </td>
                <!-- Center Panel -->
                
                <!-- Right Panel -->
                <td class="rightPanel">
                    
					<div class="sectionContainer" style="width:100%;text-align:center;margin:auto;float:center;">
						<center>
							<script language="JavaScript" src="http://a.admaxserver.com/servlet/ajrotator/878344/0/vj?z=admaxasia2&dim=280733&pid=c65cde88-7962-41f9-b33b-684f52b69bec&asid=04306b4b-f5c4-406b-9b51-b0d131622b58"></script><noscript><a href="http://a.admaxserver.com/servlet/ajrotator/878344/0/cc?z=admaxasia2&pid=c65cde88-7962-41f9-b33b-684f52b69bec&asid=04306b4b-f5c4-406b-9b51-b0d131622b58"><img src="http://a.admaxserver.com/servlet/ajrotator/878344/0/vc?z=admaxasia2&dim=280733&pid=c65cde88-7962-41f9-b33b-684f52b69bec&asid=04306b4b-f5c4-406b-9b51-b0d131622b58&abr=$imginiframe" width="300" height="250" border="0"></a></noscript>
						</center>
					</div>
					
                    <!-- Tricker -->
                    <div class="tricker">
                        <ul class="trickerMenu" id="liveTricker">
                            <div class="pt10 pb10 pl10 pr10 tcenter"><img src="{$spinner.small}" /></div>
                        </ul>
                    </div>
                    <!-- Tricker -->
                    
                    {if $todayBirthday}
                        <!-- Today's Birthdays -->
                        <div class="sectionHeader mt10">
                            <strong>Today's Birthdays</strong>
                        </div>
                        <div class="sectionContainer">
                            {foreach $birthdays as $birthday}
                                <span class="showflyHint left">
                                    <!-- flyHint -->
                                    <div class="flyHintWrapper hidden">{$birthday.UserFirstName} {$birthday.UserLastName}<i class="arrow"></i></div>
                                    <!-- flyHint -->
                                    <a class="inline" style="width: 30px; height: 30px; margin: 0 {if ($birthday@index+1)%7 == 0}0{else}2px{/if} 2px 0" href="{$birthday.UserName}/wall"><img src="{$SITE_URL}/{$birthday.UserAvatarPathSmall}" /></a>
                                </span>
                            {/foreach}
                        </div>
                        <!-- Today's Birthdays -->
                    {/if}
					<!-- VIP -->
                    {include file='/home/new2/content/themes/vdomax/templates/now-vip.tpl' margin='10'}
                    <!-- VIP -->
                    
					<!-- Online -->
                    {include file='/home/new2/content/themes/vdomax/templates/now-online.tpl' margin='10'}
                    <!-- Online -->
					
                    <!-- Sponsored Ads -->
                    {include file='/home/new2/content/themes/vdomax/templates/rp.sponsored.tpl' margin='10'}
                    <!-- Sponsored Ads -->
                    
                </td>
                <!-- Right Panel -->
            </tr>
        </table>
        
    </div>
</div>
<!-- Content -->

{include file='/home/new2/content/themes/vdomax/templates/footer.tpl' footerType = 'narrow'}

<!-- <div id="fade"></div> -->