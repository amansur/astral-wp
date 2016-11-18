/// <reference path="AppViewModel.js" />
var $projectNode, $homeNode, $menu, $project, $topAnchor, $projectImage, $astralBanner, $wpAdminBar, $body, $backgroundImages, $tags;
var serviceRoot = "/wp-json";
var previousRoute = '';
var appVM = new AppViewModel();
var backgroundImages = new Array();

$(function () {
	$projectNode = document.getElementById('project');
	$homeNode = document.getElementById('home');
	$menu = jQuery('.menu');
	$project = jQuery('.project');
	$topAnchor = jQuery('.topAnchor');
	$projectImage = jQuery('.projectImage');
	$astralBanner = jQuery('.astralBanner');
	$wpAdminBar = jQuery('#wpadminbar');
	$body = jQuery('body');
	$tags = jQuery('.tags');
	$backgroundImages = jQuery('#backgroundImages img');

	ko.applyBindings(appVM, document.getElementById('content'));

	UpdateBackground();

	DisplayScrollToTop();

	$(window).on('scroll', function () {
		DisplayScrollToTop();
	});

	$topAnchor.on('click', ScrollToTop);

	$('#filterLabel').on('click', function () {
		$('#filterList').slideToggle();
	});

	$('#filterApply').on('click', function () {
		$('#filterList').slideToggle();
	});

	$menu.on('click', 'li', function (e) {
		var target = e.currentTarget.children[0].hash.split('/')[2];
		router.setRoute('home/' + target);
		return false;
	});

	$tags.on('click', '.tagLabel', function () {
		$(this).toggleClass('selected');
		if ($(this).hasClass('selected')) {
			$(this).removeClass('tagUnchecked');
			$(this).addClass('tagChecked');
		} else {
			$(this).removeClass('tagChecked');
			$(this).addClass('tagUnchecked');
		}
	});

	$tags.on('mouseenter', '.tagLabel', function () {
		if (!$(this).hasClass('selected')) {
			$(this).addClass('tagChecked');
			$(this).removeClass('tagUnchecked');
		}
	});

	$tags.on('mouseleave', '.tagLabel', function () {
		if (!$(this).hasClass('selected')) {
			$(this).removeClass('tagChecked');
			$(this).addClass('tagUnchecked');
		}
	});
	
	router.configure();
	router.init();
	var hash = window.location.hash;
	var base = window.location.href.split('#')[0];
	router.setRoute(hash.substr(1));
	//if (hash !== '')
		//window.location.href = base + hash;
	//router.setRoute('home');
	
	//if (hash === '') {
	//	router.setRoute('home');
	//	console.log('routing home');
	//} else {
	//	router.setRoute(hash.substr(1));
	//	console.log('routing to', hash.substr(1));
	//}
});

