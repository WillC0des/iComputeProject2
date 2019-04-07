<!DOCTYPE html>

<?php
// session_start();
// echo $_SESSION['jr'];

// if (true) {
//   header("Location: edit-section-a-questions.php");
// }
?>
<html>
  <head>
    <title>Section A: Multiple Choice Exam | iCompute</title>

    <!-- Styles -->

    <!-- Poppins Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />

    <!-- Foundation -->
    <link rel="stylesheet" href="_resources/css/foundation.css" />

    <!-- Custom Styles -->
    <link rel="stylesheet" href="_resources/css/main.css" />
    <style>
      h1, h2, h3, h4, h5, h6 {
        font-family: Poppins;
      }
    </style>
  </head>

  <body>
    <div class="grid-container">
      <div class="grid-x grid-padding-x">
        <div id="app" class="cell">
          <!-- Submit Modal -->
          <div class="reveal" id="submit-modal" data-reveal>
            <h3>Confirmation</h3>
            <p>Here are your answers for the following questions:</p>

            <div v-for="(currentQuestion, index) in teamQuestions">
              <h4>Question {{ index + 1 }}</h4>
              <p>{{ currentQuestion.question }}</p>

              <div class="callout primary" v-if="teamAnswers[index]"><p><strong>Selected Answer</strong>: {{ teamAnswers[index] }}</p></div>
              <div class="callout alert" v-else><p>No answer was selected.</p></div>
            </div>

            <p>Click the submit button to go on to the next section.</p>

            <!-- Submit Button -->
            <button class="button success" v-on:click="submitQuestions">Submit</button>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the submit modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Heading -->
          <h1>iCompute</h1>

          <h2>{{ headingTwo }}</h2>
          <h3>{{ headingThree }}</h3>

          <!-- Start Button -->
          <button class="button expanded" v-if="!testStarted" v-on:click="obtainTeamQuestions">Start Exam</button>

          <!-- Questions Section in Cards -->
          <div v-if="testStarted">
            <div class="card"v-for="(currentQuestion, index) in teamQuestions">
              <div class="card-divider">
                <h4></h4>
                <p><strong>Question {{ index + 1 }}:</strong> {{ currentQuestion.question }}</p>
              </div>

              <div class="card-section">
                <input type="radio" :name="'question-' + index" :value="currentQuestion.answer1" v-model="teamAnswers[index]" /> {{ currentQuestion.answer1 }}<br />

                <input type="radio" :name="'question-' + index" :value="currentQuestion.answer2" v-model="teamAnswers[index]" /> {{ currentQuestion.answer2 }}<br />

                <input type="radio" :name="'question-' + index" :value="currentQuestion.answer3" v-model="teamAnswers[index]" /> {{ currentQuestion.answer3 }}<br />

                <input type="radio" :name="'question-' + index" :value="currentQuestion.answer4" v-model="teamAnswers[index]" /> {{ currentQuestion.answer4 }}<br />
              </div>
            </div>

            <button class="button success" data-open="submit-modal">Submit</button>
          </div>
        </div>
      </div>
    </div>

    <!-- JavaScript Files -->

    <!-- jQuery -->
		<script type="text/javascript" src="_resources/js/vendor/jquery-3.3.1.js"></script>

    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <!-- Foundation -->
		<script type="text/javascript" src="_resources/js/vendor/foundation.min.js"></script>
		<script type="text/javascript" src="_resources/js/vendor/what-input.js"></script>
		<script>
		$(document).ready(function() {
			$(document).foundation();
		});
		</script>

    <!-- Fetching and Getting Data -->
		<script type="text/javascript" src="_resources/js/managing-data.js"></script>

    <!-- Section Script -->
    <script>
    var app = new Vue({
      el: '#app',

      data: {
        // Headings
        headingTwo: 'Competition Exam',
        headingThree: 'Section A: Multiple Choice',

        // Question numbers for this team's exam
        questionNumbers: [],

        // All questions stored
        questions: [],

        // The questions for this team's exam
        teamQuestions: [],

        // Status if test has started.
        testStarted: false,

        // The team's selected answers.
        teamAnswers: []
      },

      methods: {
        obtainTeamQuestions: function() {
          this.testStarted = true;

          // Get the questions only for this team.
          for (var i = 0; i < this.questionNumbers.length; i++) {
            var fetchedQuestion = {};

            for (var j = 0; j < this.questions.length; j++) {
              if (this.questionNumbers[i].questionId == this.questions[j].id) {
                fetchedQuestion = this.questions[j];
              }
            }

            var currentQuestion = {
              id: fetchedQuestion.id,
              question:fetchedQuestion.question,
              answer1: fetchedQuestion.answer1,
              answer2: fetchedQuestion.answer2,
              answer3: fetchedQuestion.answer3,
              answer4: fetchedQuestion.correctAnswer
            }

            // Shuffle the answer.
            // Source: https://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
            var currentIndex = 4;
            var temporaryValue;
            var randomIndex;

            while (currentIndex !== 1) { // While there remain elements to shuffle.
              // Pick a remaining element.
              randomIndex = Math.floor(Math.random() * currentIndex) + 1;
              --currentIndex;

              // Swap it with the current element.
              temporaryValue = currentQuestion['answer' + currentIndex];
              currentQuestion['answer' + currentIndex] = currentQuestion['answer' + randomIndex];
              currentQuestion['answer' + randomIndex] = temporaryValue;
            }

            this.teamQuestions.push(currentQuestion);
          }
        },

        submitQuestions: function() {
          // Grade the multiple-choice questions automatically.
          var grade = 0;

          for (var i = 0; i < this.teamQuestions.length; i++) {
            var currentQuestion = {};

            for (var j = 0; j < this.questions.length; j++) {
              if (this.teamQuestions[i].id == this.questions[j].id) {
                currentQuestion = this.questions[j];
              }
            }

            if (currentQuestion.correctAnswer == this.teamAnswers[i]) {
              ++grade;
            }
          }

          console.log(grade);
        }
      },

      mounted: function() {
        console.log("App mounted.");

        // Get the questions for this team's exam.
        fetchData('_resources/txt/section-a-2019.txt', this.questionNumbers);

        // Get the actual questions.
        fetchData('_resources/txt/section-a-questions.txt', this.questions);

        console.log('this');
        console.log(this.questions);
      },

      watch: {

      }
    });
    </script>
  </body>
</html>
