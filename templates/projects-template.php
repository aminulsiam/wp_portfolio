<?php
get_header(); // Include the header template

$args = array(
	'post_type'      => 'projects', // Change 'post' to your custom post type if applicable
	'post_status'    => 'publish',
	'posts_per_page' => - 1, // Display all posts
);

$posts_query = new WP_Query( $args );

if ( $posts_query->have_posts() ) :
	while ( $posts_query->have_posts() ) :
		$posts_query->the_post();

		// Display the post title and content here as desired
		the_title( '<h2>', '</h2>' );
		the_content();

	endwhile;
	wp_reset_postdata();
else :
	echo '<p>No posts found.</p>';
endif;

get_footer(); // Include the footer template
?>
