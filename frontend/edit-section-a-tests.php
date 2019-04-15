<!DOCTYPE html>

<?php
session_start();

if (!(isset($_SESSION['id']) && $_SESSION['is_supervisor'] == "true")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>
<html>
  <head>
    <title>Edit Section A Tests | iCompute</title>

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
          <!-- Delete Modal -->
          <div class="reveal" id="delete-modal" data-reveal>
            <h3>Confirmation</h3>
            <p>Type <strong>delete</strong> to delete the {{ deleteItemType }}.</p>
            <input type="text" name="delete-confirmation" v-model="deleteConfirmation" />

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the delete modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Add Question Modal -->
          <div class="reveal" id="add-question-modal" data-reveal>
            <h3>Adding a Question</h3>
            <p>Pick a question you want to add.</p>

            <select v-model="addedQuestionId">
              <option v-for="question in questions" :value="question.id">{{ question.question }}</option>
            </select>

            <!-- Create Button -->
            <button class="button" v-on:click="addQuestion">Add</button>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the add modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Add Team Modal -->
          <div class="reveal" id="add-team-modal" data-reveal>
            <h3>Adding a Team</h3>
            <p>Pick a team you want to add.</p>

            <select v-model="addedTeamId">
              <option v-for="user in users" v-if="user.isCompetitor == 'true'" :value="user.id">{{ user.name }}</option>
            </select>

            <!-- Create Button -->
            <button class="button" v-on:click="addTeam">Add</button>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the add modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Create a Test Modal -->
          <div class="reveal" id="create-modal" data-reveal>
            <h3>Create a Test</h3>

            <label for="new-test-name">Name</label>
            <input type="text" id="new-test-name" name="new-test-name" v-model="newTest.name" />

            <label for="new-test-year">Year</label>
            <input type="text" id="new-test-year" name="new-test-year" v-model="newTest.year" />

            <!-- Create Button -->
            <button class="button" v-on:click="addTest">Create</button>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the create modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Heading -->
          <h1>iCompute</h1>

          <h2>{{ headingTwo }}</h2>
          <h3>{{ headingThree }}</h3>

          <!-- Save Button -->
          <button class="button success" title="Save tests." data-open="save-modal" v-if="tests.length != 0" v-on:click="saveTests"><i class="far fa-save fa-lg"></i></button>

          <!-- Create Button -->
          <button class="button" title="Create a test." data-open="create-modal"><i class="fas fa-plus fa-lg"></i></button>

          <!-- Tests Section -->
          <div class="card" v-for="(test, index) in tests">
            <div class="card-divider">
              <p>{{ test.name }} <span v-if="test.year">({{ test.year }})</span></p>
            </div>

            <div class="card-section">
              <h5>Details</h5>

              <label :for="'name-' + index">Name</label>
              <input type="text" :id="'name-' + index" :name="'name-' + index" v-model="test.name" />

              <label :for="'year-' + index">Year</label>
              <input type="text" :id="'year-' + index" :name="'year-' + index" v-model="test.year" />

              <div class="grid-x grid-padding-x">
                <!-- Questions -->
                <div class="cell small-12 medium-6 large-6">
                  <h5>Questions</h5>

                  <!-- Add Question Button -->
                  <button class="tiny button" title="Add a question." data-open="add-question-modal" v-on:click="setAdd(test.id)"><i class="fas fa-plus fa-lg"></i></button>

                  <div class="callout primary" v-for="(content, contentIndex) in testContent" v-if="test.id == content.testId">
                    <p>{{ getQuestion(content.questionId) }}</p>

                    <!-- Delete Question Button -->
                    <button class="tiny button alert" title="Delete this question." data-open="delete-modal" v-on:click="setDelete(contentIndex, 'question')"><i class="fas fa-times fa-lg"></i></button>
                  </div>
                </div>

                <!-- Teams -->
                <div class="cell small-12 medium-6 large-6">
                  <h5>Teams</h5>

                  <!-- Add Team Button -->
                  <button class="tiny button" title="Add a team." data-open="add-team-modal" v-on:click="setAdd(test.id)"><i class="fas fa-plus fa-lg"></i></button>

                  <div class="callout success" v-for="(team, teamIndex) in testTeams" v-if="test.id == team.testId">
                    <p>{{ getTeam(team.userId) }}</p>

                    <!-- Delete Team Button -->
                    <button class="tiny button alert" title="Delete this team." data-open="delete-modal" v-on:click="setDelete(teamIndex, 'team')"><i class="fas fa-times fa-lg"></i></button>
                  </div>
                </div>

                <!-- Delete Button -->
                <div class="cell">
                  <button class="button alert" title="Delete this test." data-open="delete-modal" v-on:click="setDelete(index, 'test')"><i class="fas fa-trash-alt fa-lg"></i></button>
                </div>
              </div>
            </div>
          </div>

          <!-- Save Button -->
          <button class="button success" title="Save tests." data-open="save-modal" v-if="tests.length != 0" v-on:click="saveTests"><i class="far fa-save fa-lg"></i></button>

          <!-- Create Button -->
          <button class="button" title="Create a test." data-open="create-modal"><i class="fas fa-plus fa-lg"></i></button>
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
        headingTwo: 'Administrative Access',
        headingThree: 'Editing Section A Tests',

        // Get all test versions.
        tests: [],

        // Get content for all test versions.
        testContent: [],

        // Get all questions.
        questions: [],

        // Get all information on which team is taking which test.
        testTeams: [],

        // Get all users
        users: [],

        // What type of item to delete for output.
        deleteItemType: "",

        // The index of the item to delete.
        deleteIndex: -1,

        // The confirmation input of deletion.
        deleteConfirmation: "",

        // The index of the test that a question needs to be added to.
        addedTestId: -1,

        // The index of the question to be added.
        addedQuestionId: 1,

        // The index of the team to be added.
        addedTeamId: 1,

        saveStatus: "",

        // Variables for New Test
        newTest: {
          id: -1,
          name: "",
          year: ""
        },
      },

      methods: {
        addTeam: function() {
          var team = {
            testId: this.addedTestId,
            userId: this.addedTeamId
          };

          this.testTeams.push(team);

          // Reset the team index.
          this.addedTeamId = 1;

          $("div#add-team-modal").foundation("close"); // Close the add modal.
        },

        addTest: function() {
          // Give a unique ID to the new test.
          var newId = -1;

          for (var i = 0; i < this.tests.length; i++) {
            if (newId < this.tests[i].id) {
              newId = this.tests[i].id;
            }
          }

          this.newTest.id = parseInt(newId) + 1;

          // Add the new test to the tests array.
          var test = Object.assign({}, this.newTest);
          this.tests.push(test);

          // Reset newTest.
          this.newTest = {
            id: -1,
            name: "",
            year: ""
          };

          $("div#create-modal").foundation("close"); // Close the create modal.
        },

        addQuestion: function() {
          var question = {
            testId: this.addedTestId,
            order: -1,
            questionId: this.addedQuestionId
          };

          // Get the next order number for this test.

          for (var i = 0; i < this.testContent.length; i++) {
            if (this.testContent[i].testId == this.addedTestId && question.order < this.testContent[i].order) {
              question.order = this.testContent[i].order;
            }
          }

          ++question.order;

          this.testContent.push(question);

          // Reset the question index.
          this.addedQuestionId = 1;

          $("div#add-question-modal").foundation("close"); // Close the add modal.
        },

        getQuestion: function(questionId) {
          var question = "";

          for (var i = 0; i < this.questions.length; i++) {
            if (this.questions[i].id == questionId) {
              question = this.questions[i].question;
            }
          }

          return question;
        },

        getTeam: function(userId) {
          var teamName = "";

          for (var i = 0; i < this.users.length; i++) {
            if (this.users[i].id == userId) {
              teamName = this.users[i].name;
            }
          }

          return teamName;
        },

        saveTests: function() {
          let self = this; // "this" is not within the scope of AJAX.

          var filePath = '_resources/php/submit-section-a-tests.php';

          $.ajax({
            type: "POST",
            url: filePath,
            data: {
              "testsData": convertToCsv(self.tests),
              "testQuestionsData": convertToCsv(self.testContent),
              "testTeamsData": convertToCsv(self.testTeams)
            },

            success: function() { // Success.
              console.log("...submission success.");

              self.saveStatus = "success";
            },

            fail: function() { // Failure.
              console.log("...submission failure.");

              self.saveStatus = "failure";
            },

            always: function() { // Always.

            }
          });
        },

        setAdd: function(index) {
          this.addedTestId = index;
        },

        setDelete: function(index, type) {
          this.deleteIndex = index;
          this.deleteItemType = type;
        }
      },

      mounted: function() {
        console.log("App mounted.");

        // Fetch all the test versions.
        fetchData('_resources/txt/section-a-tests.txt', this.tests);

        // Fetch the content for all test versions.
        fetchData('_resources/txt/section-a-test-content.txt', this.testContent);

        // Fetch all questions.
        fetchData('_resources/txt/section-a-questions.txt', this.questions);

        // Fetch the information on which team is taking which test.
        fetchData('_resources/txt/section-a-test-teams.txt', this.testTeams);

        // Fetch all users.
        fetchData('_resources/txt/users.txt', this.users);
      },

      watch: {
        deleteConfirmation: function() {
          // Delete the user when the confirmation is "delete"
          if (this.deleteConfirmation == "delete") {
            switch (this.deleteItemType) {
              case "question":
                this.testContent.splice(this.deleteIndex, 1);
                break;

              case "team":
                this.testTeams.splice(this.deleteIndex, 1);
                break;

              case "test":
                var deletedTest = this.tests[this.deleteIndex];

                // Delete the test content that was in this test.
                var indexToDelete = [];

                for (var i = 0; i < this.testContent.length; i++) {
                  if (this.testContent[i].testId == deletedTest.id) {
                    indexToDelete.push(i);
                  }
                }

                for (var i = indexToDelete.length - 1; i >= 0; i--) {
                  this.testContent.splice(indexToDelete[i], 1);
                }

                // Delete the users that were in this test.
                indexToDelete = [];

                for (var i = 0; i < this.testTeams.length; i++) {
                  if (this.testTeams[i].testId == deletedTest.id) {
                    indexToDelete.push(i);
                  }
                }

                for (var i = indexToDelete.length - 1; i >= 0; i--) {
                  this.testTeams.splice(indexToDelete[i], 1);
                }

                // Delete the entire test, finally.
                this.tests.splice(this.deleteIndex, 1);
            }

            this.deleteConfirmation = "";
            $("div#delete-modal").foundation("close"); // Close the delete modal.
          }
        }
      }
    });
    </script>
  </body>
</html>
