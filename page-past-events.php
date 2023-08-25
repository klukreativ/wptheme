<!-- this page is created specifically for the page with the slug 'past-events' hence the filename -->

<?php
get_header();
?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">Past Events</h1>
        <div class="page-banner__intro">
            <p>A recape of our past events</p>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">
    <?php
    $today = date('Ymd');
    // obtains all events with a value of less than the current date
    $pastEvents = new WP_Query(array(
        'paged' => get_query_var('paged', 1), // this informs WP what the current page it's on (for purposes of pagination), this function gets URL information and defaults to 1 if none is specified (as page 1 may not list the page)
        'post_type' => 'event',
        'orderby' => 'meta_value', // sorting behavious (def = post_date. title, rand, or meta_value (custom field))
        'meta_key' => 'event_date', // the custom field
        'orderby' => 'meta_value_num',
        'order' => 'ASC', // direction of order, DESC, ASC
        'meta_query' => [ // conditionals to display, each conditional is its own arr
            ['key' => 'event_date', 'compare' => '<', 'value' => $today, 'type' => 'numeric'] // var to compare, limit, value, optional what type of value is being compared
        ]
    ));

    while ($pastEvents->have_posts()) {
        $pastEvents->the_post(); // gets data ready
        $eventDate = new DateTime(get_field('event_date'));
    ?>
        <div class="event-summary">
            <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                <span class="event-summary__month"><?php echo $eventDate->format('M'); ?></span>
                <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
            </a>
            <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p><?php echo wp_trim_words(get_the_content(), 18); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
        </div>
    <?php }
    // pagination only works out of the box with the default query, because we're using a custom query we need to add several options to allow us to create pagination for the custom query
    echo paginate_links([
        'total' => $pastEvents->max_num_pages, // total amount of pages 
    ]);
    ?>
</div>

<?php
get_footer();
?>