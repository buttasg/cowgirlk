jQuery.noConflict();var errorColor="#C2BAB4";var normalColor="#C2BAB4";jQuery(function($){var config={over:function(){$('.mycart .cart-arrow').animate({opacity:1,height:'toggle'},200);},timeout:200,out:function(){$('.mycart .cart-arrow').animate({opacity:0,height:'toggle'},200);}};$("li.mycart").hoverIntent(config);})
var showYopto=false;function getYopyo(){var isCategoryPage=jQuery('body').hasClass('catalog-product-view');var formatted=false;jQuery('div.bottomLine').each(function(){var txt=jQuery('.result_status .text',this);var stars=jQuery('.result_status .stars',this);if(txt.text()=='default')
{if(!isCategoryPage){txt.text('');}
else
{txt.text(' (0 Reviews)');}
var starHtml='<img class="yoStar yoStarFull" src="'+SKIN_URL+'/images/star-empty.png">';starHtml+='<img class="yoStar yoStarFull" src="'+SKIN_URL+'/images/star-empty.png">';starHtml+='<img class="yoStar yoStarFull" src="'+SKIN_URL+'/images/star-empty.png">';starHtml+='<img class="yoStar yoStarFull" src="'+SKIN_URL+'/images/star-empty.png">';starHtml+='<img class="yoStar yoStarFull" src="'+SKIN_URL+'/images/star-empty.png">';stars.html(starHtml);jQuery(this).css('visibility','visible').show();}
		else
		{      
		       if(formatted==false){
		        var txtnumber=jQuery('.result_status .text .yoResult',jQuery('.product-rating-sec'));
	       		var tmpText=txtnumber.text();
	       		txtnumber.text('');
			txtnumber.text(' ('+tmpText+')');
			formatted=true;
			}
			
		}
		
		});};function setYoptoWidget()
{}	
jQuery(function($){var facebook=document.cookie;if(facebook=="facebooklike=1")
{jQuery('#cgk_facebook_button').css('z-index','999');jQuery('#cgk_facebook_button').css('background','url('+SKIN_URL+'/images/liked-btn.png)');}
else
{jQuery('#cgk_facebook_button').css('background','url('+SKIN_URL+'/images/like-btn.png)');}});function facebookLike()
{jQuery.cookie("facebooklike","1");jQuery('#cgk_facebook_button').css('z-index','999');jQuery('#cgk_facebook_button').css('background','url('+SKIN_URL+'/images/liked-btn.png)');}
function facebookDislike()
{jQuery.cookie("facebooklike",null);jQuery('#cgk_facebook_button').css('background','url('+SKIN_URL+'/images/like-btn.png)');}
jQuery(function($){jQuery('#btnfb').click(function(){var fbsrc=jQuery('#facebook_like_button_holder iframe').attr('src');window.open(fbsrc,"popupWindow","width=450,height=450,scrollbars=no");});});jQuery('#login_btn').click(function(){validateLogin();});function validateLogin()
{var email=jQuery("#email").val();var passwd=jQuery("#login_pass").val();var valid=true;if(!validateEmail(email)){jQuery("#email").css("color",errorColor);jQuery("#for-email").removeClass('no-display');valid=false;}else{jQuery("#email").css("color",normalColor);jQuery("#for-email").addClass('no-display');}
if(passwd==''||passwd=='Password *'){jQuery("#login_fake_pwd").css("color",errorColor);jQuery("#for-login_pass").removeClass('no-display');valid=false;}else{jQuery("#login_fake_pwd").css("color",normalColor);jQuery("#for-login_pass").addClass('no-display');}
if(valid==false)
return valid;jQuery("#login-form").submit();return false;};function validateRegistration()
{var firstname=jQuery("#firstname");var lastname=jQuery("#lastname");var email=jQuery('#email_address');var password=jQuery('#password');var confirmation=jQuery('#confirmation');var valid=true;if(firstname.val()==''||firstname.val()==firstname.attr("data-watermark")){firstname.css("color",errorColor);jQuery("#for-firstname").removeClass('no-display');valid=false;}else{firstname.css("color",normalColor);jQuery("#for-firstname").addClass('no-display');}
if(lastname.val()==''||lastname.val()==lastname.attr("data-watermark")){lastname.css("color",errorColor);jQuery("#for-lastname").removeClass('no-display');valid=false;}else{lastname.css("color",normalColor);jQuery("#for-lastname").addClass('no-display');}
if(!validateEmail(email.val())){email.css("color",errorColor);jQuery("#for-email_address").removeClass('no-display');valid=false;}else{email.css("color",normalColor);jQuery("#for-email_address").addClass('no-display');}
if(password.val()==''||password.val()=='Password *'){jQuery("#register_fake_pwd").css("color",errorColor);jQuery("#for-password").removeClass('no-display');valid=false;}else{jQuery("#register_fake_pwd").css("color",normalColor);jQuery("#for-password").addClass('no-display');}
if(confirmation.val()==''||confirmation.val()=='Re-Enter Password *'){jQuery("#register_fake_confirm").css("color",errorColor);jQuery("#for-confirmation").removeClass('no-display');valid=false;}else{jQuery("#register_fake_confirm").css("color",normalColor);jQuery("#for-confirmation").addClass('no-display');if(confirmation.val()!=password.val()){jQuery("#for-confirmation").removeClass('no-display');valid=false;}else{jQuery("#for-confirmation").addClass('no-display');}}
if(valid==false)
return valid;jQuery("#form-validate").submit();return false;};function setYoptoWidget()
{}
jQuery(document).ready(function(){jQuery(":input[data-watermark]").each(function(){var wid=jQuery(this).attr('id');var val=jQuery(this).val();if(val==''){jQuery(this).before('<span id="watermark-'+wid+'" class="watermark">'+jQuery(this).attr("data-watermark")+'</span>');}
else
{jQuery(this).before('<span id="watermark-'+wid+'" class="watermark no-display">'+jQuery(this).attr("data-watermark")+'</span>');}});jQuery('span.watermark').on('click',function(){jQuery(this).next().focus();});jQuery(":input[data-watermark]").keydown(function(){if(jQuery(this).val().length>0)
{jQuery(this).prev().addClass('no-display');}
if(jQuery(this).val().length==0)
{jQuery(this).prev().removeClass('no-display');}});jQuery(":input[data-watermark]").keyup(function(){if(jQuery(this).val().length>0)
{jQuery(this).prev().addClass('no-display');}
if(jQuery(this).val().length==0)
{jQuery(this).prev().removeClass('no-display');}});});function validateForm(formId)
{var form=new VarienForm(formId,true);}
function validateEmail(email)
{var reg=/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
if(reg.test(email)){return true;}
else{return false;}}
