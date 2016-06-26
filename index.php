<?php get_header(); ?>


<?php
$frontPageContent = get_fields(174);
?>
		<script type="text/html" id="tags-template">
			<li class="projectTag">
				<span data-bind="text: name"></span>
			</li>
		</script>

		<div id="backgroundImages" style="display: none">
			<img src="/wp-content/themes/astral-wp/library/images/background/1.jpg" />
			<img src="/wp-content/themes/astral-wp/library/images/background/2.jpg" />
			<img src="/wp-content/themes/astral-wp/library/images/background/3.jpg" />
			<img src="/wp-content/themes/astral-wp/library/images/background/4.jpg" />
			<img src="/wp-content/themes/astral-wp/library/images/background/5.jpg" />
			<img src="/wp-content/themes/astral-wp/library/images/background/6.jpg" />
			<img src="/wp-content/themes/astral-wp/library/images/background/7.jpg" />
			<img src="/wp-content/themes/astral-wp/library/images/background/8.jpg" />
		</div>
		<div id="content" class="container">
			<div class="row">
				<div class="col-sm-offset-1 col-sm-10">
				<div id="inner-content">

					<main id="main" class="m-all t-2of3 d-7of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
					<section id="home">
						<div id="intro"> 				<!-- BEGIN #intro -->
							<div class="row"> 
								<h1 class="col-sm-12"><?php echo $frontPageContent["heading"]?></h1>
							</div>
						</div> 							<!-- END #intro -->
						<div id="work"> 				<!-- BEGIN #work -->
							<div class="row">
								<h1 class="col-sm-9">Our Work</h1>
								<span class="col-sm-3" id="filterLabel">filter work by type</span>
							</div>
							<div class="row" id="filterList" data-bind="with: tagListVM">
								<ul class="col-sm-12 tags" data-bind="foreach: tags">
									<li class="tag">
										<input class="css-checkbox" type="checkbox" data-bind="checkedValue: $data, checked: $parent.selectedTags, attr: {id: 'tag' + id}" />
										<label class="css-label" data-bind="text: name, attr: {for: 'tag' + id}"></label>
									</li>
								</ul>
								<span class="col-sm-12" id="filterApply" data-bind="click: applyFilter">apply</span>
							</div>
							<!--<div class="row" id="selectedTagList">
								<div class="col-sm-12">
									Showing:
									<ul data-bind="foreach: selectedTags">
										<li data-bind="text: name"></li>
									</ul>
								</div>
							</div>-->
							<div id="selectedTagList" class="row" data-bind="with: projectListVM">
								<div class="col-sm-12">
									<span data-bind="text: selectedTagsSummary"></span>
									<span data-bind="visible: selectedTagsSummary() !== ''">
										<a id="filterClear" data-bind="click: clearFilter">clear</a>
									</span>
								</div>
								<ul class="projects" data-bind="foreach: selectedProjects">
									<div class="col-sm-4" data-bind="foreach: $data">
										<li class="project">
											<a class="projectLink" data-bind="attr: {href: '#/project/' + slug}">
												<span class="projectName" data-bind="text: name, event: {mouseenter: showFeatureImage, mouseleave: hideFeatureImage}"></span>
											</a>
											<ol class="projectTags" data-bind="template: {name: 'tags-template', foreach: tags }"></ol>
											<div class="projectImage" data-bind="visible: featureImageIsVisible">
												<img data-bind="attr: {src: featureImage}" />
											</div>
										</li>
									</div>
								</ul>
							</div>
							<span class="projectImage" data-bind="visible: visibleImageURL() != null"><img data-bind="attr: {src: visibleImageURL}" /></span>
						</div> 							<!-- END #work -->
						<div id="about"> 				<!-- BEGIN #about -->
							<div class="row">
								<h1 class="col-sm-12">About Us</h1>
							</div>
							<div class="row">
								<?php
								foreach($frontPageContent["footer"] as $column)	{
								?>
								<div class="col-sm-4">
									<?php
									foreach($column["column"] as $article) {
									?>
									<h2><?php echo $article["heading"];?></h2>
									<span><?php echo $article["content"];?></span>
									<?php
									}
									?>
								</div>
								<?php	
								}
								?>
							
							</div>
						</div> 	
					</section>							<!-- END #about -->
				
					<section id="project" data-bind="with: projectVM">
						<!-- ko if: prev !== null || next !== null -->
						<div class="row">
							<div class="col-sm-12 projectNav">
								<!-- ko if: prev !== null -->
								<a data-bind="attr: {href: '#/project/' + prev()}">&lt; prev</a>
								<!-- /ko -->
								<!-- ko if: next !== null -->
								<a data-bind="attr: {href: '/#/project/' + next()}">next &gt;</a>
								<!-- /ko -->
							</div>
						</div>
						<!-- /ko -->
						<!-- ko with: project -->
						<div class="row">
							<div class="col-sm-12 project">
								<h1 class="projectName" data-bind="text: name"></h1>
								<div class="projectInvolvement">
									<!-- ko if: $data.tags !== undefined -->
									Involvement ➔
									<!-- /ko -->
									<ol class="projectTags" data-bind="template: {name: 'tags-template', foreach: tags }"></ol>
								</div>
								<div class="projectDescription" data-bind="html: description"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<ul class="media" data-bind="foreach: media">
									<!-- ko if: type == "video" -->
									<li class="mediaVideo">
										<div class="embed-responsive embed-responsive-16by9">
											<iframe class="embed-responsive-item" data-bind="attr: {src: content}"></iframe>
										</div>
										<span data-bind="html: description"></span>
									</li>
									<!-- /ko -->
									<!--ko if: type == "picture" -->
									<li class="mediaPicture" data-bind="css: { halfWidthPicture: halfWidth }">
										<img data-bind="attr: {src: content}" />
										<span data-bind="html: description"></span>
									</li>
									<!-- /ko -->
								</ul>
							</div>
						</div>
						<!-- /ko -->
					</section>

					</main>
				</div> <!-- END #inner-content -->
			</div>
			</div>
		</div> <!-- END #content -->


<?php get_footer(); ?>
