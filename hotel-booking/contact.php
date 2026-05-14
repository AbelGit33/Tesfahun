<?php
include 'includes/header.php';
$pageTitle = 'Contact Us - LuxeStay';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $message = sanitize($_POST['message']);
    
    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Please fill in all required fields';
    } else {
        // Send email or store message in database
        $success = 'Thank you for your message. We will contact you soon!';
    }
}
?>

<div class="contact-page">
    <div class="container">
        <h1>Contact Us</h1>
        <p class="section-subtitle">We'd love to hear from you</p>
        
        <div class="contact-layout">
            <div class="contact-info">
                <h2>Get in Touch</h2>
                
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h3>Address</h3>
                        <p>123 Hotel Street<br>City, Country 12345</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <h3>Phone</h3>
                        <p>+1-800-LUXESTAY<br>+1-800-589-3782</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h3>Email</h3>
                        <p>info@luxestay.com<br>support@luxestay.com</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h3>Hours</h3>
                        <p>Mon - Fri: 8:00 AM - 6:00 PM<br>Sat - Sun: 9:00 AM - 5:00 PM</p>
                    </div>
                </div>
            </div>
            
            <form method="POST" class="contact-form">
                <h2>Send us a Message</h2>
                
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone">
                </div>
                
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
