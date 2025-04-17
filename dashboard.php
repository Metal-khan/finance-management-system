<!-- dashboard.php -->
<?php
// index.php or dashboard.php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/core.php';

// Now safely connected and tables are ensured
?>

<?php include 'includes/header.php'; ?>
<h2>Finance Management Dashboard</h2>
<ul>
  <li><a href="sections/user-profile.php">User Profile</a></li>
  <li><a href="sections/loan.php">Loan</a></li>
  <li><a href="sections/section-3.php">Section 3</a></li>
  <li><a href="sections/section-4.php">Section 4</a></li>
</ul>
<?php include 'includes/footer.php'; ?>