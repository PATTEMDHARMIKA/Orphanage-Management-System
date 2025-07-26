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

// Handle Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE students SET deleted = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $successMessage = "Student removed successfully!";
    } else {
        $errorMessage = "Error: " . $conn->error;
    }
    $stmt->close();
}

// Fetch Students for Dropdown
$result = $conn->query("SELECT id, name FROM students WHERE deleted = 0");
$conn->close();
?>
<?php
$pageTitle = "Add Student | Sneha Jyothi Orphanage";
include "header.php";
?>
<main class="main-content">
    <section class="form-section">
        <h1>Remove Student</h1>
        <form method="POST" class="form">
            <label for="id">Select Student:</label>
            <select id="id" name="id" required>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Remove Student</button>
        </form>
    </section>
</main>
<?php include "footer.php"; ?>