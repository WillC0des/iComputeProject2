<!DOCTYPE html>

<?php
// Source: https://www.johnmorrisonline.com/build-php-login-form-using-sessions/

session_start();

// echo "<pre>"; var_dump($_SESSION); echo "</pre>"; // Check $_SESSION.

// Get the information of all users.
$location = "_resources/txt/users.txt";
$users = str_getcsv(file_get_contents($location), "\n", ";");

for ($i = 0; $i < count($users); $i++) {
  $users[$i] = explode(';', $users[$i]);
}

// Headings
$id_index = array_search('id', $users[0]);
$name_index = array_search('name', $users[0]);
$school_index = array_search('school', $users[0]);
$is_competitor_index = array_search('isCompetitor', $users[0]);
$is_grader_index = array_search('isGrader', $users[0]);
$is_supervisor_index = array_search('isSupervisor', $users[0]);
$username_index = array_search('username', $users[0]);
$password_index = array_search('password', $users[0]);

if (!empty($_POST)) {
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $valid_user = array();

    for ($i = 1; $i < count($users); $i++) {
      if ($users[$i][$username_index] == $_POST['username'] && $users[$i]['password'] == $_POST[$password_index]) {
        $valid_user = $users[$i];
      }
    }

    if (!empty($valid_user)) {
      $id_index = array_search('id', $users[0]);
      $_SESSION['id'] = $valid_user[$id_index];
      $_SESSION['name'] = $valid_user[$name_index];
      $_SESSION['school'] = $valid_user[$school_index];
      $_SESSION['is_competitor'] = $valid_user[$is_competitor_index];
      $_SESSION['is_grader'] = $valid_user[$is_grader_index];
      $_SESSION['is_supervisor'] = $valid_user[$is_supervisor_index];
    } else {
      $invalid = true;
    }
  }
}

if (isset($_SESSION['id'])) {
  if ($_SESSION['is_supervisor'] == "true") {
    header("Location: edit-section-a-questions.php");
    echo "Supervisor here...";
  } else if ($_SESSION['is_grader'] == "true") {
    echo "Grader here...";
  } else if ($_SESSION['is_competitor'] == "true") {
    header("Location: section-a.php");
  }
}

$db_host = "35.237.181.128";
$db_user = "root";
$db_pass = "password";
$db_name = "icomputeproject:us-east1:myinstance";

// $con = new mysqli($db_host, $db_user, $db_pass, $db_name);
// $stmt = $con->prepare("SELECT * FROM Users");
// $stmt->execute();
// $result = $stmt->get_result();
// echo $result;

// if (!empty($_POST)) {
//   if (isset($_POST['username']) && isset($_POST['password'])) {
//     // Getting submitted user data from database
//     $con = new mysqli($db_host, $db_user, $db_pass, $db_name);
//     $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
//     $stmt->bind_param('s', $_POST['username']);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $user = $result->fetch_object();
//
//     // Verify user password and set $_SESSION
//     if (password_verify($_POST['password'], $user->password )) {
//       $_SESSION['user_id'] = $user->ID;
//     }
//   }
// }
?>
<html>
  <head>
    <title>iCompute</title>

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
          <!-- Heading -->
          <h1>iCompute</h1>

          <h2>{{ headingTwo }}</h2>
          <div class="callout">
            <p>Log in with the account provided by the supervisor.</p>

            <form action="index.php" method="post">
              <label>Username
                <input type="text" name="username" placeholder="Username" v-model="username" required />
              </label>

              <label>Password
                <input type="password" name="password" placeholder="Password" v-model="password" required />
              </label>

              <p><button class="button expanded" v-on:click="logIn">Log In</button></p>
            </form>

            <?php if ($_POST['username']): ?>
            <div class="callout alert">
              <p>Please enter your correct username and password.</p>
            </div>
            <?php endif; ?>
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
        headingTwo: "Log In",
        users: [],

        username: "",
        password: "",
      },

      methods: {
        logIn: function() {
          var valid = false;

          for (var i = 0; i < this.users.length; i++) {
            if (this.users[i].username == this.username && this.users[i].password == this.password) {
              valid = true;
            }
          }

          console.log(valid);
        }
      },

      mounted: function() {
        console.log("App mounted.");

        fetchData('_resources/txt/users.txt', this.users);
      },

      watch: {

      }
    });
    </script>
  </body>
</html>
