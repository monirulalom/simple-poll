import { registerBlockType } from "@wordpress/blocks";
import { SelectControl } from "@wordpress/components";
import axios from "axios";

var polls = [];

registerBlockType("simple-poll/poll", {
  title: "Simple Poll",
  description: "A simple poll block",
  icon: "groups",
  category: "common",
  attributes: {
    id: {
      type: "string",
      default: "",
    },
    question: {
      type: "string",
      default: "",
    },
  },
  edit: function ({ attributes, setAttributes }) {
    var data = new FormData();
    data.append("action", "list_polls");

    axios
      .post(ajax_var.ajaxurl, data)
      .then(function (response) {
        polls = response.data;
      });    

    return (
      <div>
        <div>Select the poll you want to show</div>
        <SelectControl
          label=""
          value={attributes.id}
          options={polls}
          onChange={(newid) => {
            let question = polls.find(o => o.value == newid);
            setAttributes(
                { id: newid ,
                  question: question.label
                }
              );        
          }}
          __nextHasNoMarginBottom
        />
      </div>
    );
  },
  save: function ( { attributes } ) {
    return (
        <div>
          <h4>{attributes.question}</h4>
            <form className="poll">
                <input type="hidden" name="poll_id" value={attributes.id} />
                <input type="radio" id="poll-{attributes.id}-yes" name="poll_response" value="yes" />
                <label for="poll-{attributes.id}-yes"> Yes</label>
                <br />
                <input type="radio" id="poll-{attributes.id}-no" name="poll_response" value="no" />
                <label for="poll-{attributes.id}-no"> No</label>
                <br />
                <input className="poll-submit-button" type="submit" value="Submit" /> 
              </form>
            <div className="poll-message"></div>
        </div>
    );
  },
});
