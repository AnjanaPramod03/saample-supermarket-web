<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    
  
    <style>
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f7f7f7;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}



.main-content {
    padding: 40px 0;
}

.about-banner {
    background-image: url('img/bg.jpg');
    background-size: cover;
    height: 400px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    text-align: center;
}

.about-banner h1 {
    font-size: 48px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.about-content {
    padding: 40px 0;
}

.about-content h2 {
    font-size: 36px;
    margin-bottom: 20px;
    color: #f39c12;
}

.about-content p {
    font-size: 18px;
    line-height: 1.6;
}

.team-section {
    padding: 40px 0;
}

.team-member {
    text-align: center;
    margin-bottom: 30px;
}

.team-member img {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    margin-bottom: 20px;
    border: 5px solid #f39c12;
}

.team-member h3 {
    font-size: 24px;
    margin-bottom: 10px;
}

.team-member p {
    font-size: 18px;
    color: #888;
}

.testimonials {
    padding: 40px 0;
}

.testimonial {
    text-align: center;
    margin-bottom: 40px;
}

.testimonial img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin-bottom: 20px;
}

.testimonial p {
    font-size: 18px;
    line-height: 1.6;
}


footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px 0;
}


@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}


    </style>
</head>
<body>
   
<main>
    <section class="about-banner">
       
        <h1>Welcome to Our Supermarket</h1>
    </section>

    <section class="about-content">
        <div class="container">
            <h2>About Us</h2>
            <p>We are dedicated to providing our customers with the best shopping experience possible. With a wide range of products, excellent customer service, and convenient locations, we aim to be your go-to destination for all your grocery needs.</p>
            <p>Our supermarket was founded on the principles of quality, affordability, and community. We source our products from trusted suppliers, ensuring freshness and satisfaction with every purchase.</p>
        </div>
    </section>

    <section class="team-section">
        <div class="container">
            <h2>Our Team</h2>
            <div class="team-member">
                <img src="team_member1.jpg" alt="John Doe">
                <h3>John Doe</h3>
                <p>Manager</p>
            </div>
            <div class="team-member">
                <img src="team_member2.jpg" alt="Jane Smith">
                <h3>Jane Smith</h3>
                <p>Assistant Manager</p>
            </div>
          
        </div>
    </section>

    <section class="testimonials">
        <div class="container">
            <h2>What Our Customers Say</h2>
            <div class="testimonial">
                <img src="customer1.jpg" alt="Customer 1">
                <p>"I love shopping at this supermarket! The staff are friendly, and the selection is fantastic. Highly recommended!"</p>
                <p>- Emily Johnson</p>
            </div>
            <div class="testimonial">
                <img src="customer2.jpg" alt="Customer 2">
                <p>"Great prices and a wide variety of products. I always find what I need here. Plus, the checkout process is quick and easy!"</p>
                <p>- Michael Brown</p>
            </div>
          
        </div>
    </section>

    <section class="company-history">
        <div class="container">
            <h2>Company History</h2>
            <p>Our supermarket has been serving the community for over 20 years. It started as a small family-owned business and has grown into one of the most trusted names in the industry.</p>
            <p>Throughout the years, we have remained committed to our customers, employees, and the communities we serve. We are proud of our heritage and look forward to many more years of providing exceptional service.</p>
        </div>
    </section>

    <section class="mission">
        <div class="container">
            <h2>Our Mission</h2>
            <p>Our mission is to exceed customer expectations by providing exceptional service, quality products, and a welcoming environment. We strive to be a positive force in the communities we serve, supporting local initiatives and promoting sustainability.</p>
            <p>At our supermarket, customer satisfaction is our top priority. We are dedicated to making every shopping experience enjoyable and convenient, and we are committed to earning your trust every day.</p>
        </div>
    </section>
</main>


    

   
</body>
</html>
