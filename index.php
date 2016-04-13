<?php get_header(); ?>
<div id="nav">
	<ul class="menu">
		<li class="menuItem"><a href="#work">Work</a></li>
		<li class="menuItem"><a href="#about">About</a></li>
	</ul>
</div>


<div id="content">

	<div id="inner-content" class="wrap cf">
	<div id="inner-content" class="container">

		<main id="main" class="m-all t-2of3 d-7of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
				<section id="intro" class="row"> <!-- BEGIN #intro -->
					<h1 data-bind="html: introText"></h1>
				</section> <!-- END #intro -->
				<section id="work" class="row"> <!-- BEGIN #work -->
					<h1 class="col">Our Work</h1>
					<ul class="col tags" data-bind="foreach: tags">
						<li class="tag">
							<input class="css-checkbox" type="checkbox" data-bind="checkedValue: $data, checked: selectedTags, attr: {id: 'tag' + id}" />
							<label class="css-label" data-bind="text: name, attr: {for: 'tag' + id}"></label>
						</li>
					</ul>
					<ul class="col projects" data-bind="style: {height: columnHeight() / 2 + 'px'}, foreach: selectedProjects">
						<li class="project">
							<span class="projectName" data-bind="text: name, event: {mouseover: showFeaturedImage, mouseout: hideFeaturedImage}"></span>
							<ol class="projectTags" data-bind="foreach: tags">
								<li class="projectTag"> 
									<span data-bind="text: name"></span>
								</li>
							</ol>
							<span class="projectImage" data-bind="visible: showImage"><img data-bind="attr: {src: featureMedia}" /></span>
						</li>
					</ul>
				</section> <!-- END #work -->
				<section id="about"> <!-- BEGIN #about -->
					<div class="row">
						<h1 class="col-sm-12">About Us</h1>
					</div>
					<div class="row" data-bind="foreach: footer">
						<div class="col-sm-4" data-bind="foreach: $data">
								<h2 data-bind="text: heading"></h2>
								<span data-bind="html: content"></span>
						</div>
					</div>
				</section> <!-- END #about -->
			<!-- </div> -->
		</main> <!-- END #main -->

		<main id="project" class="m-all t-2of3 d-7of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<!-- <div data-bind="page: {id: 'start', title: 'Astral Studio'}"> -->
				<section id="intro"> <!-- BEGIN #intro -->
					<h1 data-bind="html: introText"></h1>
				</section> <!-- END #intro -->
			<!-- </div> -->

			<!-- <div data-bind="page: {id: 'project', params: ['id'], title: 'Astral Studio'}">

			</div> -->
		</main> <!-- END #main -->

	</div> <!-- END #inner-content -->

</div> <!-- END #content -->


<?php get_footer(); ?>
