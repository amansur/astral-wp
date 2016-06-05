/// <reference path="../bower_components/jquery/dist/jquery.js" />
/// <reference path="../bower_components/knockout/dist/knockout.debug.js" />
/// <reference path="Model.Tag.js" />
function TagListViewModel(parent) {
	var self			= this;
	self.tags			= ko.observableArray();
	self.selectedTags	= ko.observableArray();
	self.tagLookup	= {};

	jQuery.getJSON(serviceRoot + '/wp/v2/project_tag', null, function (data) {
		self.tags(jQuery.map(data, function (item) {
			self.tagLookup[item.id] = new Tag(item.id, item.name);
			return self.tagLookup[item.id];
		}));
	});
}