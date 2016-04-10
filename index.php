<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
								<ul data-bind="foreach: projects">
									<li>
										<span data-bind="text: name"></span>
										<ol data-bind="foreach: tags">
											<li data-bind="text: name"></li>
										</ol>
										<img data-bind="attr:{src: featureMedia}" />
									</li>
								</ul>
							
						</main>

				</div>

			</div>


<?php get_footer(); ?>
