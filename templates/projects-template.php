<div class="container">
    <!--Section: Content-->
    <section class="text-center">
        <div class="row">

			<?php
			$args = array(
				'post_type'      => 'projects',
				'post_status'    => 'publish',
				'posts_per_page' => - 1,
			);

			$projects = new WP_Query( $args );

			if ( $projects->have_posts() ) {
				while ( $projects->have_posts() ) {
					$projects->the_post();

					// Get post meta values
					$pf_ex_url      = get_post_meta( get_the_ID(), 'pf_ex_url', true );
					$pf_title       = get_post_meta( get_the_ID(), 'pf_title', true );
					$pf_description = get_post_meta( get_the_ID(), 'pf_description', true );

					?>
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div class="card">
                            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                <img src="https://mdbootstrap.com/img/new/standard/nature/184.jpg"
                                     class="img-fluid"/>
                                <a href="#!">
                                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php the_title(); ?></h5>
                                <p class="card-text">
									<?php echo substr( $pf_description, 0, 135 ) . "..."; ?>
                                </p>
                                <a href="" class="btn btn-primary" data-toggle="modal"
                                   data-target="#myModal-<?php echo get_the_ID(); ?>">Read More</a>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="myModal-<?php echo get_the_ID(); ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h3 id="myModalLabel">
										<?php the_title(); ?>
                                    </h3>
                                </div>

                                <div class="modal-body">
                                    <p>
										<?php echo $pf_description; ?>
                                    </p>
									<?php the_post_thumbnail(); ?>
                                </div>

                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
					<?php
				}
			}
			wp_reset_postdata();
			?>
        </div>
    </section>
</div>
