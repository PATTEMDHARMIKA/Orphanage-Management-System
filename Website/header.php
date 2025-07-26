<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pageTitle ?? "Sneha Jyothi Orphanage"; ?></title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <header class="header">
        <a href="index.php">
            <img src="images/logo.png" alt="Sneha Jyothi Orphanage Logo" class="logo" />
        </a>
        <nav class="nav">
            <div class="nav-item">
                <a href="#" class="nav-link">Admissions</a>
                <div class="dropdown-menu">
                    <a href="add_student.php">Add Student</a>
                    <a href="modify_student.php">Modify Student Details</a>
                    <a href="remove_student.php">Remove Student</a>
                </div>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">Attendance</a>
                <div class="dropdown-menu">
                    <a href="mark_attendance.php">Mark Attendance</a>
                    <a href="update_attendance.php">Modify/Update Attendance</a>
                </div>
            </div>
            <a href="donate.php" class="nav-link">Donate</a>
        </nav>
    </header>