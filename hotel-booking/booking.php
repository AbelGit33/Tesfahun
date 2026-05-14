<?php
include 'includes/header.php';
include 'includes/db.php';
requireLogin();
$pageTitle = 'Complete Booking - LuxeStay';

if (!isset($_GET['room_id'])) {
    header("Location: rooms.php");
    exit();
}

$room_id = (int)$_GET['room_id'];
$check_in = sanitize($_GET['check_in']);
$check_out = sanitize($_GET['check_out']);
$guests = (int)$_GET['guests'];

// Get room details
$sql = "SELECT * FROM rooms WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $room_id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();

// Calculate total
$checkIn = new DateTime($check_in);
$checkOut = new DateTime($check_out);
$nights = $checkOut->diff($checkIn)->days;
$total = $nights * $room['price'];

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insert booking
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO bookings (user_id, room_id, check_in, check_out, guests, total_price, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iissid', $user_id, $room_id, $check_in, $check_out, $guests, $total);
    
    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;
        $success = 'Booking created successfully! Booking ID: ' . $booking_id;
        header("refresh:3;url=profile.php");
    } else {
        $error = 'Booking failed. Please try again.';
    }
}
?>

<div class="booking-page">
    <div class="container">
        <h1>Complete Your Booking</h1>
        
        <div class="booking-layout">
            <!-- Booking Summary -->
            <div class="booking-summary">
                <h2>Booking Summary</h2>
                
                <div class="summary-item">
                    <h3><?php echo htmlspecialchars($room['room_name']); ?></h3>
                    <img src="assets/images/<?php echo htmlspecialchars($room['image']); ?>" alt="Room">
                </div>
                
                <div class="summary-details">
                    <p><strong>Check-in:</strong> <?php echo date('M d, Y', strtotime($check_in)); ?></p>
                    <p><strong>Check-out:</strong> <?php echo date('M d, Y', strtotime($check_out)); ?></p>
                    <p><strong>Number of Nights:</strong> <?php echo $nights; ?></p>
                    <p><strong>Guests:</strong> <?php echo $guests; ?></p>
                </div>
                
                <div class="summary-pricing">
                    <div class="pricing-row">
                        <span>Nightly Rate:</span>
                        <span>$<?php echo number_format($room['price'], 2); ?></span>
                    </div>
                    <div class="pricing-row">
                        <span>Nights:</span>
                        <span><?php echo $nights; ?></span>
                    </div>
                    <div class="pricing-row total">
                        <span>Total Amount:</span>
                        <span>$<?php echo number_format($total, 2); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Booking Form -->
            <div class="booking-form-section">
                <h2>Guest Information</h2>
                
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST" class="booking-form">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" value="<?php echo htmlspecialchars($_SESSION['fullname']); ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Special Requests (Optional)</label>
                        <textarea name="special_requests" placeholder="Any special requests?" rows="4"></textarea>
                    </div>
                    
                    <h3>Payment Method</h3>
                    
                    <div class="payment-methods">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="credit_card" checked>
                            <span>Credit/Debit Card</span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="paypal">
                            <span>PayPal</span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="bank_transfer">
                            <span>Bank Transfer</span>
                        </label>
                    </div>
                    
                    <div class="terms">
                        <label>
                            <input type="checkbox" name="terms" required>
                            I agree to the <a href="#">Terms & Conditions</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
