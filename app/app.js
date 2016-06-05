/// <reference path="AppViewModel.js" />


var $projectNode = document.getElementById('project');
var $homeNode = document.getElementById('home');
var $menu = jQuery('.menu');
var $project = jQuery('.project');
var $topAnchor = jQuery('.topAnchor');
var $projectImage = jQuery('.projectImage');
var $astralBanner = jQuery('.astralBanner');

var serviceRoot = "http://192.168.99.100:8081/wp-json";
var appVM = new AppViewModel();

$(function () {

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
	});

	$menu.on('click', 'li', function (e) {
		var target = e.currentTarget.children[0].hash.split('/')[2];
		router.setRoute('home/' + target);
		return false;
	});

	router.setRoute('home');
});	