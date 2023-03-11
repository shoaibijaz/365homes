(function ($) {

  Handlebars.registerHelper("addHttp", function (options) {
    var url = options.fn(this);

    if (!/^(?:f|ht)tps?\:\/\//.test(url)) {
      url = "http://" + url;
    }
    return url;
  });

  $.AgentsManager = function (options) {

    var dataList = [];
    var agentProfilesList = [];

    var settings = $.extend({
      productObject: null
    }, options);

    var getProfiles = function () {

      $.get('/api/app_agent_profiles/filter.php', {
        is_deleted: 0, owner_id:settings.productObject.owner_id
      }, function (response) {
        dataList = JSON.parse(response);
        getAgentProfiles();
      });

    };

    var getAgentProfiles = function () {

      $("textarea").each(function(){
        var val = $.trim($(this).val());

        $(this).val(val);

      });

      $("#agentsProfileList").empty();

      $.get('/api/app_property_agents/filter.php', {
        is_deleted: 0,
        property_id: settings.productObject.id
      }, function (response) {

        agentProfilesList = JSON.parse(response);

        var mails = [];

        for (let index = 0; index < agentProfilesList.length; index++) {

          var element = agentProfilesList[index];
          var item = dataList.find(a => a.id == element.agent_id);

          if (item) {

            item.pk = element.id;

            var source = document.getElementById("agentProfileTemplate").innerHTML;
            var template = Handlebars.compile(source);
            $("#agentsProfileList").append(template(item));

            if(item.email_contact) {
              mails.push(item.email_contact);
            }

          } else {
            //agentProfilesList.splice(index, 1);
          }

        }

        if (agentProfilesList.length <= 0) {
          $("#contactSection").remove();
          $('a[data-href="#contactSection"]').remove();
        }
        else{
          $("#fmContact input[name='agent_email']").val(mails.join());
        }

      });

    };

    var registerEvents = function () {};

    var init = function () {
      getProfiles();
    };

    init();

  };
}(jQuery));