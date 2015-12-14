(function($){$.fn.cc=function(options)
{var settings=$.extend({textId:"#textbox",buttonId:"#btn",errorDivId:"#error_cc",fadeImgPath:"fade.jpg",highlightImgPath:"highlight.jpg",url:"highlight.jpg",modalId:".congratulations-popup",method:"POST"},options);var buttonId=settings.buttonId;var errorDivId=settings.errorDivId;var email=$(settings.textId); applyFade();var modalId=settings.modalId;$(settings.textId).keyup(function(){if(email.val().length>0)
{removeFade();}
else
{applyFade();$(errorDivId).html('').addClass('no-dispaly');}});$(buttonId).click(function(){if(email.val().length>0)
{if(!validateEmail(email.val()))
{$(errorDivId).html('Please enter valid email address.');$(errorDivId).removeClass('no-dispaly');}
else
{$(errorDivId).html('Please wait...').removeClass('no-dispaly');$.ajax({type:settings.method,url:settings.url,data:{email:email.val()},error:function(){$(errorDivId).removeClass('no-dispaly').html('An error occured. Please try later.')},success:function(data)
{ email.val('');$(errorDivId).html(data.message);/*.addClass('no-dispaly');$(settings.textId).val('');showWaterMark();*/applyFade();if(data.error)
{$(errorDivId).html(data.message).removeClass('no-dispaly');}
if(data.success)
{$(modalId).bPopup({onOpen:function(){setTimeout(function(){$(modalId).bPopup().close();},8000);},fadeSpeed:'fast',followSpeed:1500,modalColor:'white'});}}})}}});function applyFade()
{$(buttonId).css({"opacity":"0.5","cursor":"default"});}
function removeFade()
{$(buttonId).css({"opacity":"1","cursor":"pointer"});} function showWaterMark(){ var id=settings.textId.replace('#','');$('#watermark-'+id).removeClass('no-display');}   }}(jQuery));
