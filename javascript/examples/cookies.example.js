
// Track visited CFRTraining urls
var parsed_url = parse_url(window.location.href);
var visited_urls = $.cookie('cfrtraining');
visited_urls = visited_urls ? JSON.parse(visited_urls) : [];
if ( visited_urls.indexOf(parsed_url.path) < 0 )
{
	visited_urls.push(parsed_url.path);
	$.cookie('cfrtraining', JSON.stringify(visited_urls), {expires: 0, path: '/', domain: '', secure: false});
}
// Highlight visited areas
var $sitemap = $('.sitemap-content');
var $internal = $('nav[role="navigation"]');
var $products = $('.products-sub-nav');
for ( i = 0; i < visited_urls.length; i++ )
{
	var url = visited_urls[i];
	$sitemap.find('a[href="' + url + '"]')
	.add( $internal.find('a[href="' + url + '"]') )
	.add( $products.find('a[href="' + url + '"]').parent() )
	.addClass('visited');
}
