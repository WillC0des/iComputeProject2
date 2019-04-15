<!DOCTYPE html>

<?php
session_start();

if (!(isset($_SESSION['id']) && $_SESSION['is_competitor'] == "true")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
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
    <?php
    include("_resources/php/navigation.php");
    ?>

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

          <div v-if="hasTaken">
            <p>You have taken this part of the test already and may not take it again. Please move on to the next part of the exam.</p>

            <a class="button expanded" title="Go to the Section B page." href="#">Section B</a>
          </div>
          <div v-else>
            <!-- Start Button -->
            <button class="button expanded" v-if="!testStarted" v-on:click="obtainTeamQuestions">Start Exam</button>

            <!-- Questions Section in Cards -->
            <div v-if="testStarted">
              <!-- Progress Bar -->
              <div class="primary progress" role="progressbar" tabindex="0" :aria-valuenow="progress" aria-valuemin="0" :aria-valuetext="progress + ' percent'" aria-valuemax="100">
                <div class="progress-meter" :style="'width: ' + progress + '%'">
                  <p class="progress-meter-text" v-if="progress != 0">{{ progress }}%</p>
                </div>
              </div>

              <div class="card" v-for="(currentQuestion, index) in teamQuestions">
                <div class="card-divider">
                  <h4></h4>
                  <p><strong>Question {{ index + 1 }}:</strong> {{ currentQuestion.question }}</p>
                </div>

                <div class="card-section">
                  <input type="radio" :name="'question-' + index" :value="currentQuestion.answer1" v-on:click="updateProgress" v-model="teamAnswers[index]" /> {{ currentQuestion.answer1 }}<br />

                  <input type="radio" :name="'question-' + index" :value="currentQuestion.answer2" v-on:click="updateProgress" v-model="teamAnswers[index]" /> {{ currentQuestion.answer2 }}<br />

                  <input type="radio" :name="'question-' + index" :value="currentQuestion.answer3" v-on:click="updateProgress" v-model="teamAnswers[index]" /> {{ currentQuestion.answer3 }}<br />

                  <input type="radio" :name="'question-' + index" :value="currentQuestion.answer4" v-on:click="updateProgress" v-model="teamAnswers[index]" /> {{ currentQuestion.answer4 }}<br />
                </div>
              </div>

              <!-- Submit Button -->
              <button class="button success" data-open="submit-modal">Submit</button>

              <!-- Progress Bar -->
              <div class="primary progress" role="progressbar" tabindex="0" :aria-valuenow="progress" aria-valuemin="0" :aria-valuetext="progress + ' percent'" aria-valuemax="100">
                <div class="progress-meter" :style="'width: ' + progress + '%'">
                  <p class="progress-meter-text" v-if="progress != 0">{{ progress }}%</p>
                </div>
              </div>
            </div>
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

        // The questions for this team's exam
        teamQuestions: [],

        // Status if test has started.
        testStarted: false,

        // The team's selected answers.
        teamAnswers: [],

        // The progress of the team's test.
        progress: 0,

        // All the questions.
        fetchedQuestions: [],

        // Fetched test content.
        fetchedTestContent: [],

        fetchedTestTeams: [],

        fetchedResults: [],

        hasTaken: false
      },

      methods: {
        checkIfTaken: function() {

        },

        obtainTeamQuestions: function() {
          this.testStarted = true;

          var teamId = <?php echo $_SESSION['id']; ?>;
          var testId = -1;

          // Get the test ID for this team.
          for (var i = 0; i < this.fetchedTestTeams.length; i++) {
            if (this.fetchedTestTeams[i].userId == teamId) {
              testId = this.fetchedTestTeams[i].testId;
            }
          }

          // Get the questions only for this team.
          for (var i = 0; i < this.fetchedTestContent.length; i++) {
            if (this.fetchedTestContent[i].testId == testId) {
              var fetchedQuestion = {};

              for (var j = 0; j < this.fetchedQuestions.length; j++) {
                if (this.fetchedQuestions[j].id == this.fetchedTestContent[i].questionId) {
                  fetchedQuestion = this.fetchedQuestions[j];
                }
              }

              var currentQuestion = {
                id: fetchedQuestion.id,
                order: this.fetchedTestContent[i].order,
                question: fetchedQuestion.question,
                answer1: fetchedQuestion.answer1,
                answer2: fetchedQuestion.answer2,
                answer3: fetchedQuestion.answer3,
                answer4: fetchedQuestion.correctAnswer
              };

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
          }
        },

        submitQuestions: function() {
          // Grade the multiple-choice questions automatically.
          var grade = 0;

          for (var i = 0; i < this.teamQuestions.length; i++) {
            var currentQuestion = {};

            for (var j = 0; j < this.fetchedQuestions.length; j++) {
              if (this.teamQuestions[i].id == this.fetchedQuestions[j].id) {
                currentQuestion = this.fetchedQuestions[j];
              }
            }

            if (currentQuestion.correctAnswer == this.teamAnswers[i]) {
              ++grade;
            }
          }

          console.log(grade);
        },

        updateProgress: function() {
          var selectedAnswers = $("input[type='radio']:checked").length;
          var currentProgress = selectedAnswers / this.teamQuestions.length;

          this.progress = Math.floor(currentProgress * 100);
        }
      },

      mounted: function() {
        console.log("App mounted.");

        // Get all the questions.
        fetchData('_resources/txt/section-a-questions.txt', this.fetchedQuestions);

        // Get the information to determine which questions are for the team.
        fetchData('_resources/txt/section-a-test-content.txt', this.fetchedTestContent);

        // Get the information to determine which teams take which test.
        fetchData('_resources/txt/section-a-test-teams.txt', this.fetchedTestTeams);

        // Get the results of all teams.
        fetchData('_resources/txt/section-a-results.txt', this.fetchedResults);
      },

      watch: {
        fetchedResults: function() {
          var userId = <?php echo $_SESSION['id']; ?>;

          for (var i = 0; i < this.fetchedResults.length; i++) {
            if (this.fetchedResults[i].userId == userId) {
              this.hasTaken = true;
            }
          }
        }
      }
    });
    </script>
  </body>
</html>
