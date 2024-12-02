<?php
include 'db.php'; // Include the database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_number = $_POST['student_number'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $program = $_POST['program'];
    $year_level = $_POST['year_level'];

    // Check if the email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM students WHERE email = ?");
    $stmt->execute([$email]);
    $email_exists = $stmt->fetchColumn();

    if ($email_exists) {
        $error_message = "Email already exists. Please use a different email.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO students (student_number, first_name, last_name, email, date_of_birth, gender, phone, address, program, year_level) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$student_number, $first_name, $last_name, $email, $date_of_birth, $gender, $phone, $address, $program, $year_level]);
    }
}

// Fetch students
$stmt = $pdo->query("SELECT * FROM students");
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Student Information Management</title>
</head>
<body>
    <div class="container">
        <h1>Student Information Management</h1>
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="student_number" placeholder="Student Number" required>
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="date" name="date_of_birth" placeholder="Date of Birth" required>
            <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <input type="text" name="phone" placeholder="Phone">
            <textarea name="address" placeholder="Address"></textarea>
            <input type="text" name="program" placeholder="Program">
            <input type="number" name="year_level" placeholder="Year Level">
            <button type="submit">Add Student</button>
        </form>

        <h2>Student List</h2>
        <ul>
            <?php foreach ($students as $student): ?>
                <li><?php echo htmlspecialchars($student['student_number']) . ' - ' . htmlspecialchars($student['first_name']) . ' ' . htmlspecialchars($student['last_name']) . ' - ' . htmlspecialchars($student['email']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>