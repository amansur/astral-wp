function Project(id, slug, name, description, tags, featureImageUrl, media) {
	var self = this;
	self.id = id;
	self.slug = slug,
	self.name = name;
	self.description = description;
	self.tags = tags;
	self.featureImage = featureImageUrl;
	self.media = media;
	self.featureImageIsVisible = ko.observable(false);

	self.showFeatureImage = function () {
		if (self.featureImage !== undefined && self.featureImage !== null && self.featureImage !== "") {
			self.featureImageIsVisible(window.innerWidth > 767); // true
			alert(window.innerWidth);
		}
	}

	self.hideFeatureImage = function () {
		self.featureImageIsVisible(false);
	}
};