<?php
include 'includes/header.php';
include 'includes/db.php';
$pageTitle = 'Register - LuxeStay';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = sanitize($_POST['fullname']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($fullname) || empty($email) || empty($password)) {
        $error = 'All fields are required';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } else {
        // Check if email exists
        $check_sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = 'Email already registered';
        } else {
            // Hash password
            $hashed_password = hashPassword($password);
            
            // Insert user
            $insert_sql = "INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, 'user')";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param('sss', $fullname, $email, $hashed_password);
            
            if ($stmt->execute()) {
                $success = 'Registration successful! Please login.';
                header("refresh:2;url=login.php");
            } else {
                $error = 'Registration failed. Try again.';
            }
        }
    }
}
?>

<div class="auth-container">
    <div class="auth-box">
        <h2>Create Account</h2>
        <p>Join LuxeStay for exclusive benefits</p>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        
        <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
