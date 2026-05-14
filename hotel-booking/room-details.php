<?php
include 'includes/header.php';
include 'includes/db.php';
$pageTitle = 'Room Details - LuxeStay';

if (!isset($_GET['id'])) {
    header("Location: rooms.php");
    exit();
}

$room_id = (int)$_GET['id'];
$sql = "SELECT * FROM rooms WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: rooms.php");
    exit();
}

$room = $result->fetch_assoc();
?>

<div class="room-details-page">
    <div class="container">
        <!-- Room Image Slider -->
        <div class="room-slider">
            <img id="mainImage" src="assets/images/<?php echo htmlspecialchars($room['image']); ?>" alt="<?php echo htmlspecialchars($room['room_name']); ?>" class="main-image">
            <div class="slider-controls">
                <button class="prev-btn" id="prevBtn"><i class="fas fa-chevron-left"></i></button>
                <button class="next-btn" id="nextBtn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        
        <div class="room-details-content">
            <div class="room-info-section">
                <h1><?php echo htmlspecialchars($room['room_name']); ?></h1>
                <p class="room-type-badge"><?php echo htmlspecialchars($room['room_type']); ?></p>
                
                <div class="rating">
                    <span class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </span>
                    <span class="rating-value">4.5 (120 reviews)</span>
                </div>
                
                <h3>Room Details</h3>
                <ul class="amenities-list">
                    <li><i class="fas fa-check"></i> Room Size: 45 sqm</li>
                    <li><i class="fas fa-check"></i> Capacity: <?php echo $room['capacity']; ?> Guests</li>
                    <li><i class="fas fa-check"></i> Bed Type: King/Twin Beds</li>
                    <li><i class="fas fa-check"></i> Air Conditioning</li>
                    <li><i class="fas fa-check"></i> Free WiFi</li>
                    <li><i class="fas fa-check"></i> LCD TV</li>
                    <li><i class="fas fa-check"></i> Private Bathroom</li>
                    <li><i class="fas fa-check"></i> Work Desk</li>
                    <li><i class="fas fa-check"></i> Mini Bar</li>
                    <li><i class="fas fa-check"></i> Safe</li>
                </ul>
                
                <h3>Description</h3>
                <p><?php echo htmlspecialchars($room['description']); ?></p>
            </div>
            
            <!-- Booking Form -->
            <aside class="booking-sidebar">
                <div class="booking-box">
                    <h3>Book This Room</h3>
                    <p class="price-tag">$<?php echo number_format($room['price'], 2); ?><span>/night</span></p>
                    
                    <?php if (isLoggedIn()): ?>
                        <form method="GET" action="booking.php" class="booking-form">
                            <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                            
                            <div class="form-group">
                                <label>Check-in Date</label>
                                <input type="date" name="check_in" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Check-out Date</label>
                                <input type="date" name="check_out" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Number of Guests</label>
                                <input type="number" name="guests" min="1" max="<?php echo $room['capacity']; ?>" value="1" required>
                            </div>
                            
                            <div class="price-calculation">
                                <div class="calc-row">
                                    <span>Nightly Rate:</span>
                                    <span>$<?php echo number_format($room['price'], 2); ?></span>
                                </div>
                                <div class="calc-row">
                                    <span>Number of Nights:</span>
                                    <span id="nightsCount">0</span>
                                </div>
                                <div class="calc-row total">
                                    <span>Total Price:</span>
                                    <span id="totalPrice">$0.00</span>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block">Proceed to Booking</button>
                        </form>
                    <?php else: ?>
                        <div class="login-prompt">
                            <p>Please login to make a booking</p>
                            <a href="login.php" class="btn btn-primary btn-block">Login</a>
                            <a href="register.php" class="btn btn-secondary btn-block">Register</a>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
const roomPrice = <?php echo $room['price']; ?>;
const checkInInput = document.querySelector('input[name="check_in"]');
const checkOutInput = document.querySelector('input[name="check_out"]');

function calculateTotal() {
    if (checkInInput && checkOutInput && checkInInput.value && checkOutInput.value) {
        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);
        const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
        const total = nights * roomPrice;
        
        document.getElementById('nightsCount').textContent = nights > 0 ? nights : 0;
        document.getElementById('totalPrice').textContent = '$' + (total > 0 ? total.toFixed(2) : '0.00');
    }
}

if (checkInInput) checkInInput.addEventListener('change', calculateTotal);
if (checkOutInput) checkOutInput.addEventListener('change', calculateTotal);
</script>

<?php include 'includes/footer.php'; ?>
