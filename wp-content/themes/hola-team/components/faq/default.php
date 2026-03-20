<div class="<?php echo $container_class; ?>">
	<?php
	$faq_image = isset( $row['faq_image'] ) ? $row['faq_image'] : null;
	$faq_image_url = is_array( $faq_image ) && isset( $faq_image['url'] ) ? $faq_image['url'] : '';
	$faq_image_alt = is_array( $faq_image ) ? ( $faq_image['alt'] ?? '' ) : '';
	?>

	<?php if ( ! empty( $row['faq_items'] ) ) : ?>
		<div class="row">
			<div class="col-md-6">
                <div class="faq-header">
                    <?php get_component_title( $component_h1, $component_title, $component_sub_title ); ?>
                </div>

                <?php if ( $body ) : ?>
                    <div class="faq-body">
                        <?php echo apply_filters( 'the_content', $body ); ?>
                    </div>
                <?php endif; ?>

				<div class="faq-list">
					<?php foreach ( $row['faq_items'] as $index => $faq_item ) : ?>
						<?php
						$question = isset( $faq_item['question'] ) ? $faq_item['question'] : '';
						$answer   = isset( $faq_item['answer'] ) ? $faq_item['answer'] : '';
						$answer_id = 'faq-answer-' . $layout_position . '-' . $index;
						?>
						<div class="faq-item">
							<button class="faq-question" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr( $answer_id ); ?>">
								<span class="faq-question-text"><?php echo esc_html( $question ); ?></span>
								<span class="faq-icon" aria-hidden="true"></span>
							</button>

							<div id="<?php echo esc_attr( $answer_id ); ?>" class="faq-answer" role="region" aria-hidden="true">
								<?php echo apply_filters( 'the_content', $answer ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

                <?php if ( $component_link ) : ?>
                    <div class="faq-action">
                        <?php render_link( $component_link, 'btn btn-primary' ); ?>
                    </div>
                <?php endif; ?>

			</div>

			<?php if ( $faq_image_url ) : ?>
				<div class="col-md-6 faq-image-col">
					<img class="faq-image" src="<?php echo esc_url( $faq_image_url ); ?>" alt="<?php echo esc_attr( $faq_image_alt ); ?>" />
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>

<?php
	$layout = null;
	$component_name = null;
?>