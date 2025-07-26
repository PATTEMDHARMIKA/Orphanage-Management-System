<?php
// Database Connection
$host = 'localhost';
$db = 'oms';
$user = 'root';
$password = '';
$conn = new mysqli($host, $user, $password, $db);

// Check Connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $gender = $_POST['gender'];
  $admissionDate = $_POST['admissionDate'];

  $stmt = $conn->prepare("INSERT INTO students (name, gender, adm_date) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $name, $gender, $admissionDate);

  if ($stmt->execute()) {
    $successMessage = "New student added successfully!";
  } else {
    $errorMessage = "Error: " . $conn->error;
  }
  $stmt->close();
}

$conn->close();
?>

<?php
$pageTitle = "Admission | Sneha Jyothi Orphanage";
include "header.php";
?>

<main class="main-content">
  <section class="form-section">
    <h1>Admissions</h1>
    <?php if (isset($successMessage)): ?>
      <p class="success"><?= htmlspecialchars($successMessage) ?></p>
    <?php elseif (isset($errorMessage)): ?>
      <p class="error"><?= htmlspecialchars($errorMessage) ?></p>
    <?php endif; ?>

    <form method="POST" class="form">
      <label for="name">Full Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="gender">Gender:</label>
      <select id="gender" name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>

      <label for="admissionDate">Admission Date:</label>
      <input type="date" id="admissionDate" name="admissionDate" required>

      <button type="submit">Submit</button>
    </form>
  </section>
</main>

<?php include "footer.php"; ?>