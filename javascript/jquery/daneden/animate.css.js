
// --------------------------------------------------------------------
//	# Animate.css
// --------------------------------------------------------------------

/*
// Timing CSS animations with JavaScript
$target = $('.screen--red .avatar');
$target.animateCss('rotateIn');
var animate_interval = setInterval(function ()
{
	$target.animateCss('tada');
}, 3000);
*/
$.fn.extend({
    animateCss: function ( animationName )
	{
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $(this).addClass('animated ' + animationName).one(animationEnd, function ()
		{
            $(this).removeClass('animated ' + animationName);
        });
    }
});
