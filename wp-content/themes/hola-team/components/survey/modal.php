<?php
$states_query = new WP_Query(array(
    'post_type'      => 'state',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'title',
    'order'          => 'ASC',
));
$state_options = '';
if ( $states_query->have_posts() ) {
    while ( $states_query->have_posts() ) {
        $states_query->the_post();
        // Use post title as both value and label. If the CMS stores state abbreviations in the slug, you could use $post->post_name.
        $state_title = get_the_title();
        $state_options .= '<option value="' . esc_attr( $state_title ) . '">' . esc_html( $state_title ) . '</option>';
    }
    wp_reset_postdata();
}
?>
<div class="survey-component-wrapper mt-0">
    <!-- The rest of the survey is shown as a popup modal -->
    <div class="survey-modal" id="survey-modal">
        <div class="survey-modal-dialog">
            <div class="survey-modal-content">
                <form id="survey-form" class="survey-modal-body">
                    <input type="hidden" name="action" value="submit_survey">
                    
                    <!-- Step: get in touch -->
                    <div class="survey-step-content" id="survey-step-get-in-touch" style="display: none;">
                        <div class="get-in-touch-icon-wrap">
                            <div class="user-icon-badge">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="4" y="2" width="16" height="20" rx="3" ry="3"></rect>
                                    <path d="M8 18c0-3 2-4 4-4s4 1 4 4"></path>
                                    <circle cx="12" cy="9" r="2"></circle>
                                </svg>
                            </div>
                        </div>
                        <p class="get-in-touch-text">Please get in touch once you are licensed. If you need guidance on getting licensed, call us at</p>
                        <h3 class="get-in-touch-phone">808-652-5210</h3>
                    </div>

                    <!-- Step: Question 4 -->
                    <div class="survey-step-content" id="survey-step-4" style="display: none;">
                        <div class="survey-form-group">
                            <input type="text" name="legal_name" class="survey-input" required>
                            <span>Legal Name</span>
                        </div>
                        <div class="survey-form-group">
                            <input type="text" name="dob" class="survey-input" required>
                            <span>Date of birth</span>
                        </div>
                        <div class="survey-form-group">
                            <input type="text" name="npn" class="survey-input" required>
                            <span>NPN</span>
                        </div>
                        <div class="survey-form-group">
                            <select name="state_licensed" class="survey-select" required>
                                <option value="" disabled selected>State licensed</option>
                                <?php echo $state_options; ?>
                            </select>
                        </div>
                        <button type="button" class="survey-btn-next" data-next="survey-step-6">Next</button>
                    </div>

                    <!-- Step: Question 6 -->
                    <div class="survey-step-content" id="survey-step-6" style="display: none;">
                        <div class="survey-form-group">
                            <input type="text" name="ssn" class="survey-input" required>
                            <span>Social Security number</span>
                        </div>
                        <div class="survey-form-group">
                            <input type="tel" name="phone" class="survey-input" required>
                            <span>Phone number</span>
                        </div>
                        <div class="survey-form-group">
                            <input type="email" name="email" class="survey-input" required>
                            <span>Email</span>
                        </div>
                        <button type="button" class="survey-btn-next" data-next="survey-step-7">Next</button>
                    </div>

                    <!-- Step: Question 7 -->
                    <div class="survey-step-content" id="survey-step-7" style="display: none;">
                        <h4 class="survey-question-text">Insurance carriers I would like to be contracted with.</h4>
                        <div class="survey-form-group">
                            <textarea name="carriers" class="survey-textarea" rows="5"></textarea>
                        </div>
                        <p class="survey-note">Will be assigned based on your address if left blank.<br>Can be changed/added later.</p>
                        <button type="button" class="survey-btn-next" data-next="survey-step-8">Next</button>
                    </div>

                    <!-- Step: Question 8 -->
                    <div class="survey-step-content" id="survey-step-8" style="display: none;">
                        <h4 class="survey-question-text">I am interested in (check all that apply)</h4>
                        <div class="survey-form-group survey-checkbox-group">
                            <label class="survey-checkbox-label">
                                <input type="checkbox" name="interests[]" value="ACA">
                                <span class="survey-checkbox-custom"></span>
                                ACA
                            </label>
                            <label class="survey-checkbox-label">
                                <input type="checkbox" name="interests[]" value="Medicare Advantage">
                                <span class="survey-checkbox-custom"></span>
                                Medicare Advantage
                            </label>
                            <label class="survey-checkbox-label">
                                <input type="checkbox" name="interests[]" value="Medicare Supplement">
                                <span class="survey-checkbox-custom"></span>
                                Medicare Supplement
                            </label>
                            <label class="survey-checkbox-label">
                                <input type="checkbox" name="interests[]" value="Part D">
                                <span class="survey-checkbox-custom"></span>
                                Part D
                            </label>
                        </div>
                        <button type="button" class="survey-btn-next" data-next="survey-step-9">Next</button>
                    </div>

                    <!-- Step: Question 9 -->
                    <div class="survey-step-content" id="survey-step-9" style="display: none;">
                        <div class="survey-form-group">
                            <input type="text" name="address" class="survey-input" required>
                            <span>Address</span>
                        </div>
                        <div class="survey-form-group">
                            <input type="text" name="address_2" class="survey-input">
                            <span>Address 2</span>
                        </div>
                        <div class="survey-form-group">
                            <input type="text" name="city" class="survey-input" required>
                            <span>City</span>
                        </div>
                        <div class="survey-form-row">
                            <div class="survey-form-group survey-col-half">
                                <select name="address_state" class="survey-select" required>
                                    <option value="" disabled selected>State</option>
                                    <?php echo $state_options; ?>
                                </select>
                            </div>
                            <div class="survey-form-group survey-col-half">
                                <input type="text" name="zipcode" class="survey-input" required>
                                <span>Zip Code</span>
                            </div>
                        </div>
                        <button type="submit" class="survey-btn-next survey-btn-submit" data-next="submit">Submit</button>
                    </div>

                    <!-- Step: Success -->
                    <div class="survey-step-content" id="survey-step-success" style="display: none;">
                        <div class="survey-success-icon">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="40" cy="40" r="40" fill="#75C9CE"/>
                                <path d="M26.6667 42.6667L34.6667 50.6667L53.3333 29.3333" stroke="white" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h2 class="survey-success-title">Thank you!</h2>
                        <p class="survey-success-text">We'll reach out soon</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>