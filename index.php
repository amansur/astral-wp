<?php get_header(); ?>

		<div id="content" class="container">
		<div class="row">
		<div class="col-sm-offset-1 col-sm-10">
			<div id="inner-content">

				<main id="main" class="m-all t-2of3 d-7of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
				<section id="home">
					<div id="intro"> 				<!-- BEGIN #intro -->
						<div class="row"> 
							<h1 class="col-sm-12" data-bind="html: introText"></h1>
						</div>
					</div> 							<!-- END #intro -->
					<div id="work"> 				<!-- BEGIN #work -->
						<div class="row">
							<h1 class="col-sm-12">Our Work</h1>
						</div>
						<div class="row">
							<ul class="col-sm-12 tags" data-bind="foreach: tags">
								<li class="tag">
									<input class="css-checkbox" type="checkbox" data-bind="checkedValue: $data, checked: $parent.selectedTags, attr: {id: 'tag' + id}" />
									<label class="css-label" data-bind="text: name, attr: {for: 'tag' + id}"></label>
								</li>
							</ul>
						</div>
						<ul class="row projects" data-bind="foreach: selectedProjects">
							<div class="col-sm-4" data-bind="foreach: $data">
								<li class="project">
									<a class="projectLink" data-bind="attr: {href: '#/project/' + slug}">
										<span class="projectName" data-bind="text: name, event: {mouseenter: $root.showFeaturedImage, mouseleave: $root.hideFeaturedImage}"></span>
									</a>
									<ol class="projectTags" data-bind="foreach: tags">
										<li class="projectTag"> 
											<span data-bind="text: name"></span>
										</li>
									</ol>
								</li>
							</div>
						</ul>
						<span class="projectImage" data-bind="visible: visibleImageUrl() != null"><img data-bind="attr: {src: visibleImageUrl()}" /></span>
					</div> 							<!-- END #work -->
					<div id="about"> 				<!-- BEGIN #about -->
						<div class="row">
							<h1 class="col-sm-12">About Us</h1>
						</div>
						<div class="row" data-bind="foreach: footer">
							<div class="col-sm-4" data-bind="foreach: $data">
								<h2 data-bind="text: heading"></h2>
								<span data-bind="html: content"></span>
							</div>
						</div>
					</div> 	
				</section>							<!-- END #about -->
				
				<section id="project">
					<div class="row" data-bind="with: project">
						<div class="col-sm-6">
							<span data-bind="text: $data.name"></span>
							<span data-bind="html: $data.description"></span>
						</div>
						<div class="col-sm-6">
							<ul class="media" data-bind="foreach: media">
								<!-- ko if: type == "video" -->
								<li class="mediaVideo">
									<span data-bind="html: content"></span>
								</li>
								<!-- /ko -->
								<!--ko if: type == "picture" -->
								<li class="mediaPicture">
									<img data-bind="attr: {src: content}" />
								</li>
								<!-- /ko -->
							</ul>
						</div>
					</div>
				</section>

				</main>
			</div> <!-- END #inner-content -->
		</div>
		</div>
		</div> <!-- END #content -->


<?php get_footer(); ?>
