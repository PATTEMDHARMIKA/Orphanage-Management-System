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

// Fetch Students
$sql = "SELECT id, name FROM students WHERE deleted = 0";
$result = $conn->query($sql);

// Handle Attendance Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $absentStudents = isset($_POST['absent']) ? $_POST['absent'] : [];

    foreach ($absentStudents as $studentId) {
        $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, 'absent')");
        $stmt->bind_param("is", $studentId, $date);
        $stmt->execute();
    }
    echo "<p class='success'>Attendance submitted successfully!</p>";
}

$conn->close();
?>

<?php
$pageTitle = "Mark Attendance | Sneha Jyothi Orphanage";
include "header.php";
?>

<main class="main-content">
    <section class="form-section">
        <h1>Mark Attendance</h1>
        <form method="POST" class="form">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <h2>Mark Absent:</h2>
            <?php if ($result->num_rows > 0): ?>
                <div class="attendance-table">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="attendance-row">
                            <input type="checkbox" id="student-<?= $row['id'] ?>" name="absent[]" value="<?= $row['id'] ?>">
                            <label for="student-<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></label>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No students found.</p>
            <?php endif; ?>

            <button type="submit">Submit Attendance</button>
        </form>
    </section>
</main>

<?php include "footer.php"; ?>