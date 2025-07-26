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
  $donorName = $_POST['donorName'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $donationAmount = $_POST['donationAmount'];
  $message = $_POST['message'];

  $stmt = $conn->prepare("INSERT INTO donations (donator, email, p_no, amount, message) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssiis", $donorName, $email, $phone, $donationAmount, $message);

  if ($stmt->execute()) {
    $successMessage = "Donation added successfully!";
  } else {
    $errorMessage = "Error: " . $conn->error;
  }
  $stmt->close();
}

$conn->close();
?>

<?php
$pageTitle = "Donate | Sneha Jyothi Orphanage";
include "header.php";
?>

<main class="main-content">
  <section class="form-section">
    <h1>Make a Donation</h1>
    <?php if (isset($successMessage)): ?>
      <p class="success"><?= htmlspecialchars($successMessage) ?></p>
    <?php elseif (isset($errorMessage)): ?>
      <p class="error"><?= htmlspecialchars($errorMessage) ?></p>
    <?php endif; ?>
    <p class="donation-blurb">
      Your contribution can make a world of difference in the lives of
      children at Sneha Jyothi Orphanage. Join us in bringing hope, love,
      and education to those in need. Every donation, no matter the size,
      helps transform lives.
    </p>
    <form class="form" method="POST">
      <label for="donorName">Your Name:</label>
      <input type="text" id="donorName" name="donorName" required />

      <label for="email">Your Email:</label>
      <input type="email" id="email" name="email" required />

      <label for="phone">Your Phone Number:</label>
      <input type="tel" id="phone" name="phone" required />

      <label for="donationAmount">Donation Amount (INR):</label>
      <input type="number" id="donationAmount" name="donationAmount" min="1" required />

      <label for="message">Message (Optional):</label>
      <textarea id="message" name="message" rows="4"
        placeholder="Write a message or specify the purpose of your donation..."></textarea>

      <button type="submit">Donate Now</button>
    </form>
  </section>
</main>

<?php include "footer.php"; ?>