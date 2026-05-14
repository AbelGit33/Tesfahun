<?php
include 'includes/header.php';
include 'includes/db.php';
requireLogin();
$pageTitle = 'My Profile - LuxeStay';

$user_id = $_SESSION['user_id'];

// Get user bookings
$sql = "SELECT b.*, r.room_name, r.price FROM bookings b JOIN rooms r ON b.room_id = r.id WHERE b.user_id = ? ORDER BY b.check_in DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$bookings_result = $stmt->get_result();
?>

<div class="profile-page">
    <div class="container">
        <h1>My Profile</h1>
        
        <div class="profile-layout">
            <!-- User Info -->
            <aside class="profile-sidebar">
                <div class="profile-card">
                    <div class="profile-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h2><?php echo htmlspecialchars($_SESSION['fullname']); ?></h2>
                    <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    <div class="profile-actions">
                        <a href="#" class="btn btn-secondary">Edit Profile</a>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </aside>
            
            <!-- Bookings -->
            <main class="profile-content">
                <h2>My Bookings</h2>
                
                <?php if ($bookings_result->num_rows > 0): ?>
                    <div class="bookings-list">
                        <?php while ($booking = $bookings_result->fetch_assoc()): ?>
                            <div class="booking-card">
                                <div class="booking-header">
                                    <h3><?php echo htmlspecialchars($booking['room_name']); ?></h3>
                                    <span class="booking-status <?php echo strtolower($booking['status']); ?>"><?php echo ucfirst($booking['status']); ?></span>
                                </div>
                                <div class="booking-details">
                                    <div class="detail-item">
                                        <i class="fas fa-calendar"></i>
                                        <div>
                                            <strong>Dates</strong>
                                            <p><?php echo date('M d, Y', strtotime($booking['check_in'])); ?> - <?php echo date('M d, Y', strtotime($booking['check_out'])); ?></p>
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-users"></i>
                                        <div>
                                            <strong>Guests</strong>
                                            <p><?php echo $booking['guests']; ?> guests</p>
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-dollar-sign"></i>
                                        <div>
                                            <strong>Total Price</strong>
                                            <p>$<?php echo number_format($booking['total_price'], 2); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-actions">
                                    <a href="#" class="btn btn-secondary">Download Invoice</a>
                                    <?php if ($booking['status'] === 'pending'): ?>
                                        <a href="#" class="btn btn-danger">Cancel Booking</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="no-data">You haven't made any bookings yet. <a href="rooms.php">Browse rooms</a></p>
                <?php endif; ?>
            </main>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
