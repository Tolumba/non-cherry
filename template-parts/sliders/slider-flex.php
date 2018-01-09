<?php
/**
*
*   Template part: Slider
*
*/
 ?>
 <?php
    $tax_query = array();
    $taxonomy = of_get_option('sl_posts_taxonomy', false);
    $term = of_get_option('sl_posts_term', false);
    $rule = array();
    if( $taxonomy && $term ){
        $rule['taxonomy'] = $taxonomy;
        $rule['field'] = 'slug';
        $rule['terms'] = explode( ', ', $term );
        $tax_query['relation'] = 'AND';
        $tax_query[] = $rule;
    }
    $args = array(
        'post_type' => of_get_option('sl_posts', 'post'),
        'posts_per_page' => (int)of_get_option('sl_posts_number', '-1'),
        'post_status' => 'publish',
        'tax_query' =>  $tax_query,
    );
    query_posts( $args );
?>
<?php if( have_posts()&&( of_get_option('home_slider', false) ) ): ?>
    <?php $suffux =  uniqid(); ?>
    <?php $slider_id = 'flexslider-'.$suffux; ?>
    <script>
        jQuery(window).load(function () {
            jQuery('#<?php echo $slider_id; ?>').flexslider({
                animation: '<?php echo of_get_option('sl_effect', 'random'); ?>',
                slideshow: <?php echo ( of_get_option('sl_slideshow', true) ? : false ); ?>,
                slideshowSpeed: <?php echo of_get_option('sl_pausetime', 7000); ?>,
                animationDuration: <?php echo of_get_option('sl_animation_speed', 1500); ?>,
                prevText: "",
                nextText: "",
                directionNav: <?php echo of_get_option('sl_dir_nav', false); ?>,
                controlNav:  <?php echo of_get_option('sl_control_nav', false); ?>,
                sync: "#slides-pagination-<?php echo $suffux; ?>"
            });
        });
    </script>
    <div id="<?php echo $slider_id; ?>" class="<?php slider_wrapper_classes(); ?>">
        <ul class="slides clearfix">
    		<?php while ( have_posts() ): ?>
                <?php the_post();?>
                <?php $url = get_post_meta($post->ID, "my_slider_url", true); ?>
        		<?php $caption = html_entity_decode( apply_filters( 'the_content', get_the_content() ) ); ?>
                <?php $sl_image_obj = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); ?>
        		<?php $sl_image_url = is_array($sl_image_obj)? $sl_image_obj[0]: CHILD_URL.'/images/blank.gif'; ?>
            <li>
                <img src="<?php echo $sl_image_url; ?>"/>
                <div class="flex-caption">
                    <?php echo $caption; ?>
                </div>
            </li>
    		<?php endwhile; ?>
        </ul>
    </div>
<?php else: ?>
    <div class="no-slides"></div>
<?php endif; ?>
<?php wp_reset_query(); ?>
