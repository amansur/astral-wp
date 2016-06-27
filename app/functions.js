// ============================
// Utility functions
// ============================

function GetSplitChunkSize(arraySize, n) {
	if (n === 1) {
		return arraySize;
	} else {
		var first = Math.ceil(arraySize / n);
		var remainder = arraySize - first;
		return [first].concat(GetSplitChunkSize(remainder, n - 1));
	}
};

function SplitArrayIntoN(array, n) {
	var split = [];
	var chunkSizes = GetSplitChunkSize(array.length, n);
	var start = 0;
	var end = 0;
	for (var i = 0; i < n; i++) {
		start += i === 0 ? 0 : chunkSizes[i - 1];
		end += chunkSizes[i];
		split.push(array.slice(start, end));
	}

	return split;
};

function GetRandomInt(min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
};

// ============================
// Scroll controls
// ============================

function DisplayScrollToTop() {
	var scrollTop = $(window).scrollTop();
	if (scrollTop > 200) {
		$topAnchor.fadeIn();
	} else {
		$topAnchor.hide();
	}
};

function ScrollToTop() {
	$('html, body').animate({ scrollTop: 0 }, 500);
	return false;
};

function ScrollToAnchor(anchor) {
	var target = $('#' + anchor);
	var offset = -3;
	if ($menu.css("position") === "fixed") {
		offset += $menu.height();
	}
	if ($astralBanner.css("position") === "fixed") {
		offset += $astralBanner.height();
	}
	if ($wpAdminBar !== null) {
		offset += $wpAdminBar.height();
	}

	$('html, body').animate({ scrollTop: $(target).offset().top - offset }, 500);
	return false;
};

// ============================
// Background controls
// ============================

function UpdateBackground() {
	var currentController = window.location.hash.split('/')[1];
	var previousController = previousRoute.split('/')[1];
	if (currentController !== "home" || previousController !== "home") {
		var random = GetRandomInt(0, $backgroundImages.length - 1);
		var src = $backgroundImages[random].src;
		$body.css("background-image", "url('" + src + "')");
	}
};

// ============================
// Tag list checkboxes controls
// ============================

function ClearTagCheckboxes() {
	$tags.find('.tagLabel').removeClass('selected');
	$tags.find('.tagLabel').removeClass('tagChecked');
};

// ============================
// Route actions
// ============================

function RecordPreviousRoute(route) {
	previousRoute = window.location.hash;
};

function RouteProject(slug) {
	UpdateBackground();
	appVM.projectVM.slug(slug);
	RecordPreviousRoute();

	$menu.find('.menuItem:first-child').css({ "background-color": "white", "color": "black" });
	$projectNode.style.display = 'block';
	$homeNode.style.display = 'none';
};

function RouteHome(anchor) {
	UpdateBackground();
	appVM.projectVM.slug(null);
	RecordPreviousRoute();

	$menu.find('.menuItem:first-child').css({ "background-color": "black", "color": "white" });
	$projectNode.style.display = 'none';
	$homeNode.style.display = 'block';

	if (anchor !== null && anchor !== '' && anchor !== undefined) {
		ScrollToAnchor(anchor);
	}
};