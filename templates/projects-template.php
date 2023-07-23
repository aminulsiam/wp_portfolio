<div class="col-lg-4 col-md-12 mb-4"></div>
<div class="col-lg-4 col-md-12 mb-4"></div>
<div class="col-lg-4 col-md-12 mb-4">
    <ul class="list-group">
		<?php
		$get_all_terms = get_terms( 'project_category' );

		foreach ( $get_all_terms as $terms => $term ) {
			?>
            <a href="?category=<?php echo $term->name; ?>"
               class="list-group-item"><?php echo $term->name; ?></a>
			<?php
		}
		?>
    </ul>
</div>

<?php
if ( isset( $_GET['category'] ) ) {

	$category = $_GET['category'];

	$args     = array(
		'post_type' => 'projects',
		'tax_query' => array(
			array(
				'taxonomy' => 'project_category',
				'field'    => 'slug',
				'terms'    => $category,
			),
		),
	);
	$projects = new WP_Query( $args );

	?>
    <div class="container">
        <div class="row">
			<?php
			if ( $projects->have_posts() ) {
				while ( $projects->have_posts() ) {
					$projects->the_post();

					// Get post meta values
					$pf_ex_url      = get_post_meta( get_the_ID(), 'pf_ex_url', true );
					$pf_title       = get_post_meta( get_the_ID(), 'pf_title', true );
					$pf_description = get_post_meta( get_the_ID(), 'pf_description', true );

					$terms = get_the_terms( get_the_ID(), 'project_category' );

					?>
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div class="card">
                            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
								<?php the_post_thumbnail(); ?>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">
									<?php the_title(); ?>
                                </h4>
                                <hr>
								<?php
								foreach ( $terms as $term ) {
									echo '<span style="font-weight:bold">Category : ' . $term->name . '</span></br>';
								}
								?>
                                <p class="card-text" style="margin-top:20px">
									<?php echo substr( $pf_description, 0, 135 ) . "..."; ?>
                                </p>
                                <a href="" class="btn btn-primary" data-toggle="modal"
                                   data-target="#myModal-<?php echo get_the_ID(); ?>">
									<?php esc_html_e( 'View Details' ); ?>
                                </a>
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
									<?php
									if ( $terms && ! is_wp_error( $terms ) ) {
										foreach ( $terms as $term ) {
											echo '<span style="font-weight:bold">Category : ' . $term->name . '</span></br>URL - ' . $pf_ex_url;
										}
									}
									?>
                                    <p style="margin-top:20px">
										<?php echo $pf_description; ?>
                                    </p>
									<?php the_post_thumbnail( array( 800, 200 ) ); ?>
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
    </div>
	<?php
} else {
	?>
    <div class="container">
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

						$terms = get_the_terms( get_the_ID(), 'project_category' );

						?>
                        <div class="col-lg-4 col-md-12 mb-4">
                            <div class="card">
                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
									<?php the_post_thumbnail(); ?>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">
										<?php the_title(); ?>
                                    </h4>
                                    <hr>
									<?php
									foreach ( $terms as $term ) {
										echo '<span style="font-weight:bold">Category : ' . $term->name . '</span></br>';
									}
									?>
                                    <p class="card-text" style="margin-top:20px">
										<?php echo substr( $pf_description, 0, 135 ) . "..."; ?>
                                    </p>
                                    <a href="" class="btn btn-primary" data-toggle="modal"
                                       data-target="#myModal-<?php echo get_the_ID(); ?>">
										<?php esc_html_e( 'View Details' ); ?>
                                    </a>
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
										<?php
										if ( $terms && ! is_wp_error( $terms ) ) {
											foreach ( $terms as $term ) {
												echo '<span style="font-weight:bold">Category : ' . $term->name . '</span></br>URL - ' . $pf_ex_url;
											}
										}
										?>
                                        <p style="margin-top:20px">
											<?php echo $pf_description; ?>
                                        </p>
										<?php the_post_thumbnail( array( 200, 100 ) ); ?>
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
	<?php
}
?>




