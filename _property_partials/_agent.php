<section class="contact-section" id="contactSection">
    <div class="container">
        <div class="row">
            <div class="col-md-3 offset-md-2" id="agentsProfileList">
            </div>

            <div class="col-md-5">
                <h4 class="tc-primary my-3 text-center-sm">
                    Get In Touch
                </h4>

                <form action="/api/app_property_ask/save.php" method="post" id="fmContact">
                    <input type="hidden" name="property_id" value="<?php echo ($id); ?>">

                    <input type="hidden" name="address" value="<?php echo ($product['property']['address']); ?>">
                    <input type="hidden" name="agent_email" value="">

                    <div class="form-group mb-5">
                        <input type="text" class="form-control form-control-sm" name="full_name" placeholder="Your name here">
                    </div>

                    <div class="form-group mb-5">
                        <input type="email" class="form-control  form-control-sm" name="email" placeholder="You email address here">
                    </div>

                    <div class="form-group mb-5">
                        <input type="text" class="form-control form-control-sm" name="phone" placeholder="Your phone number here">
                    </div>
                    <div class="form-group mb-4">
                        <textarea class="form-control" rows="5" name="message" placeholder="Additional information">

                        </textarea>
                    </div>

                    <div>
                        <button type="button" id="btnSubmitContact" class="btn btn-lg btn-warning bg-theme-orange">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script type="text/x-handlebars-template" id='agentProfileTemplate'>

    <div class="user-card mb-4">

        <div class="card-block text-center-sm">
            <div class="user-image">
                <img src="{{photo}}" class="img-fluid" alt="">
            </div>
            <h6 class="f-w-600 m-t-25 m-b-10 tc-primary">{{first_name}} {{last_name}}</h6>
            <p class="text-white small">{{designation}} - {{company_name}}</p>

            {{#if office_contact}}
            <div class="text-muted small mt-3 mb-1">Office:{{office_contact}}</div>  {{/if}}

            {{#if fax}}
            <div class="text-muted small mb-1">Fax: {{fax}}</div>  {{/if}}

            {{#if mobile_contact}}
            <div class="text-muted mb-3">Mobile: {{mobile_contact}}</div>  {{/if}}
            <div class="user-social-link">
                <div>
                    {{#if website_url}}
                        <a href="{{#addHttp}}{{website_url}}{{/addHttp}}" target="_blank" class="btn btn-sm btn-dark text-white">
                            <i class="bi bi-globe"></i>
                        </a>
                    {{/if}}
                    {{#if facebook_url}}
                        <a href="{{#addHttp}}{{facebook_url}}{{/addHttp}}" target="_blank" class="btn btn-sm text-white" style="background-color:#4267B2">
                            <i class="bi bi-facebook"></i>
                        </a>
                    {{/if}}
                    {{#if twitter_url}}
                        <a href="{{#addHttp}}{{twitter_url}}{{/addHttp}}" target="_blank" class="btn btn-sm text-white" style="background-color:#1DA1F2">
                            <i class="bi bi-twitter"></i>
                        </a>
                    {{/if}}

                    {{#if instagram_url}}
                        <a href="{{#addHttp}}{{instagram_url}}{{/addHttp}}" target="_blank" class="btn btn-sm text-white" style="background-color:#833AB4">
                            <i class="bi bi-instagram"></i>
                        </a>
                    {{/if}}

                    {{#if linkedin_url}}
                        <a href="{{#addHttp}}{{linkedin_url}}{{/addHttp}}" target="_blank" class="btn btn-sm text-white" style="background-color:#2867B2">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    {{/if}}
                </div>
            </div>
        </div>
    </div>

</script>