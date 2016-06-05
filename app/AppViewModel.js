/// <reference path="../bower_components/jquery/dist/jquery.js" />
/// <reference path="../bower_components/knockout/dist/knockout.debug.js" />
/// <reference path="Model.Project.js" />
/// <reference path="Model.Media.js" />
/// <reference path="Model.Tag.js" />
/// <reference path="TagListViewModel.js" />
/// <reference path="ProjectListViewModel.js" />
/// <reference path="ProjectViewModel.js" />

function AppViewModel() {
	var self = this;
	//self.tagDictionary		= {};
	self.tagListVM = new TagListViewModel(self);
	self.projectListVM = new ProjectListViewModel(self);
	self.projectVM = new ProjectViewModel(self);
	self.visibleImageURL = ko.observable();
};