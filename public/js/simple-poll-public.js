(function ($) {
  "use strict";

  // handling the poll form submission from the frontend
  $(document).on("submit", ".poll", function (e) {
    e.preventDefault();

    var submitted_polls = [];
    if (Cookies.get("polls")) {
      submitted_polls = JSON.parse(Cookies.get("polls"));
    }

    var form = $(this);
    var data = new FormData(this);
    var action = "submit_poll";
    data.append("action", action);

    if (submitted_polls.indexOf(data.get("poll_id")) == -1) {
      var unique_vote = true;
    } else {
      unique_vote = false;
    }

    if (unique_vote) {
      form.parent().find(".poll-message").text("Submitting...");
      $.ajax({
        data: data,
        url: ajax_var.ajax_url,
        type: "POST",
        contentType: false,
        processData: false,
        success: function (response) {
          var res = JSON.parse(response);
          form.parent().find(".poll-message").text(res.message);
          submitted_polls.push(data.get("poll_id"));

          let cookie_data = JSON.stringify(submitted_polls);
          Cookies.set("polls", cookie_data, { expires: 1 });
        },
      });
    } else {
      alert("You have already voted!");
    }
  });
})(jQuery);
