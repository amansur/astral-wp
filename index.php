<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap cf">

		<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<section id="intro"> <!-- BEGIN #intro -->

			</section> <!-- END #intro -->
			<section id="work"> <!-- BEGIN #work -->
				<ul class="tags" data-bind="foreach: tags">
					<li>
						<input type="checkbox" data-bind="checkedValue: $data, checked: selectedTags">
						<span data-bind="text: name">
					</li>
				</ul>
				<ul class="projects" data-bind="foreach: selectedProjects">
					<li>
						<span data-bind="text: name"></span>
						<ol data-bind="foreach: tags">
							<li> 
								<span data-bind="text: name">
							</li>
						</ol>
						<span data-bind="visible: false"><img data-bind="attr:{src: featureMedia}" /></span>
					</li>
				</ul>
			</section> <!-- END #work -->
			<section id="about"> <!-- BEGIN #about -->
				
			</section> <!-- END #about -->
		</main> <!-- END #main -->

	</div> <!-- END #inner-content -->

</div> <!-- END #content -->


<?php get_footer(); ?>
