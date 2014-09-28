			<footer role="contentinfo">
			
				<div id="inner-footer" class="clearfix">
		          <hr />
		          <h3>Proudly Supported By</h3>
					<?php 
						$supporters = array(
							array(
								'img' => 'logo-altasport.png',
								'alt' => 'Alberta Sport, Recreation Parks and Wildlife Foundation Logo',
								'url' => 'http://www.albertasport.ca/'), 
							array(
								'img' => 'logo-arc.png',
								'alt' => 'Arc\'Terx Logo',
								'url' => 'http://arcteryx.com/'), 
							array(
								'img' => 'logo-awa.png',
								'alt' => 'Alberta WhiteWater Association Logo',
								'url' => 'http://www.albertawhitewater.ca/'), 
							array(
								'img' => 'logo-canoe.png',
								'alt' => 'Canoe Kayak Canada Logo',
								'url' => 'http://www.canoekayak.ca/'), 
							array(
								'img' => 'logo-eden.png',
								'alt' => 'Eden Logo',
								'url' => 'http://edencoldlaser.com/'), 
							array(
								'img' => 'logo-energy.png',
								'alt' => 'Energy Bits Logo',
								'url' => 'https://www.energybits.com/'), 
							array(
								'img' => 'logo-esteem.png',
								'alt' => 'Esteem Team Logo',
								'url' => 'http://www.motivatecanada.ca/'),
							array(
								'img' => 'logo-federal.png',
								'alt' => 'Federal Metals Logo',
								'url' => 'http://www.federalmetals.ca/'),
							array(
								'img' => 'logo-incite.png',
								'alt' => 'Incite Social Promotions Logo',
								'url' => 'http://www.incitepromo.com/'),
							array(
								'img' => 'logo-kris.png',
								'alt' => 'Kris Neilson Design Logo',
								'url' => 'http://www.krisdesign.ca/'),
							array(
								'img' => 'logo-purenorth.png',
								'alt' => 'Pure North S\'Energy Foundation Logo',
								'url' => 'http://www.purenorth.ca/'),
							array(
								'img' => 'logo-slalom.png',
								'alt' => 'Alberta Slalom Canoe Kayak Logo',
								'url' => 'http://www.albertawhitewater.ca/'),
							);

						for($i=0; $i<sizeof($supporters); $i++){
							if($i%6 == 0)
								echo '<div class="row">';
							echo sprintf('<div class="col-xs-4 col-md-2">
							          		<a href="%s" target="_blank">
							          			<img class="img-responsive" src="%s/images/supporters/%s" alt="%s" />
							          		</a>
						          		</div>', 
						          		$supporters[$i]['url'], 
						          		get_template_directory_uri(),
						          		$supporters[$i]['img'],
						          		$supporters[$i]['alt'] );
							if($i%6 == 5)
								echo '</div>';
						}

					?>


		          <div id="widget-footer" class="clearfix row">
		            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer1') ) : ?>
		            <?php endif; ?>
		            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer2') ) : ?>
		            <?php endif; ?>
		            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer3') ) : ?>
		            <?php endif; ?>
		          </div>
					
					<nav class="clearfix">
						<?php wp_bootstrap_footer_links(); // Adjust using Menus in Wordpress Admin ?>
					</nav>
					
				
				</div> <!-- end #inner-footer -->
				
			</footer> <!-- end footer -->
		
		</div> <!-- end #container -->
				
		<!--[if lt IE 7 ]>
  			<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
  			<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
		
		<?php wp_footer(); // js scripts are inserted using this function ?>

	</body>

</html>