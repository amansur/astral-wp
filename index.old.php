<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog" ng-app="listProject">
								<div ng-repeat="project in projects">
									{{project.title}}
								</div>
								{{5+7}}
							
						</main>

				</div>

			</div>


<?php get_footer(); ?>