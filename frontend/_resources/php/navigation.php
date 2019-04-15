<div class="top-bar" id="main-navigation" data-animate="hinge-in-from-top spin-out">
  <div class="top-bar-left">
    <ul class="dropdown menu" data-dropdown-menu>
      <?php if ($_SESSION['is_competitor'] == "true" && $_SESSION['is_grader'] == "false" && $_SESSION['is_supervisor'] == "false"): ?>
      <li class="menu-text">Team: <?= $_SESSION['name'] ?></li>
      <?php elseif ($_SESSION['name']): ?>
      <li class="menu-text">User: <?= $_SESSION['name'] ?></li>
      <?php else: ?>
      <li class="menu-text">iCompute</li>
      <?php endif; ?>

      <!-- Supervisor -->
      <?php if ($_SESSION['is_supervisor'] == "true"): ?>
      <li>
        <a title="Go to the Supervisor page." href="supervisor.php">Admin</a>
        <ul class="menu vertical">
          <li><a title="Go to the Edit Section A Questions page." href="edit-section-a-questions.php">Edit Section A Questions</a></li>
          <li><a title="Go to the Edit Section A Tests page." href="edit-section-a-tests.php">Edit Section A Tests</a></li>
          <li><a title="Go to the Edit Users page." href="edit-users.php">Edit Users</a></li>
        </ul>
      </li>
      <?php endif; ?>

      <!-- Grader -->
      <?php if ($_SESSION['is_grader'] == "true"): ?>
      <li>
        <a href="#">Grading</a>
        <ul class="menu vertical">
          <li><a title="" href="#">One</a></li>
        </ul>
      </li>
      <?php endif; ?>

      <!-- Competitor -->
      <?php if ($_SESSION['is_competitor'] == "true"): ?>
      <li><a href="section-a.php">Test</a></li>
      <?php endif; ?>
    </ul>
  </div>

  <div class="top-bar-right">
    <ul class="menu">
      <?php if ($_SESSION['id'] && $_SESSION['is_competitor'] == "true"): ?><!-- If the user is currently logged in -->
      <li><a class="button alert" title="Go to the Log Out page." href="#" data-open="log-out-modal">Log Out</a></li>
      <?php elseif ($_SESSION['id']): ?>
      <li><a class="button alert" title="Go to the Log Out page." href="_resources/php/log-out.php">Log Out</a></li>
      <?php endif; ?>
    </ul>
  </div>
</div>

<?php if ($_SESSION['id'] && $_SESSION['is_competitor'] == "true"): ?>
<!-- Log Out Confirmation Modal for Competitors -->
<div class="reveal" id="log-out-modal" data-reveal>
  <h3>Log Out Confirmation</h3>
  <p class="lead">You may not restart the test.</p>
  <p>Are you sure you want to log out? You may <strong>lose your progress</strong> if the test is currently running and may <strong>not restart the test</strong>, even if it is not completed.</p>

  <!-- Log Out Button -->
  <a class="button alert" title="Go to the Log Out page." href="_resources/php/log-out.php">Log Out</a>

  <!-- Close Modal Button -->
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php endif; ?>
