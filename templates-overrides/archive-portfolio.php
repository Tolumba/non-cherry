<?php
/**
 *
 * The template for displaying CPT Portfolio.
 *
 * @package Cherry_Portfolio
 * @since   1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		$data = new Cherry_Portfolio_Data;
		$data->the_portfolio();
	?>

</article>