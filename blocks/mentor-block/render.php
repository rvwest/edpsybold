<?php
function edp_render_mentor_block( $attributes, $content, $block ) {
    $name        = isset( $attributes['name'] ) ? $attributes['name'] : '';
    $role        = isset( $attributes['role'] ) ? $attributes['role'] : '';
    $description = isset( $attributes['description'] ) ? $attributes['description'] : '';
    $link        = isset( $attributes['link'] ) ? $attributes['link'] : '';
    $image_id    = isset( $attributes['imageID'] ) ? intval( $attributes['imageID'] ) : 0;

    $image_html = '';
    if ( $image_id ) {
        $image_html = wp_get_attachment_image(
            $image_id,
            'thumbnail',
            false,
            array(
                'class'         => 'page-mentor-image',
                'alt'           => esc_attr( $name ),
                'fetchpriority' => 'high',
            )
        );
    }

    $wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'mentor-block' ) );

    ob_start();
    ?>
    <div <?php echo $wrapper_attributes; ?>>
        <?php if ( $link ) : ?>
        <a class="mentor-link" href="<?php echo esc_url( $link ); ?>">
        <?php endif; ?>
            <figure class="wp-block-image size-thumbnail is-resized is-style-rounded">
                <?php echo $image_html; ?>
            </figure>
            <div class="mentor-name-role-description">
                <?php if ( $name ) : ?>
                <div class="mentor-name"><?php echo esc_html( $name ); ?></div>
                <?php endif; ?>
                <?php if ( $role ) : ?>
                <div class="mentor-role"><?php echo esc_html( $role ); ?></div>
                <?php endif; ?>
                <?php if ( $description ) : ?>
                <div class="mentor-description"><?php echo wp_kses_post( $description ); ?></div>
                <?php endif; ?>
            </div>
        <?php if ( $link ) : ?>
        </a>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
