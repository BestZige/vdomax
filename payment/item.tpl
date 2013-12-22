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
        
                <input id="tab-2" id="watch_live_tab" type="radio" name="radio-set" class="tab-selector-2" />
                <label for="tab-2" class="tab-label-2">Live</label>
            
                <div class="clear-shadow"></div>
                
                <div class="content">
                    <div class="sub content-1">
                        <h2>MaxPoint คงเหลือ : <span class="maxpoint_balance">0</span> MP</h2>         
                        
                    </div>
                   
                    <div class="sub content-2" id="watch_live">
                    <h2>MaxPoint คงเหลือ : <span class="maxpoint_balance">0</span> MP</h2>         
                        <h3>หน้า Live</h3>
                        <p>
                            <div class="item_live_div" style="width:550px;">
                                <video width="480" height="240" controls>
                                  <!-- <source src="movie.mp4" type="video/mp4"> -->
                                  <!-- <source src="movie.ogg" type="video/ogg"> -->
                                    <!-- Your browser does not support the video tag. -->
                                </video>
                                <div>
                                    <ul class="item_live_list">
                                        <li class="item"><img src=""></li>
                                        <li class="item"><img src=""></li>
                                        <li class="item"><img src=""></li>
                                        <li class="item"><img src=""></li>
                                        <li class="item"><img src=""></li>
                                        <li class="item"><img src=""></li>
                                        <li class="item"><img src=""></li>
                                        <li class="item"><img src=""></li>
                                        <li class="item"><img src=""></li>
                                        <li class="item"><img src=""></li>
                                        <!-- <li>Add</li> -->
                                    </ul>
                                    <div style="float:right;">
                                        <!-- <span class="item_name"style="color:#3b5998;">[Item Name]</span> -->
                                        <input id="send_item_quantity" type="text" style="width:40px;"> <span>ชิ้น</span>
                                        <button id="send_item" class="">ส่ง</button>
                                    </div>
                                </div>
                            </div>
                        </p>
                    
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