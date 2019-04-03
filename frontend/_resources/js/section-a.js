/**
* The path of the CSV file where the data is stored in.
* @type {String}
*/
var filePath = "/rvictori/icompute/_resources/csv/section-a.csv";

/**
* The array where the data from the CSV file will be stored at.
* @type {Array}
*/
var sectionAExams = [];

function eventListener() {
  $("div#edit-section-a-section ul.collection li.collection-item").click(function(event) {
    $("div#edit-section-a-section div.offset-s2").html(getSectionAExamFormOutput($(event.target).text()));

    $("div#edit-section-a-section button#edit-section-a-form-save-button").click(function() {
      submitSectionAForm("/rvictori/icompute/_resources/php/submit-section-a-csv.php");
    });
  });
}

function fetchSectionAExams(filePath, storage) {
  $.ajax({
    type: "GET",
    url: filePath,
    dataType: "text",

    success: function(data) {
      var versions = data.trim().split(";;");
      var mainHeading = versions[0].trim();
      var year;

      // For each Section A version.
      for (var i = 1; i < versions.length; i++) {
        var questions = [];
        var currentVersion = versions[i].trim().split("\n");
        var year = currentVersion[0];
        var headings = currentVersion[1].split(";");

        for (var j = 2; j < currentVersion.length; j++) {
          var row = currentVersion[j].trim().split(";");
          var object = '{';

          for (var k = 0; k < headings.length; k++) {
            object += '"' + headings[k].trim() + '": "' + row[k].trim() + '"';

            if (k != headings.length - 1) {
              object += ', ';
            }
          }

          object += '}';

          questions.push(JSON.parse(object));
        }

        var currentSectionA = {
          "year": year,
          "questions": questions
        }

        storage.push(currentSectionA);
      }

      $("div#edit-section-a-section div.offset-s2").html(getSectionAExamsList());

      console.log(storage);

      eventListener();
    }
  });
}

function getSectionAExamFormOutput(year) {
  var selectedExam = sectionAExams.find(function(element) {
    return element.year = year;
  });
  var questions = selectedExam.questions;

  var output = '<hr />';
  output += '<h4>' + selectedExam.year + ' Section A Exam</h4>';
  output += '<button id="section-a-form-back-button" class="btn blue">Back</button><br /><br />';

  for (var i = 0; i < questions.length; i++) {
    output += '<fieldset>';

    output += '<h5>Question ' + (i + 1) + '</h5>';

    output += '<input type="text" id="question-' + (i + 1) + '" name="question-' + (i + 1) + '" value="' + questions[i].question + '" />';
    output += '<label for="question-' + (i + 1) + '">Question</label>';

    output += '<input type="text" id="correct-answer-' + (i + 1) + '" name="correct-answer-' + (i + 1) + '" value="' + questions[i].correctAnswer + '" />';
    output += '<label for="correct-answer-' + (i + 1) + '">Correct Answer</label>';

    output += '<input type="text" id="answer-1-' + (i + 1) + '" name="answer-1-' + (i + 1) + '" value="' + questions[i].answer1 + '" />';
    output += '<label for="answer-1-' + (i + 1) + '">Answer 1</label>';

    output += '<input type="text" id="answer-2-' + (i + 1) + '" name="answer-2-' + (i + 1) + '" value="' + questions[i].answer2 + '" />';
    output += '<label for="answer-2-' + (i + 1) + '">Answer 2</label>';

    output += '<input type="text" id="answer-3-' + (i + 1) + '" name="answer-3-' + (i + 1) + '" value="' + questions[i].answer3 + '" />';
    output += '<label for="answer-3-' + (i + 1) + '">Answer 3</label>';

    output += '</fieldset><br />';

  }

  output += '<button id="edit-section-a-form-save-button" class="btn-large btn-submit blue">Save</button>';

  return output;
}

function getSectionAExamsList() {
  var output = "<ul class='collection'>";

  for (var i = 0; i < sectionAExams.length; i++) {
    output += '<li class="collection-item">';
    output += sectionAExams[i].year;
    output += '</li>'
  }

  output += '</ul>';

  return output;
}

function submitSectionAForm(filePath) {
  var options = {
		url: filePath,
		type: "POST",
    data: {
      "content": "Hello World!"
    }
	};

	console.log("Attempting to submit data...");
	var jqxhr = $.ajax(options)
	.done(function(data) { // Success.
    console.log(data);
    console.log("data?");
    console.log("...data saved.");
  })
  .fail(function() {
    console.log("...submission failed.");
  })
  .always(function() {

  });
}

// Init function.
$(document).ready(function() {
  fetchSectionAExams(filePath, sectionAExams);
});
