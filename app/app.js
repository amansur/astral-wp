/// <reference path="AppViewModel.js" />
var $projectNode, $homeNode, $menu, $project, $topAnchor, $projectImage, $astralBanner, $wpAdminBar;
var serviceRoot = "http://192.168.99.100:8081/wp-json";
var previousRoute = '';
var appVM = new AppViewModel();
var backgroundImages = new Array();

$(function () {
	LoadBackgroundImages();
	$projectNode = document.getElementById('project');
	$homeNode = document.getElementById('home');
	$menu = jQuery('.menu');
	$project = jQuery('.project');
	$topAnchor = jQuery('.topAnchor');
	$projectImage = jQuery('.projectImage');
	$astralBanner = jQuery('.astralBanner');
	$wpAdminBar = jQuery('#wpadminbar');

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
		appVM.projectListVM.updateSelectedProjectList();
		$('#filterList').slideToggle();
	});

	$menu.on('click', 'li', function (e) {
		var target = e.currentTarget.children[0].hash.split('/')[2];
		router.setRoute('home/' + target);
		return false;
	});

	router.configure();
	router.init();
	router.setRoute('home');
});	