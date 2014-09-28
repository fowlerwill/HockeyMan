				<div id="homepage" class="col-sm-12" role="complementary">
				
					<?php if ( is_active_sidebar( 'homepage' ) ) : ?>

						<?php dynamic_sidebar( 'homepage' ); ?>

					<?php else : ?>

						<!-- This content shows up if there are no widgets defined in the backend. -->
						
						<div class="alert alert-message">
						
							<p><?php _e("Homepage widget missing","wpbootstrap"); ?>.</p>
						
						</div>

					<?php endif; ?>

				</div>