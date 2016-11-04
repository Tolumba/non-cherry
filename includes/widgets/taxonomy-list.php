<?php
// =============================== Taxonomy List (Categories and Tags) ======================================
class Taxomomy_List extends WP_Widget {

	/** constructor */
	function __construct() {
		parent::__construct( false, $name = __( 'Taxonomy List', 'non-cherry' ) );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );

		$title         = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance );
		$taxonomy      = apply_filters( 'widget_taxonomy', $instance['taxonomy'] );
		$hide_empty    = apply_filters( 'widget_hide_empty', $instance['hide_empty'] );
		$sort_by       = apply_filters( 'widget_sort_by', $instance['sort_by'] );
		$number        = apply_filters( 'widget_number', $instance['number'] );

		$hide_empty = $hide_empty == 'true';

		echo $before_widget;

		if ( $title ){
			echo $before_title . $title . $after_title;
		}

		$terms = get_terms(
			array(
				'taxonomy' => $taxonomy,
				'hide_empty' => $hide_empty,
				'orderby' => $sort_by,
				'fields' => 'id=>name',
				'number' => $number,
			)
		);


		?>

		<ul class="term-list unstyled">

		<?php if( ! is_wp_error( $terms ) && count( $terms ) ){

			$format = '<li class="list-item term %3$s"><a href="%1$s">%2$s</a></li>';

			foreach ( $terms as $id => $name ) {

			 	$term_permalink = get_term_link( (int)$id, $taxonomy );

			 	if( is_wp_error( $term_permalink ) )
			 		continue;

			 	printf( $format, esc_attr( $term_permalink ), esc_html( $name ), esc_attr( $taxonomy ) );

			}

		} ?>

		</ul>

		<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {

		/* Set up some default widget settings. */

		$defaults = array( 'title' => '', 'post_type' => '', 'taxonomy' => '', 'sort_by' => 'name', 'hide_empty' => 'true', 'number' => '0' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title         = esc_attr( $instance['title'] );
		$taxonomy      = esc_attr( $instance['taxonomy'] );
		$hide_empty    = esc_attr( $instance['hide_empty'] );
		$sort_by       = esc_attr( $instance['sort_by'] );
		$number        = esc_attr( $instance['number'] );

		$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'non-cherry'  ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e( 'Taxonomy', 'non-cherry' ); ?>:
				<select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
					<option value="none" <?php self::selected( $taxonomy, 'none'); ?>><?php _e( 'None', 'non-cherry' ); ?></option>
				<?php foreach ( $taxonomies as $slug => $tax ): ?>
					<option value="<?php echo $slug ?>" <?php self::selected( $taxonomy, $slug ); ?>><?php echo $tax->labels->singular_name; ?></option>
				<?php endforeach; ?>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('hide_empty'); ?>"><?php _e( 'Hide empty', 'non-cherry' ); ?>:
				<select class="widefat" id="<?php echo $this->get_field_id('hide_empty'); ?>" name="<?php echo $this->get_field_name('hide_empty'); ?>">
					<option value="true" <?php self::selected( $hide_empty, 'true'); ?>><?php _e( 'Yes', 'non-cherry' ); ?></option>
					<option value="false" <?php self::selected( $hide_empty, 'false'); ?>><?php _e( 'No', 'non-cherry' ); ?></option>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('sort_by'); ?>"><?php _e( 'Sort terms by', 'non-cherry' ); ?>:<br />
				<select  class="widefat" id="<?php echo $this->get_field_id('sort_by'); ?>" name="<?php echo $this->get_field_name('sort_by'); ?>">
					<option value="name" <?php self::selected( $sort_by, 'name'); ?>><?php _e( 'Name', 'non-cherry' ); ?></option>
					<option value="slug" <?php self::selected( $sort_by, 'slug'); ?>><?php _e( 'Slug', 'non-cherry' ); ?></option>
					<option value="none" <?php self::selected( $sort_by, 'none'); ?>><?php _e( 'None', 'non-cherry' ); ?></option>
					<option value="term_id" <?php self::selected( $sort_by, 'term_id'); ?>><?php _e( 'Term ID', 'non-cherry' ); ?></option>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of terms to display', 'non-cherry'  ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" />
			</label>
		</p>
		<?php
	}

	static function selected( $val, $test, $return=false ){

		$result = ( $val === $test )? ' selected="selected"': '';

		if( $return ){
			return $result;
		}
		echo $result;
	}
} // class Widget
register_widget( 'Taxomomy_List' );
?>