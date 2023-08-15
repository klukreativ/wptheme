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
        <?php
        $the_parent = wp_get_post_parent_id(get_the_ID()); // get_the_ID returns post ID, which is used to search for parent ID (if none, returns 0)
        // displays section and dynamically generates data if page has parent
        if ($the_parent) {
        ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_permalink($the_parent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($the_parent); ?></a> <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
        <?php } ?>

        <!-- renders side menu only if there is parent / children, not if single page -->
        <?php
        $children_exist = get_pages(array('child_of' => get_the_ID())); // checks for children
        if ($the_parent || $children_exist) { ?>
            <div class="page-links">
                <h2 class="page-links__title"><a href="<?php echo get_permalink($the_parent) ?>"><?php echo get_the_title($the_parent) ?></a></h2>
                <ul class="min-list">
                    <?php
                    $childrenOfParent = ($the_parent ? $the_parent : get_the_ID()); // if there is parent, use parent to list children, if not use self to list children
                    // lists all page, requires an ass arr for options
                    wp_list_pages(array(
                        'title_li' => null, // disables title 'pages'
                        'child_of' => $childrenOfParent, // lists the children as navigational links
                        'sort_column' => 'menu_order' // will use order values, on pages, to order
                    ));
                    ?>
                </ul>
            </div>
        <?php } ?>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>
    </div>

<?php }
get_footer();
?>