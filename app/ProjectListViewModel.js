/// <reference path="../bower_components/jquery/dist/jquery.js" />
/// <reference path="../bower_components/knockout/dist/knockout.debug.js" />
/// <reference path="Model.Project.js" />
/// <reference path="Model.Tag.js" />
function ProjectListViewModel(parent) {
	var columnCount = 3;
	var self = this;
	self.projects = ko.observableArray();
	self.projectLookup = ko.observableArray();
	self.selectedProjects = ko.observableArray();
	self.selectedTagsSummary = ko.observable();

	jQuery.getJSON(serviceRoot + '/astral/v1/project', null, function (data) {
		var _projectLookup = [];
		self.projects(jQuery.map(data, function (item, i) {
			var _tags = jQuery.map(item.tags, function (_tag) {
				return parent.tagListVM.tagLookup[_tag.id];
			})
			_projectLookup.push(item.slug);
			return new Project(item.id, item.slug, item.name, null, _tags, item.featureImage[0], null);
		}));
		self.projectLookup(_projectLookup);
		self.updateSelectedProjectList();
	});

	self.updateSelectedProjectList = function () {
		if (!parent.tagListVM.selectedTags() || parent.tagListVM.selectedTags().length === 0) {
			self.projectLookup([]);
			var _projectLookup = [];
			self.projects().forEach(function (ele, ind) {
				_projectLookup.push(ele.slug);
			});
			self.projectLookup(_projectLookup);
			self.selectedProjects(SplitArrayIntoN(self.projects(), columnCount));
			self.selectedTagsSummary("");
		} else {
			self.projectLookup([]);
			var filteredProjects = ko.utils.arrayFilter(self.projects(), function (project) {
				var show = false;
				var _projectLookup = [];
				project.tags.forEach(function (projectTag) {
					if (parent.tagListVM.selectedTags().indexOf(projectTag) !== -1) {
						_projectLookup.push(project.slug);
						show = true;
					}
				});
				self.projectLookup(_projectLookup);
				return show;
			});
			self.selectedProjects(SplitArrayIntoN(filteredProjects, columnCount));
			self.selectedTagsSummary(self.updateSelectedTagsSummary());
		}
	};

	self.updateSelectedTagsSummary = function () {
		var tagsSummary = "Showing: ";
		var tags = parent.tagListVM.selectedTags().map(function (curr) {
			return '"' + curr.name + '"';
		}).join(", ");
		tagsSummary += tags;
		return tagsSummary;
	};

	self.clearFilter = function () {
		parent.tagListVM.selectedTags([]);
		self.updateSelectedProjectList();
		ClearTagCheckboxes();
	};
}