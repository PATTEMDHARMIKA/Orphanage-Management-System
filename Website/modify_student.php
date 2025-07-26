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

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];

    $stmt = $conn->prepare("UPDATE students SET name = ?, gender = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $gender, $id);

    if ($stmt->execute()) {
        $successMessage = "Student details updated successfully!";
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
        <h1>Modify Student Details</h1>
        <form method="POST" class="form">
            <label for="id">Select Student:</label>
            <select id="id" name="id" required>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                <?php endwhile; ?>
            </select>
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
            <button type="submit">Update Details</button>
        </form>
    </section>
</main>
<?php include "footer.php"; ?>