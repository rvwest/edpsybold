<?php
$post_type = get_post_type();
$post_type_label = edpsybold_get_search_post_type_label($post_type);
$article_classes = 'search-result search-result--' . sanitize_html_class($post_type);

$thumbnail_available = ('post' === $post_type && has_post_thumbnail());
?>

<article <?php post_class($article_classes); ?> id="post-<?php the_ID(); ?>">
    <div class="search-result__type"><?php echo esc_html($post_type_label); ?></div>


    <?php if ('post' === $post_type): ?>

        <div class="search-result__body">
            <div class="search-result__text">
                <h2 class="search-result__title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <div class="search-result__excerpt">
                    <?php the_excerpt(); ?>
                </div>
            </div>
            <?php if ($thumbnail_available): ?>
                <div class="search-result__thumbnail">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif ('tribe_events' === $post_type): ?>

        <div class="search-result__body">
            <div class="search-result__text">
                <h2 class="search-result__title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <?php if (function_exists('tribe_get_start_date')): ?>
                    <p class="search-result__meta">
                        <?php echo esc_html(tribe_get_start_date(get_the_ID(), false, get_option('date_format'))); ?>
                    </p>
                <?php endif; ?>

                <div class="search-result__excerpt">
                    <?php the_excerpt(); ?>
                </div>
            </div>
        </div>
    <?php elseif ('thesis' === $post_type || 'wpbdp_listing' === $post_type): ?>

        <div class="search-result__body">
            <div class="search-result__text">
                <h2 class="search-result__title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <div class="search-result__excerpt">
                    <?php the_excerpt(); ?>
                </div>
            </div>
        </div>
    <?php else: ?>

        <div class="search-result__body">
            <div class="search-result__text">
                <h2 class="search-result__title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <div class="search-result__excerpt">
                    <?php the_excerpt(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</article>