function Project(id, name, tags, featureMedia, media, displayHeight) {
	var self = this;
	self.id = id;
	self.name = name;
	self.tags = tags;
	self.featureMedia = featureMedia;
	self.featureMediaUrl = ko.observable();
	self.media = media;
	self.showImage = ko.observable(false);
	self.displayHeight = displayHeight;
};