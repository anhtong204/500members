<?php
$benefits_list = $row['benefits_list'] ?? array();
$earnings_title = $row['earnings_card_title'] ?? esc_html__('Estimated earnings', 'holateam');
$earnings_label = $row['earnings_label'] ?? esc_html__('Members', 'holateam');
$earnings_value = $row['earnings_value'] ?? 52000;
$earnings_interval = $row['earnings_interval'] ?? esc_html__('year', 'holateam');
$earnings_note = $row['earnings_note'];
$slider_value = $row['earnings_members'] ?? 300;
$button_link = $component_link;

$benefits_items = array();
if (!empty($benefits_list) && is_array($benefits_list)) {
    foreach ($benefits_list as $item) {
        $benefits_items[] = array(
            'title' => $item['title'] ?? '',
            'description' => $item['description'] ?? '',
            'icon' => $item['icon'] ?? '',
        );
    }
}

$select_options = array();
$state_posts = get_posts(
    array(
        'post_type' => 'state',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
    )
);

$default_state_rates = array(
    'Connecticut' => 3258.33,
    'Pennsylvania' => 3258.33,
    'District of Columbia' => 3258.33,
    'California' => 3600.00,
    'New Jersey' => 3600.00,
    'Puerto Rico' => 1975.00,
    'US Virgin Islands' => 1975.00,
);

$default_rate = 2891.66;

if (!empty($state_posts)) {
    foreach ($state_posts as $state_post) {
        $rate = get_field('monthly_renewal_per_100_members', $state_post->ID);
        if ($rate === null || $rate === '') {
            $state_name = get_the_title($state_post);
            $rate = isset($default_state_rates[$state_name]) ? $default_state_rates[$state_name] : $default_rate;
        }

        $select_options[] = array(
            'id' => $state_post->ID,
            'title' => get_the_title($state_post),
            'rate' => floatval($rate),
        );
    }
}

$initial_rate = !empty($select_options) ? $select_options[0]['rate'] : $default_rate;
$initial_amount = $initial_rate * ($slider_value / 100);

if (empty($select_options)) {
    $select_options[] = array(
        'id' => '',
        'title' => esc_html__('State', 'holateam'),
        'rate' => $default_rate,
    );
}
?>


<div class="<?php echo esc_attr($container_class); ?> component-benefits_earnings">
    <div class="benefits-earnings-inner row">
        <div class="benefits-earnings-list">
            <?php if ($row['benefits_title']): ?>
                <h2 class="benefits-list-title"><?php echo esc_html($row['benefits_title']); ?></h2>
            <?php endif; ?>

            <?php foreach ($benefits_items as $benefit): ?>
                <div class="benefits-item">
                    <?php if ($benefit['icon']): ?>
                        <div class="benefits-item-icon" aria-hidden="true">
                            <img src="<?php echo esc_url($benefit['icon']['url']); ?>"
                                alt="<?php echo esc_attr($benefit['icon']['alt']); ?>" />
                        </div>
                    <?php endif; ?>
                    <div class="benefits-item-content">
                        <h3 class="benefits-item-title"><?php echo esc_html($benefit['title']); ?></h3>
                        <p class="benefits-item-text"><?php echo esc_html($benefit['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="benefits-earnings-card-column">
            <div class="benefits-earnings-card">
                <div class="earnings-card-header">
                    <h3 class="earnings-card-title"><?php echo esc_html($earnings_title); ?></h3>
                    <div class="earnings-card-select">
                        <select aria-label="<?php echo esc_attr__('Select state', 'holateam'); ?>">
                            <?php foreach ($select_options as $option): ?>
                                <option value="<?php echo esc_attr($option['id']); ?>"
                                    data-rate="<?php echo esc_attr($option['rate']); ?>">
                                    <?php echo esc_html($option['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.63067 9.75C6.24577 10.4167 5.28352 10.4167 4.89862 9.75L0.135483 1.5C-0.249417 0.833332 0.231709 -1.85702e-07 1.00151 -1.18403e-07L10.5278 7.1441e-07C11.2976 7.81709e-07 11.7787 0.833334 11.3938 1.5L6.63067 9.75Z"
                                fill="currentColor" />
                        </svg>

                    </div>
                </div>

                <div class="earnings-card-body">
                    <div class="earnings-card-control">
                        <label class="earnings-card-label"
                            for="benefits-members-range"><?php echo esc_html($earnings_label); ?></label>
                        <div class="earnings-range-wrap">
                            <input id="benefits-members-range" class="benefits-range-input" type="range" min="100"
                                max="500" step="100" value="<?php echo esc_attr($slider_value); ?>"
                                data-min-earnings="16000" data-max-earnings="84000"
                                data-interval="<?php echo esc_attr($earnings_interval); ?>" />
                            <div class="earnings-range-scale">
                                <span>100</span>
                                <span>200</span>
                                <span>300</span>
                                <span>400</span>
                                <span>500</span>
                            </div>
                        </div>
                    </div>

                    <div class="earnings-value-row">
                        <span class="earnings-value-amount">
                            <?php echo esc_html('$' . number_format_i18n($initial_amount, 2)); ?>
                        </span>
                        <span class="earnings-value-interval">/<?php echo esc_html($earnings_interval); ?></span>
                    </div>

                    <div class="earnings-card-actions">
                        <?php render_link($button_link, 'btn btn-tertiary earnings-card-button'); ?>
                    </div>

                    <?php if ($earnings_note): ?>
                        <div class="earnings-card-note">
                            <a href="<?php echo esc_url($earnings_note['url']); ?>"
                                target="<?php echo $earnings_note['target']; ?>">
                                <?php echo $earnings_note['title']; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>