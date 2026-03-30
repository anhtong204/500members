<div class="<?php echo esc_attr( $container_class ); ?>">
	<?php get_component_title( $component_h1, $component_title, $component_sub_title ); ?>

	<?php
	$label_left   = $row['label_left'] ?? '500 Members';
	$label_right  = $row['label_right'] ?? 'Other';
	$rows         = $row['rows'] ?? array();
	$has_rows     = ! empty( $rows );
	?>

	<?php if ( $has_rows ) : ?>
		<div class="comparison-table">
			<div class="comparison-table-row comparison-table-header">
				<div class="comparison-table-cell description"></div>
				<div class="comparison-table-cell center">
					<span class="comparison-table-title"><?php echo esc_html( $label_left ); ?></span>
				</div>
				<div class="comparison-table-cell side side-right">
					<?php echo esc_html( $label_right ); ?>
				</div>
			</div>

			<?php foreach ( $rows as $row_item ) :
				$description      = $row_item['description'] ?? '';
				$description_info = $row_item['description_info'] ?? '';
				$highlight_row    = ! empty( $row_item['highlight_row'] );
				$has_internal     = ! empty( $row_item['has_internal'] );
				$has_competitor   = ! empty( $row_item['has_competitor'] );
				$row_classes      = 'comparison-table-row' . ( $highlight_row ? ' highlighted' : '' );
			?>
				<div class="<?php echo esc_attr( $row_classes ); ?>">
					<div class="comparison-table-cell description">
						<?php echo esc_html( $description ); ?>
						<?php if ( $description_info ) : ?>
							<span class="description-info" aria-label="<?php echo esc_attr( $description_info ); ?>">
								<span class="description-info-icon">i</span>
								<span class="description-info-tooltip"><?php echo esc_html( $description_info ); ?></span>
							</span>
						<?php endif; ?>
					</div>
					<div class="comparison-table-cell center">
						<span class="icon <?php echo $has_internal ? 'icon-check' : 'icon-cross'; ?>">
							<?php echo $has_internal ? '✔' : '✕'; ?>
						</span>
					</div>
					<div class="comparison-table-cell side side-right">
						<span class="icon <?php echo $has_competitor ? 'icon-check' : 'icon-cross'; ?>">
							<?php echo $has_competitor ? '✔' : '✕'; ?>
						</span>
					</div>
				</div>
			<?php endforeach; ?>

            <div class="comparison-table-row comparison-table-footer">
				<div class="comparison-table-cell description"></div>
				<div class="comparison-table-cell center"></div>
				<div class="comparison-table-cell side side-right"></div>
			</div>
		</div>
	<?php endif; ?>
</div>
