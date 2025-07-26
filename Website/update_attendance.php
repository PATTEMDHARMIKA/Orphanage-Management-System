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

// Fetch Attendance Records
$sql = "SELECT a.id, a.date, a.status, s.name 
        FROM attendance a 
        JOIN students s ON a.student_id = s.id
        WHERE a.status = 'absent'";
$result = $conn->query($sql);

// Handle Attendance Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendanceId = $_POST['attendance_id'];
    $newStatus = $_POST['status'];

    $stmt = $conn->prepare("UPDATE attendance SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $attendanceId);
    $stmt->execute();

    echo "<p class='success'>Attendance updated successfully!</p>";
}

$conn->close();
?>

<?php
$pageTitle = "Modify/Update Attendance | Sneha Jyothi Orphanage";
include "header.php";
?>

<main class="main-content">
    <section class="form-section">
        <h1>Modify/Update Attendance</h1>
        <form method="POST" class="form">
            <?php if ($result->num_rows > 0): ?>
                <table class="attendance-table">
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['date']) ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td>
                                    <select name="status">
                                        <option value="absent" <?= $row['status'] == 'absent' ? 'selected' : '' ?>>Absent</option>
                                        <option value="present" <?= $row['status'] == 'present' ? 'selected' : '' ?>>Present
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" name="attendance_id" value="<?= $row['id'] ?>">Update</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No attendance records found.</p>
            <?php endif; ?>
        </form>
    </section>
</main>

<?php include "footer.php"; ?>