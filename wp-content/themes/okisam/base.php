<?php use Roots\Sage\Setup; use Roots\Sage\Wrapper; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>
<body <?php body_class('ov-h'); ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PRG62JTP"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
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

    <!-- Video Modal -->
    <div id="video-modal" class="modal-video" style="display: none;">
        <div class="modal-video-overlay"></div>
        <div class="modal-video-container">
            <button class="modal-video-close" aria-label="Cerrar video">&times;</button>
            <div class="modal-video-box">
                <div class="video-responsive-container">
                    <div id="player-container"></div>
                </div>
            </div>
        </div>
    </div>

    <?php wp_footer(); ?>
</body>
</html>