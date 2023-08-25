<?php
get_header();

while (have_posts()) {

    the_post(); ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p>Replace me later</p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <!-- get_post_type_archive_link() will return the URL for the post type archive, useful in case we change the slug -->
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs </a> <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_content(); ?>
        </div>
        <?php
        $relatedProfessors = new WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => 'related_programs',
                    'compare' => 'LIKE', // LIKE is the same as CONTAINS
                    'value' => '"' . get_the_ID() . '"' // we need to wrap these in quotes because of the way that WP serializes the data when saving it
                ],
            ]
        ]);

        // only displays upcoming events if applicable
        if ($relatedProfessors->have_posts()) {
        ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Department of <?php echo get_the_title(); ?> Faculty</h2>
            </br>
            <?php
            while ($relatedProfessors->have_posts()) {
                $relatedProfessors->the_post();
                $eventDate = new DateTime(get_field('event_date'));
            ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php }
        }

        wp_reset_postdata(); /* this resets the ID data because we are using a custom query, we change the ID. So we need to reset the data to reobtain the original page ID which we use in the next custom query */

        $today = date('Ymd');
        $homepageEvents = new WP_Query([
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => [
                ['key' => 'event_date', 'compare' => '>=', 'value' => $today, 'type' => 'numeric'],
                [
                    'key' => 'related_programs',
                    'compare' => 'LIKE', // LIKE is the same as CONTAINS
                    'value' => '"' . get_the_ID() . '"' // we need to wrap these in quotes because of the way that WP serializes the data when saving it
                ],
            ]
        ]);

        // only displays upcoming events if applicable
        if ($homepageEvents->have_posts()) {
            ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Upcoming <?php echo get_the_title(); ?> Events</h2>
            </br>
            <?php
            while ($homepageEvents->have_posts()) {
                $homepageEvents->the_post();
                $eventDate = new DateTime(get_field('event_date'));
            ?>
                <div class="event-summary">
                    <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                        <span class="event-summary__month"><?php echo $eventDate->format('M'); ?></span>
                        <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
                    </a>
                    <div class="event-summary__content">
                        <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                        <p><?php if (has_excerpt()) {
                                echo get_the_excerpt;
                            } else {
                                echo wp_trim_words(get_the_content(), 18);
                            }; ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                    </div>
                </div>
        <?php }
        }
        ?>
    </div>
<?php }
get_footer();
?>