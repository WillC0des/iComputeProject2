<!DOCTYPE html>

<?php
session_start();

if (!(isset($_SESSION['id']) || $_SESSION['is_supervisor'] == "false")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>
<html>
  <head>
    <title>Supervisor | iCompute</title>

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
        <h1>iCompute</h1>
      </div>
    </div>

    <div class="callout secondary">
      <div class="grid-container">
        <div class="grid-x grid-padding-x">
          <div class="cell">
            <div class="orbit" role="region" aria-label="Supervisor Homepage Banner Picture" data-orbit>
              <div class="orbit-wrapper">
                <ul class="orbit-container">
                  <li class="is-active orbit-slide">
                    <figure class="orbit-figure">
                      <img class="orbit-image" src="https://images.pexels.com/photos/2058128/pexels-photo-2058128.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="Space">
                      <figcaption class="orbit-caption"><h2>Supervisor Department</h2></figcaption>
                    </figure>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="grid-container">
      <div class="grid-x grid-padding-x">
        <div id="app" class="cell">
          <h3>Section A</h3>

          <div class="grid-x grid-padding-x">
            <div class="cell small-12 medium-2 large-2">
              <p><a class="button expanded" title="Go to the Editing Section A Questions page." href="edit-section-a-questions.php"><i class="fas fa-question fa-5x"></i></a></p>
            </div>
            <div class="cell small-12 medium-10 large-10">
              <h4><a title="Go to the Editing Section A Questions page." href="edit-section-a-questions.php">Editing Questions</a></h4>
              <p>Visit the page for editing all the questions for Section A, the multiple choice exam. This includes creating new questions for future tests and setting which answer is the correct answer.</p>
            </div>
            <div class="cell small-12 medium-2 medium-2">
              <p><a class="button expanded" title="Go to the Editing Section A Tests page." href="edit-section-a-tests.php"><i class="fas fa-edit fa-5x"></i></a></p>
            </div>
            <div class="cell small-12 medium-10 large-10">
              <h4><a title="Go to the Editing Section A Tests page." href="edit-section-a-tests.php">Editing Tests</a></h4>
              <p>This is the place where you can edit a certain version of the Section A Tests. This also includes determining which competitive team can take which test and which question should be in each test iteration.</p>
            </div>
          </div>

          <h3>Users</h3>

          <div class="grid-x grid-padding-x">
            <div class="cell small-12 medium-2 large-2">
              <p><a class="button alert expanded" title="Go to the Editing Users page." href="edit-users.php"><i class="fas fa-users fa-5x"></i></a></p>
            </div>
            <div class="cell small-12 medium-10 large-10">
              <h4><a title="Go to the Editing Users page." href="edit-users.php">Editing Users</a></h4>
              <p>Get a chance to edit a specific team, grader or supervisor with this page. You can change their username, password and even their level of this program from being a regular competitor to being an administrative supervisor.</p>
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

      },

      methods: {

      },

      mounted: function() {
        console.log("App mounted.");
      },

      watch: {

      }
    });
    </script>
  </body>
</html>
