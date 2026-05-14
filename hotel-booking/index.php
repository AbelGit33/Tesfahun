<?php
include 'includes/header.php';
include 'includes/db.php';
$pageTitle = 'Home - LuxeStay Hotel Booking';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Welcome to LuxeStay</h1>
        <p>Experience luxury and comfort like never before</p>
        
        <!-- Search Form -->
        <div class="search-form">
            <form method="GET" action="rooms.php">
                <div class="form-group">
                    <label>Check-in Date</label>
                    <input type="date" name="check_in" required>
                </div>
                <div class="form-group">
                    <label>Check-out Date</label>
                    <input type="date" name="check_out" required>
                </div>
                <div class="form-group">
                    <label>Guests</label>
                    <input type="number" name="guests" min="1" value="1" required>
                </div>
                <div class="form-group">
                    <label>Room Type</label>
                    <select name="room_type">
                        <option value="">All Types</option>
                        <option value="single">Single Room</option>
                        <option value="double">Double Room</option>
                        <option value="suite">Suite</option>
                        <option value="deluxe">Deluxe</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search Rooms</button>
            </form>
        </div>
    </div>
</section>

<!-- Featured Rooms -->
<section class="featured-rooms">
    <div class="container">
        <h2>Featured Rooms</h2>
        <p class="section-subtitle">Choose from our best rooms</p>
        
        <div class="rooms-container">
            <?php
            $sql = "SELECT * FROM rooms LIMIT 6";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while ($room = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="room-card">
                        <div class="room-image">
                            <img src="assets/images/<?php echo htmlspecialchars($room['image']); ?>" alt="<?php echo htmlspecialchars($room['room_name']); ?>">
                            <span class="room-status <?php echo strtolower($room['status']); ?>"><?php echo ucfirst($room['status']); ?></span>
                        </div>
                        <div class="room-info">
                            <h3><?php echo htmlspecialchars($room['room_name']); ?></h3>
                            <p class="room-type"><?php echo htmlspecialchars($room['room_type']); ?></p>
                            <p class="room-description"><?php echo htmlspecialchars(substr($room['description'], 0, 100)); ?>...</p>
                            <div class="room-details">
                                <span><i class="fas fa-users"></i> <?php echo $room['capacity']; ?> Guests</span>
                                <span class="rating"><i class="fas fa-star"></i> 4.5/5</span>
                            </div>
                            <div class="room-footer">
                                <span class="price">$<?php echo number_format($room['price'], 2); ?>/night</span>
                                <a href="room-details.php?id=<?php echo $room['id']; ?>" class="btn btn-secondary">View Details</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Hotel Services -->
<section class="services">
    <div class="container">
        <h2>Hotel Services</h2>
        <p class="section-subtitle">We provide the best amenities</p>
        
        <div class="services-grid">
            <div class="service-card">
                <i class="fas fa-wifi"></i>
                <h3>Free WiFi</h3>
                <p>High-speed internet throughout the hotel</p>
            </div>
            <div class="service-card">
                <i class="fas fa-swimming-pool"></i>
                <h3>Swimming Pool</h3>
                <p>Olympic-sized pool with resort facilities</p>
            </div>
            <div class="service-card">
                <i class="fas fa-utensils"></i>
                <h3>Restaurant</h3>
                <p>Fine dining with international cuisine</p>
            </div>
            <div class="service-card">
                <i class="fas fa-parking"></i>
                <h3>Parking</h3>
                <p>Complimentary valet and self-parking</p>
            </div>
            <div class="service-card">
                <i class="fas fa-spa"></i>
                <h3>Spa</h3>
                <p>Relaxation and wellness treatments</p>
            </div>
            <div class="service-card">
                <i class="fas fa-dumbbell"></i>
                <h3>Fitness Center</h3>
                <p>24/7 gym with modern equipment</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials">
    <div class="container">
        <h2>Guest Reviews</h2>
        <p class="section-subtitle">What our guests say about us</p>
        
        <div class="testimonials-container">
            <div class="testimonial">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="quote">"Amazing experience! The staff was very friendly and the rooms were immaculate."</p>
                <p class="author">- Sarah Johnson</p>
            </div>
            <div class="testimonial">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="quote">"Perfect location and excellent service. Will definitely come back!"</p>
                <p class="author">- Michael Chen</p>
            </div>
            <div class="testimonial">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="quote">"Luxury meets comfort. Every detail was thoughtfully planned."</p>
                <p class="author">- Emma Williams</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
