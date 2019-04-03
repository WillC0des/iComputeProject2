/**
 * Multiple Choice Script
 * This script controls the multiple choice questions including fetching them
 * and showing them.
 */

/**
 * The path of the CSV file where the data is stored in.
 * @type {String}
 */
var filePath = "/aswaenep/_resources/csv/section-a-2019.csv";

/**
 * The array where the data from the CSV file will be stored at.
 * @type {Array}
 */
var questions = [];

/**
 * Obtains the data from the CSV file given by the file link and stores it in
 * the given attribute.
 * @param {String} filePath The relative path of the CSV file.
 * @param {Array} storage The storage where the data will be stored at.
 */
function fetchData(filePath, storage) {
  $.ajax({
    type: "GET",
    url: filePath,
    dataType: "text",

    success: function(data) {
      var rows = data.trim().split("\n");
      var headings = rows[0].split(";");

      for (var i = 1; i < rows.length; i++) {
        var currentRow = rows[i].split(";");
        var object = '{';

        for (var j = 0; j < headings.length; j++) {
          object += '"' + headings[j].trim() + '": "' + currentRow[j].trim() + '"';

          if (j != headings.length - 1) {
            object += ',';
          }
        }

        object += '}';
        questions.push(JSON.parse(object));
      }
    }
  });
}

/**
 * Obtains the output of each card containing the question and the possible
 * answers.
 * @return {String} The output of each card containing the question and the
 * possible answers.
 */
function getOutput() {
  var output = "";

  for (var i = 0; i < questions.length; i++) {
    output += '<div class="card">';
    output += '<div class="card-divider">';
    output += '<h3>Question ' + (i + 1) + '</h3>';
    output += '<p>' + questions[i].question + '</p>';
    output += '</div>';
    output += '<div class="card-section">';

    var answers = [
      questions[i].correctAnswer,
      questions[i].answer1,
      questions[i].answer2,
      questions[i].answer3
    ];

    // Shuffle the answer.
    // Source: https://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
    var currentIndex = answers.length;
    var temporaryValue;
    var randomIndex;
    var i = 1;

    while (currentIndex !== 0) { // While there remain elements to shuffle.
      // Pick a remaining element.
      randomIndex = Math.floor(Math.random() * currentIndex);
      --currentIndex;

      // Swap it with the current element.
      temporaryValue = answers[currentIndex];
      answers[currentIndex] = answers[randomIndex];
      answers[randomIndex] = temporaryValue;
    }

    output += '<div class="collection">';
    for (var j = 0; j < answers.length; j++) {
      output += '<input type="radio" name="question-' + i + '" class="collection-item" /><strong>' + String.fromCharCode(65 + j) + '</strong>: ' + answers[j] + '<br />';
    }
    output += '</div>';

    output += '</div>';
    output += '</div>';
    output += '</div>';

    ++i;
  }

  output += '<button id="submission-button" class="button">Submit</button>';

  return output;
}

// Init function.
$(document).ready(function() {
  fetchData(filePath, questions); // Obtains the data for the multiple choice questions.

  // When the button is clicked, the multiple choice questions will be shown.
  $("div#section-a-section button#start-button").click(function() {
    $("div#section-a-section").html(getOutput());

    $("div#section-a-section input.collection-item").click(function() {
      $(this).parent().children().each(function() {
        $(this).removeClass("selected");
      });

      $(this).addClass("selected");
    });

    // When the submit button is clicked.
    $("div#section-a-section button#submission-button").click(function() {
      var score = 0;
      var i = 0;

      $("div.collection").each(function() {
        if ($(this).find("input.selected").text().substring(3) == questions[i].correctAnswer) {
          ++score;
        }

        ++i;
      });

      var output = '<div class="col s8 offset-s2">';
      output += '<div class="card">';
      output += '<p>Your score: ' + score + ' / ' + questions.length + '</p>';
      output += '</div>';
      output += '</div>';

      $("div#section-a-section").html(output);
    });
  });
});
