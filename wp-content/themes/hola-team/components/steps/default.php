<div class="<?php echo $container_class; ?>">
	<?php get_component_title($component_h1, $component_title, $component_sub_title); ?>

	<?php if (!empty($row['steps'])): ?>
		<div class="steps-grid row">
			<?php foreach ($row['steps'] as $index => $step):
				$step_number = isset($step['step_number']) && $step['step_number'] !== '' ? $step['step_number'] : ($index + 1);
				$step_title = $step['step_title'] ?? '';
				$step_text = $step['step_text'] ?? '';
				$step_icon = $step['step_icon'] ?? null;
				$step_icon_url = is_array($step_icon) && isset($step_icon['url']) ? $step_icon['url'] : '';
				$step_icon_alt = is_array($step_icon) ? ($step_icon['alt'] ?? '') : '';
				?>

				<div class="col-12 col-md-6 col-lg-4">
					<div class="steps-card">
						<div class="steps-card-content">
							<div class="steps-card-header">
								<div class="steps-number">
									<?php echo esc_html($step_number); ?>
								</div>
							</div>

							<?php if ($step_title): ?>
								<h3 class="steps-title">
									<?php echo esc_html($step_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($step_text): ?>
								<div class="steps-description">
									<?php echo apply_filters('the_content', $step_text); ?>
								</div>
							<?php endif; ?>
						</div>

						<?php if ($step_icon_url): ?>
							<div class="steps-icon">
								<img src="<?php echo esc_url($step_icon_url); ?>" alt="<?php echo esc_attr($step_icon_alt); ?>" />
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>

			<?php if ($row['button']): ?>
				<div class="col-12 steps-button-wrapper">
					<a href="<?php echo esc_url($row['button']['url']); ?>" class="btn btn-primary">
						<?php echo esc_html($row['button']['title']); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>