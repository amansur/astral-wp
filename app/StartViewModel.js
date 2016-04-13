function StartViewModel() {
	var columnCount = 3;
	var tagList = {};
	var self = this;
	
	self.visibleImageUrl 	= ko.observable();
	self.introText 			= ko.observable();
	self.footer 			= ko.observableArray();
	self.projects 			= ko.observableArray();
	self.tags 				= ko.observableArray();
	self.selectedTags 		= ko.observableArray();

	self.getSelectedProjects = function() {
		if (!self.selectedTags() || self.selectedTags().length === 0) {
			return SplitArrayIntoN(self.projects(), columnCount);
		} else {
			var filteredProjects = ko.utils.arrayFilter(self.projects(), function(project) {
            	var show;
            	project.tags.forEach(function(val) {
            		if (self.selectedTags().indexOf(val) !== -1)
            			show = true;
            	})
                return show;
            });
            return SplitArrayIntoN(filteredProjects, columnCount);
		}
	};

	self.selectedProjects = ko.computed(getSelectedProjects);	
	
	self.getTags = function() {
		jQuery.get('/wp-json/wp/v2/project_tag', null, function(data) {
			var obj = [];
			for(var i = 0; i < data.length; i++) {
				var rec = data[i];
				var tag = new Tag(rec.id, rec.name);
				obj.push(tag);
				tagList[rec.id] = tag;
			}
			self.tags(obj);
		});
	};

	self.getProjects = function() {
		jQuery.get('http://astr.nsur.org/wp-json/wp/v2/project', null, function(data) {
			var obj = [];
			for(var i = 0; i < data.length; i++) {
				var rec = data[i];
				var projectTags = [];
				for(var j = 0; j < rec.project_tag.length; j++) {
					projectTags.push(tagList[rec.project_tag[j]])
				}
				var displayHeight = 39 + 24 * (Math.ceil(projectTags.length / 6));
				var project = new Project(rec.id, rec.acf.display_name, projectTags, rec.acf.feature_image, null, displayHeight);
				obj.push(project);
			}
			self.projects(obj);
		});
	};

	self.getConfig = function() {
		jQuery.get('http://astr.nsur.org/wp-json/wp/v2/config/174', null, function(data) { //174 astr 173 local
			self.introText(data.acf.heading);
			data.acf.footer.forEach(function(column) {
				var _column = [];
				column.column.forEach(function(item) {
					var _item = {heading: item.heading, content: item.content};
					_column.push(_item);
				});
				self.footer.push(_column);
			});
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
			setTimeout(function() { project.showImage(true)}, 100);
		}
		jQuery('.projectImage').css('position', 'absolute').css('top', event.pageY + 40).css('left', event.pageX);
	};
	
	self.hideFeaturedImage = function(project) {
		project.showImage(false);
		self.visibleImageUrl(null);
	};

	self.getTags();
	self.getProjects();
	self.getConfig();
};