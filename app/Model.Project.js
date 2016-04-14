function Project(id, name, tags, featureMedia, media) {
	var self = this;
	self.id = id;
	// self.isVisible = ko.observable(true);
	self.name = name;
	self.tags = tags;
	self.featureMedia = featureMedia;
	self.featureMediaUrl = ko.observable();
	self.media = media;
	self.showImage = ko.observable(false);
};