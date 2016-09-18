function StartViewModel() {
	var columnCount 		= 3;
	var self 				= this;
	
	self.tags 				= ko.observableArray();
	self.projects 			= ko.observableArray();
	self.introText 			= ko.observable();
	self.footer 			= ko.observableArray();
	self.selectedTags 		= ko.observableArray();
	self.visibleImageUrl 	= ko.observable();
	
	self.getSelectedProjects = function() {
		if (!self.selectedTags() || self.selectedTags().length === 0) {
			return SplitArrayIntoN(self.projects(), columnCount);
		} else {
			var filteredProjects = ko.utils.arrayFilter(self.projects(), function(project) {
            	var show;
            	jQuery.map(project.tags, function(projectTag) {
            		if (self.selectedTags().indexOf(projectTag) !== -1)
            			show = true;
            	});
                return show;
            });
			return SplitArrayIntoN(filteredProjects, columnCount);
		}
	};

	self.selectedProjects = ko.computed(self.getSelectedProjects);	

	self.getTags = function() {
		jQuery.get('/wp-json/wp/v2/project_tag', null, function(data) {
			var _tags = jQuery.map(data, function(item) {
				tagList[item.id] = new Tag(item.id, item.name);
				return tagList[item.id];
			});
			self.tags(_tags);
		});
	};

	self.getProjects = function(allTags) {
		jQuery.get('/wp-json/wp/v2/project?per_page=99', null, function(data) {
			var _projects = jQuery.map(data, function (project) {
				var _projectTags = jQuery.map(project.project_tag, function(tag) {
					return allTags[tag];
				});
				return new Project(project.id, project.slug, project.acf.display_name, null, _projectTags, project.acf.feature_image, null);
			});
			self.projects(_projects);
		});
	};

	self.getConfig = function() {
		jQuery.get('/wp-json/wp/v2/config/174', null, function(data) { //174 astr 173 local
			self.introText(data.acf.heading);
			var columns = jQuery.map(data.acf.footer, function(column) {
				var populatedColumn = [];
				populatedColumn.push(jQuery.map(column.column, function(item) {
					return {heading: item.heading, content: item.content};
				}));
				return populatedColumn;
			});
			self.footer(columns);

		});
	};

	self.getImage = function(id) {
		jQuery.get('/wp-json/wp/v2/media/'+id, null, function(data) {
			self.visibleImageUrl(data.media_details.sizes.thumbnail.source_url);
		});
	};

	self.showFeaturedImage = function(project, event) {
		if (project.featureMedia != null && project.featureMedia != 0) {
			self.getImage(project.featureMedia);
			project.featureMediaUrl(self.visibleImageUrl());
		}

		jQuery('.projectImage').css({
				'position' : 'absolute',
				'top' : event.pageY - (150/project.tags.length),
				'left' : event.pageX - 180});
	};
	
	self.hideFeaturedImage = function(project) {
		self.visibleImageUrl(null);
	};

	self.getTags();
	self.getProjects(tagList);
	self.getConfig();

};