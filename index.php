<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap cf">

		<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<section id="intro"> <!-- BEGIN #intro -->

			</section> <!-- END #intro -->
			<section id="work"> <!-- BEGIN #work -->
				<ul class="tags" data-bind="foreach: tags">
					<li class="tag">
						<input type="checkbox" data-bind="checkedValue: $data, checked: selectedTags, attr: {id: 'tag' + id}">
						<label data-bind="text: name, attr: {for: 'tag' + id}"></label>
					</li>
				</ul>
				<ul class="projects" data-bind="foreach: selectedProjects">
					<li class="project" data-bind="event: {mouseover: showFeaturedImage, mouseout: hideFeaturedImage}">
						<span data-bind="text: name"></span>
						<ol class="projectTags" data-bind="foreach: tags">
							<li class="projectTag"> 
								<span data-bind="text: name">
							</li>
						</ol>
						<span data-bind="visible: showImage"><img data-bind="attr: {src: featureMedia}" /></span>
					</li>
				</ul>
			</section> <!-- END #work -->
			<section id="about"> <!-- BEGIN #about -->
				
			</section> <!-- END #about -->
		</main> <!-- END #main -->

	</div> <!-- END #inner-content -->

</div> <!-- END #content -->


<?php get_footer(); ?>
