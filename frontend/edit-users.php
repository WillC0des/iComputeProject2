<!DOCTYPE html>

<?php
session_start();

if (!(isset($_SESSION['id']) && $_SESSION['is_supervisor'] == "true")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>
<html>
  <head>
    <title>Edit Users | iCompute</title>

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
            <p>Type <strong>delete</strong> to delete the user.</p>
            <input type="text" name="delete-confirmation" v-model="deleteConfirmation" />

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the delete modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Create Modal -->
          <div class="reveal" id="create-modal" data-reveal>
            <h3>Create a User</h3>

            <label for="new-user-team-name">Name</label>
            <input type="text" id="new-user-team-name" name="new-user-team-name" v-model="newUser.name" />

            <label for="new-user-school">School</label>
            <input type="text" id="new-user-school" name="new-user-school" v-model="newUser.school" />

            <label for="new-user-username">Username</label>
            <input type="text" id="new-user-username" name="new-user-username" v-model="newUser.username" />

            <label for="new-user-password">Password</label>
            <input type="text" id="new-user-password" name="new-user-password" v-model="newUser.password" />

            <label for="new-user-is-competitor">
              <input type="checkbox" id="new-user-is-competitor" name="new-user-is-competitor" v-model="newUser.isCompetitor" /> Competitor
            </label>

            <label for="new-user-is-grader">
              <input type="checkbox" id="new-user-is-grader" name="new-user-is-grader" v-model="newUser.isGrader" /> Grader
            </label>

            <label for="new-user-is-supervisor">
              <input type="checkbox" id="new-user-is-supervisor" name="new-user-is-supervisor" v-model="newUser.isSupervisor" /> Supervisor
            </label>

            <button class="button" v-on:click="addUser">Create</button>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the create modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Save Modal -->
          <div class="reveal" id="save-modal" data-reveal>
            <h3>Save {{ saveStatus }}</h3>
            <p>Your save was a {{ saveStatus }}.</p>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the save modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Heading -->
          <h1>iCompute</h1>

          <h2>{{ headingTwo }}</h2>
          <h3>{{ headingThree }}</h3>

          <!-- Save Button -->
          <button class="button success" title="Save users." data-open="save-modal" v-on:click="saveUsers"><i class="far fa-save fa-lg"></i></button>

          <!-- Create Button -->
          <button class="button" title="Create a user." data-open="create-modal"><i class="fas fa-plus fa-lg"></i></button>

          <!-- Users Section in Cards -->
          <div class="grid-x grid-padding-x" data-equalizer="question-heading">
            <div class="cell small-12 medium-6 large-6" v-for="(user, index) in users">
              <div class="card">
                <div class="card-divider" data-equalizer="question-edit" data-equalizer-watch="question-heading">
                  <p>{{ user.name }}</p>
                </div>

                <div class="card-section" data-equalizer-watch="question-edit">
                  <label :for="'team-name-' + index">Name</label>
                  <input type="text" :id="'team-name-' + index" :name="'team-name-' + index" v-model="user.name" />

                  <label :for="'school-' + index">School</label>
                  <input type="text" :id="'school-' + index" :name="'school-' + index" v-model="user.school" />

                  <label :for="'username-' + index">Username</label>
                  <input type="text" :id="'username-' + index" :name="'username-' + index" v-model="user.username" />

                  <label :for="'password-' + index">Password</label>
                  <input type="text" :id="'password-' + index" :name="'password-' + index" v-model="user.password" />

                  <label :for="'is-competitor-' + index">
                    <input type="checkbox" :id="'is-competitor-' + index" :name="'is-competitor-' + index" v-model="user.isCompetitor" true-value="true" false-value="false" /> Competitor
                  </label>

                  <label :for="'is-grader-' + index">
                    <input type="checkbox" :id="'is-grader-' + index" :name="'is-grader-' + index" v-model="user.isGrader" true-value="true" false-value="false" /> Grader
                  </label>

                  <label :for="'is-supervisor-' + index">
                    <input type="checkbox" :id="'is-supervisor-' + index" :name="'is-supervisor-' + index" v-model="user.isSupervisor" true-value="true" false-value="false" /> Supervisor
                  </label>

                  <!-- Delete Button -->
                  <button class="button alert" title="Delete this user." data-open="delete-modal" v-on:click="setDeleteIndex(index)"><i class="fas fa-trash-alt fa-lg"></i></button>
                </div>
              </div>
            </div>
          </div>

          <!-- Save Button -->
          <button class="button success" title="Save users." data-open="save-modal" v-on:click="saveUsers"><i class="far fa-save fa-lg"></i></button>

          <!-- Create Button -->
          <button class="button" title="Create a user." data-open="create-modal"><i class="fas fa-plus fa-lg"></i></button>
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
        headingThree: 'Editing Users',

        users: [],

        // Index for user to delete
        deleteIndex: -1,

        // Delete confirmation message
        deleteConfirmation: "",

        // New user
        newUser: {
          id: "",
          name: "",
          school: "",
          isCompetitor: false,
          isGrader: false,
          isSupervisor: false,
          username: "",
          password: ""
        },

        // Save status for modal
        saveStatus: ""
      },

      methods: {
        addUser: function() {
          // Give a unique ID to the new user.
          var newId = -1;

          for (var i = 0; i < this.users.length; i++) {
            if (newId < this.users[i].id) {
              newId = this.users[i].id;
            }
          }

          this.newUser.id = parseInt(newId) + 1;

          // Add the new user to the users array.
          var user = Object.assign({}, this.newUser);
          this.users.push(user);

          // Reset newUser.
          this.newUser = {
            id: "",
            name: "",
            school: "",
            isCompetitor: false,
            isGrader: false,
            isSupervisor: false,
            username: "",
            password: ""
          };

          $("div#create-modal").foundation("close"); // Close the create modal.
        },

        saveUsers: function() {
          let self = this; // "this" is not within the scope of AJAX.

          var filePath = '_resources/php/submit-users.php';
          var storage = this.users;

          $.ajax({
            type: "POST",
            url: filePath,
            data: {
              "data": convertToCsv(storage)
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

        setDeleteIndex: function(index) {
          this.deleteIndex = index;
        }
      },

      mounted: function() {
        console.log("App mounted.");

        fetchData('_resources/txt/users.txt', this.users);
      },

      watch: {
        deleteConfirmation: function() {
          // Delete the user when the confirmation is "delete"
          if (this.deleteConfirmation == "delete") {
            this.users.splice(this.deleteIndex, 1);
            this.deleteConfirmation = "";

            $("div#delete-modal").foundation("close"); // Close the delete modal.
          }
        }
      }
    });
    </script>
  </body>
</html>
