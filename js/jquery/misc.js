// Slider Call
//$(document).ready(function() {
//	$('.slider').cycle({
//		fx: 'scrollVert', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
//		prev:   '#prev', 
//		next:   '#next'
//	});
//});
// Other Scripts
/*$(document).bind("mobileinit", function(){
    $.mobile.touchOverflowEnabled = true;
});*/
 
// Photoswipe Call
$(document).ready(function(){ 
//    var myPhotoSwipe = $(".gallery a").photoSwipe({ enableMouseWheel: false , enableKeyboard: false }); 
 var myPhotoSwipe = null;
    for(var i=0; i < 30; i++)
    {
        if($("#gallery"+i).length>0)
        {
            try
            {
            myPhotoSwipe = $("#gallery" + i + " a").photoSwipe({
                enableMouseWheel: false , 
                enableKeyboard: false
            });
            }
            catch(error){console.log(error);break;}
        }
    }
});