(function ($) {
  "use strict";

  $(document).on("submit", "#add_poll_form", function (e) {
    e.preventDefault();

    var question = $("#question").val();

    if (question != "") {
      $(".message").text("Saving...");
      var data = new FormData(this);
      var action = "create_poll";
      data.append("action", action);

      $.ajax({
        data: data,
        type: "POST",
        url: ajax_var.ajaxurl,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          var res = JSON.parse(response);
          $(".message").text(res.message);
          if (res.rescode != "404") {
            $("#add_poll_form")[0].reset();
          }
        },
      });
    } else {
      return false;
    }
  });

  $(document).on("submit", "#edit_poll_form", function (e) {
    e.preventDefault();

    var question = $("#question").val();

    if (question != "") {
      $(".message").text("Saving...");
      var data = new FormData(this);
      var action = "edit_poll";
      data.append("action", action);

      $.ajax({
        data: data,
        type: "POST",
        url: ajax_var.ajaxurl,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          var res = JSON.parse(response);
          $(".message").text(res.message);
        },
      });
    } else {
      return false;
    }
  });
})(jQuery);
