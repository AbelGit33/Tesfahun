<?php
include 'includes/header.php';
include 'includes/db.php';
$pageTitle = 'Rooms - LuxeStay';

// Get filter parameters
$filter_type = isset($_GET['room_type']) ? sanitize($_GET['room_type']) : '';
$filter_price = isset($_GET['price']) ? (int)$_GET['price'] : 0;

// Build query
$sql = "SELECT * FROM rooms WHERE 1=1";

if ($filter_type) {
    $sql .= " AND room_type = '" . mysqli_real_escape_string($conn, $filter_type) . "'";
}

if ($filter_price > 0) {
    $sql .= " AND price <= $filter_price";
}

$result = mysqli_query($conn, $sql);
?>

<div class="rooms-page">
    <div class="container">
        <h1>Our Rooms</h1>
        <p class="section-subtitle">Choose your perfect room</p>
        
        <div class="rooms-layout">
            <!-- Sidebar Filters -->
            <aside class="filters-sidebar">
                <h3>Filters</h3>
                <form method="GET" class="filter-form">
                    <div class="filter-group">
                        <h4>Room Type</h4>
                        <label>
                            <input type="radio" name="room_type" value="" <?php echo empty($filter_type) ? 'checked' : ''; ?>> All Rooms
                        </label>
                        <label>
                            <input type="radio" name="room_type" value="single" <?php echo $filter_type === 'single' ? 'checked' : ''; ?>> Single
                        </label>
                        <label>
                            <input type="radio" name="room_type" value="double" <?php echo $filter_type === 'double' ? 'checked' : ''; ?>> Double
                        </label>
                        <label>
                            <input type="radio" name="room_type" value="suite" <?php echo $filter_type === 'suite' ? 'checked' : ''; ?>> Suite
                        </label>
                        <label>
                            <input type="radio" name="room_type" value="deluxe" <?php echo $filter_type === 'deluxe' ? 'checked' : ''; ?>> Deluxe
                        </label>
                    </div>
                    
                    <div class="filter-group">
                        <h4>Price Range</h4>
                        <label>
                            <input type="radio" name="price" value="0" <?php echo $filter_price === 0 ? 'checked' : ''; ?>> All Prices
                        </label>
                        <label>
                            <input type="radio" name="price" value="100" <?php echo $filter_price === 100 ? 'checked' : ''; ?>> Up to $100
                        </label>
                        <label>
                            <input type="radio" name="price" value="200" <?php echo $filter_price === 200 ? 'checked' : ''; ?>> Up to $200
                        </label>
                        <label>
                            <input type="radio" name="price" value="300" <?php echo $filter_price === 300 ? 'checked' : ''; ?>> Up to $300
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </form>
            </aside>
            
            <!-- Rooms Grid -->
            <div class="rooms-grid-section">
                <div class="rooms-container">
                    <?php
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
                    } else {
                        echo '<p class="no-rooms">No rooms found matching your criteria.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
