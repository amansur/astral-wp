<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap cf">

		<main id="main" class="m-all t-2of3 d-7of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<!-- <div data-bind="page: {id: 'start', title: 'Astral Studio'}"> -->
				<section id="intro"> <!-- BEGIN #intro -->
					<!-- <div data-bind="html: text"></div> -->
				</section> <!-- END #intro -->
				<section id="work"> <!-- BEGIN #work -->
					<ul class="tags" data-bind="foreach: tags">
						<li class="tag">
							<input type="checkbox" data-bind="checkedValue: $data, checked: selectedTags, attr: {id: 'tag' + id}" />
							<label data-bind="text: name, attr: {for: 'tag' + id}"></label>
						</li>
					</ul>
					<ul class="projects" data-bind="style: {height: columnHeight() / 2 + 'px'}, foreach: selectedProjects">
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
					<!-- <div data-bind="html: text"></div> -->
				</section> <!-- END #about -->
			<!-- </div>

			<div data-bind="page: {id: 'project', params: ['id'], title: 'Astral Studio'}">

			</div> -->
		</main> <!-- END #main -->

	</div> <!-- END #inner-content -->

</div> <!-- END #content -->


<?php get_footer(); ?>
