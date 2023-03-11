(function($) {
  Handlebars.registerHelper("addHttp", function(options) {
    var url = options.fn(this);

    if (!/^(?:f|ht)tps?\:\/\//.test(url)) {
        url = "http://" + url;
    }
    return url;
});

$.AgentsManager = function(options) {

    var dataList = [];
    var agentProfilesList = [];

    var settings = $.extend({
        productObject: null
    }, options);

    var getProfiles = function() {

        $("#ddlAgentProfiles").html('<option value="">Select Profile</option>');

        $.get('/api/app_agent_profiles/filter.php', {
            is_deleted: 0,
            "_": $.now()
        }, function(response) {
            dataList = JSON.parse(response);

            for (let index = 0; index < dataList.length; index++) {
                var element = dataList[index];
                var option = $("<option />", {
                    text: element.first_name + ' ' + element.last_name,
                    value: element.id
                });

                $("#ddlAgentProfiles").append(option);
            }

            getAgentProfiles();

        });

    };

    var getAgentProfiles = function() {

        $("#agentsProfileList").empty();

        $.get('/api/app_property_agents/filter.php', {
            is_deleted: 0,
            property_id: settings.productObject.id,
            "_": $.now()
        }, function(response) {

            agentProfilesList = JSON.parse(response);

            for (let index = 0; index < agentProfilesList.length; index++) {
                
                var element = agentProfilesList[index];

                var item = dataList.find(a => a.id == element.agent_id);

                if(item) {
                    item.pk = element.id;

                    var source = document.getElementById("agentProfileItemTemplate").innerHTML;
                    var template = Handlebars.compile(source);
                    $("#agentsProfileList").append(template(item));
                }
              
            }

        });

    };

    var initForm = function() {

        var options = {
            beforeSubmit: function() {
                var r = $("#fmAgent").valid();
                if (!r) return r;

                $("#fmAgent input").attr('disabled', true);
                $("#fmAgent button").attr('disabled', true);
            },
            success: onSave,
        };

        $("#fmAgent").ajaxForm(options);
    };

    var onSave = function(response) {

        var r = JSON.parse(response);

        if (r.result > 0) {
            toastr.success('Agent profile has been added.', 'Success');
            getAgentProfiles();
        } else {
            toastr.error('Failed to complete the request', 'INFO!');
        }

        $("#fmAgent input").attr('disabled', false);
        $("#fmAgent button").attr('disabled', false);
    };

    var validateForm = function() {
        $("#fmAgent").validate({
            rules: {
                agent_id: {
                    required: true,
                }
            },
        });
    };

    var deleteFeature = function(id, isDeleted) {

        $.post('/api/app_property_agents/update_delete_status.php', {
            is_deleted: isDeleted,
            id: id
        }, function(response) {
            var r = JSON.parse(response);

            if (r.result == 1) {
                toastr.success('Agent profile has been deleted', 'Success');
                getAgentProfiles();
            } else {
                toastr.error('Failed to complete the request', 'INFO!');
            }
        });

    };

    var registerEvents = function() {

        $("div").on("click", "#btnAddProfile", function(e) {
            e.stopPropagation();

            var id = $("#fmAgent select[name='agent_id']").val();

            var filterCount = agentProfilesList.filter(a=>a.agent_id == id).length;

            if(filterCount<=0) {
                $("#fmAgent input[name='sort_order']").val(agentProfilesList.length + 1);
                $("#fmAgent").submit();
            }
           else{
               toastr.info("Agent already added.");
           }
        });

        $("div").on("click", ".link-delete-agent", function(e) {
            e.stopPropagation();

            var id = $(this).attr('data-id');

            bootbox.confirm("Are you sure? You want to delete this key point.", function(r) {

                if (r) {
                    deleteFeature(id, 1);
                }
            });

        });
    };

    var init = function() {
        registerEvents();
        getProfiles();
        initForm();
        validateForm();
    };

    init();

};

}(jQuery));