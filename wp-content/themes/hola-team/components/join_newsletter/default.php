<div class="join-newsletter-wrapper">
    <form id="join-newsletter-form" class="join-newsletter-form" action="#" method="POST">
        <div class="input-group">
            <input type="email" name="email" id="join-email" class="form-control join-input" placeholder="Email address"
                required>
        </div>
        <div>
            <button type="submit" class="btn btn-primary ms-3" id="join-submit-btn">
                <span class="btn-text">Join</span>
                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
            <input type="hidden" name="recaptcha_token" id="join_recaptcha_token" value="">
        </div>
    </form>
    <div id="join-newsletter-message" class="mt-2" style="display: none;"></div>
</div>