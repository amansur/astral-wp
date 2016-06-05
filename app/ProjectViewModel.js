/// <reference path="../bower_components/jquery/dist/jquery.js" />
/// <reference path="../bower_components/knockout/dist/knockout.debug.js" />
/// <reference path="Model.Project.js" />
/// <reference path="Model.Media.js" />
/// <reference path="Model.Tag.js" />
/// <reference path="TagListViewModel.js" />
/// <reference path="ProjectListViewModel.js" />


function ProjectViewModel(parent) {
	var self 			= this;
	self.slug = ko.observable();
	self.next = ko.observable();
	self.prev = ko.observable();
	self.project = ko.observable();

	var i = 0;
	ko.computed(function () {
		//console.log(i++);
		var projectLookup = parent.projectListVM.projectLookup();
		var slug = self.slug();

		if (projectLookup.length === 0) {
			return false;
		}

		if (slug === undefined || slug === null) {
			self.project(new Project());
			return false;
		}

		jQuery.getJSON(serviceRoot + '/astral/v1/project/' + slug, null, function (data) {
			var _projectTags = jQuery.map(data.tags, function (tag) {
				return parent.tagListVM.tagLookup[tag.id];
			});
			var _projectMedia = jQuery.map(data.media, function (media) {
				return new Media(media.content, media.description, media.type);
			});
			_project = new Project(data.id, data.slug, data.name, data.description, _projectTags, null, _projectMedia);
			self.project(_project);

			var cur, next, prev;
			projectLookup.forEach(function (ele, ind) {
				if (ele === slug) {
					cur = ind;
				}
			});
			if (cur === 0) {
				next = 1;
				prev = projectLookup.length - 1;
			} else if (cur === projectLookup.length - 1) {
				next = 0;
				prev = projectLookup.length - 2;
			} else {
				next = cur + 1;
				prev = cur - 1;
			}
			self.next(projectLookup[next]);
			self.prev(projectLookup[prev]);
		});
		
		return false;

	});
};