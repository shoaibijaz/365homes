<div class="tab-pane fade" id="pills-agents" role="tabpanel" aria-labelledby="pills-agents-tab">
    <div class="card border-0 shadow">
        <div class="card-body">
            <form action="/api/app_property_agents/save.php" method="POST" id="fmAgent">
                <input type="hidden" name="property_id" value="<?php echo ($_GET['id']) ?>">
                <input type="hidden" name="sort_order" value="">
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-control" name="agent_id" id="ddlAgentProfiles">
                            <option value="">Select Profile</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success btn-block" id="btnAddProfile">
                        <i class="far fa-save"></i> Add Profile</button>
                    </div>
                    <div class="col-md-4">
                        <a href="/dashboard/agents/profiles.php" class="btn btn-success">
                        <i class="fa fa-plus"></i> ADD NEW PROFILE</a>
                    </div>
                </div>
            </form>

            <div class="row mt-5" id="agentsProfileList">

            </div>
        </div>
    </div>
</div>

<script type="text/x-handlebars-template" id='agentProfileItemTemplate'>
    <div class="col-md-6">
        <div class="d-flex flex-row border rounded">
            <div class="p-0 w-25">
                <img src="{{photo}}" class="img-thumbnail border-0" />
            </div>
            <div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
                <h5 class="text-primary">{{first_name}} {{last_name}} </h4>
                    <h6>{{company_name}} ({{designation}})
                </h5>
                <p>Office:{{office_contact}} <br> Mobile: {{mobile_contact}} <br> Fax: {{fax}}</p>
                <div>
                {{#if facebook_url}}
                    <a href="{{#addHttp}}{{facebook_url}}{{/addHttp}}" target="_blank" class="text-muted">
                        <i class="fab fa-facebook-square"></i> Facebook</a> {{/if}}
                        
                        {{#if twitter_url}}  <a href="{{#addHttp}}{{twitter_url}}{{/addHttp}}" target="_blank" class="text-muted">
                        <i class="fab fa-twitter-square"></i> Twitter</a>{{/if}}
                        {{#if instagram_url}}  <a href="{{#addHttp}}{{instagram_url}}{{/addHttp}}" target="_blank" class="text-muted">
                        <i class="fab fa-instagram-square"></i> Instagram</a>{{/if}}
                        {{#if linkedin_url}}  <a href="{{#addHttp}}{{linkedin_url}}{{/addHttp}}" target="_blank" class="text-muted">
                        <i class="fab fa-linkedin-in"></i> Linkedin</a>{{/if}}

                        {{#if website_url}} 
                        <a href="{{#addHttp}}{{website_url}}{{/addHttp}}" target="_blank" class="text-muted">
                        <i class="fas fa-globe"></i> Website</a>
                        {{/if}}
                </div>
                <button data-id="{{pk}}" type="button" class="btn btn-sm btn-danger link-delete-agent" style="position: absolute;top: 10px;right: 23px;">
                <i class="fa fa-times"></i>        Delete
                </button>
            </div>
        </div>
    </div>
</script>