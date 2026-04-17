<div class="<?php echo $container_class; ?> component-shortcode">
    <?php
    $image = $row['image'] ?? null;
    $text = $body ?? '';
    ?>

    <?php if (!empty($text) || !empty($img_url)): ?>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="content-wrapper">
                    <?php get_component_title($component_h1, $component_title, $component_sub_title); ?>

                    <?php echo $text; ?>

                    <?php render_link($component_link, 'btn btn-' . $component_link_style); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>