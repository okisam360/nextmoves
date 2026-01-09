<?php use Roots\Sage\Setup; use Roots\Sage\Wrapper; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>
<body <?php body_class('ov-h'); ?>>
    <?php do_action('get_header'); ?>
    <?php get_template_part('templates/header'); ?>
    <div class="wrap<?php if( !is_front_page() ) { echo ' fixwrap'; } ?>" role="document">
        <?php if (!is_front_page()): ?>
            <?php get_template_part('templates/breadcrumbs'); ?>
        <?php endif ?>
        <main class="main">
            <?php include Wrapper\template_path(); ?>
        </main>
    </div>
    <?php get_template_part('templates/footer'); ?>
    <?php do_action('get_footer'); ?>
    <?php wp_footer(); ?>
</body>
</html>