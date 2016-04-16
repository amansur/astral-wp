var tagList = {};

var $projectNode = document.getElementById('project');
var $homeNode = document.getElementById('home');
var $menu = jQuery('.menu');
var $project = jQuery('.project');
var $topAnchor = jQuery('.topAnchor');
var $projectImage = jQuery('.projectImage');
var $astralBanner = jQuery('.astralBanner');
var startVM = new StartViewModel();
var projectVM = new ProjectViewModel();

ko.applyBindings(startVM, $homeNode); 
ko.applyBindings(projectVM, $projectNode); 

$project.on('mouseleave', function() { $projectImage.hide();});
$projectImage.on('mouseleave', function() { $projectImage.hide();});

$menu.on('click', 'li', function(e) {
	var target = e.currentTarget.children[0].hash.split('/')[2];
	showHome(target);
	return false;
});

$topAnchor.on('click', scrollToTop)

function scrollToTop() {
	$('html, body').animate({ scrollTop: 0 }, 500);
	return false;
};

function scrollToAnchor(anchor) {
	var target = $('#' + anchor);
	var offset = 0;
	if ($menu.css("position") === "fixed")
		offset += $menu.height();
	if ($astralBanner.css("position") === "fixed")
		offset += $astralBanner.height();$('html, body').animate({
    		scrollTop: $(target).offset().top - offset
		}, 500);
	return false;
};

function showProject(slug) { 
	projectVM.slug(slug);
	$menu.find('.menuItem:first-child').css({"background-color" : "white", "color" : "black"})
	$projectNode.style.display = 'block';
	$homeNode.style.display = 'none';
};

function showHome(anchor) {
	window.location.hash = '/home';
	$menu.find('.menuItem:first-child').css({"background-color" : "black", "color" : "white"})
	$projectNode.style.display = 'none';
	$homeNode.style.display = 'block';

	if (anchor !== undefined) {
		scrollToAnchor(anchor);
	}
	projectVM.slug(null);
};

if (window.location.hash === undefined)
	showHome();