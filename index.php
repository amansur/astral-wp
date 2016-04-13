<?php get_header(); ?>
<div id="nav">
	<ul class="menu">
		<a href="#work"><li>Work</li></a>
		<a href="#about"><li>About</li></a>
	</ul>
</div>


<div id="content">

	<!-- <div id="inner-content" class="wrap cf"> -->
	<div id="inner-content" class="container">

		<main id="main" class="m-all t-2of3 d-7of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<section id="intro"> 				<!-- BEGIN #intro -->
				<div class="row"> 
					<h1 class="col-sm-12" data-bind="html: introText"></h1>
				</div>
			</section> 							<!-- END #intro -->
			<section id="work"> 				<!-- BEGIN #work -->
				<div class="row">
					<h1 class="col-sm-12">Our Work</h1>
				</div>
				<div class="row">
					<ul class="col-sm-12 tags" data-bind="foreach: tags">
						<li class="tag">
							<input class="css-checkbox" type="checkbox" data-bind="checkedValue: $data, checked: selectedTags, attr: {id: 'tag' + id}" />
							<label class="css-label" data-bind="text: name, attr: {for: 'tag' + id}"></label>
						</li>
					</ul>
				</div>
				<ul class="row projects" data-bind="foreach: selectedProjects">
					<div class="col-sm-4" data-bind="foreach: $data">
						<li class="project">
							<span class="projectName" data-bind="text: name, event: {mouseenter: showFeaturedImage, mouseleave: hideFeaturedImage}"></span>
							<ol class="projectTags" data-bind="foreach: tags">
								<li class="projectTag"> 
									<span data-bind="text: name"></span>
								</li>
							</ol>
						</li>
					</div>
				</ul>
				<span class="projectImage" data-bind="visible: visibleImageUrl() != null"><img data-bind="attr: {src: visibleImageUrl()}" /></span>
			</section> 							<!-- END #work -->
			<section id="about"> 				<!-- BEGIN #about -->
				<div class="row">
					<h1 class="col-sm-12">About Us</h1>
				</div>
				<div class="row" data-bind="foreach: footer">
					<div class="col-sm-4" data-bind="foreach: $data">
							<h2 data-bind="text: heading"></h2>
							<span data-bind="html: content"></span>
					</div>
				</div>
			</section> 							<!-- END #about -->
		</main> 								<!-- END #main -->

	</div> <!-- END #inner-content -->

</div> <!-- END #content -->


<?php get_footer(); ?>
