<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'database cw';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Database CourseWork 2</h1>
           
			
    	</div>
		<a href="index.php"><i class="fas fa-home"></i>Home</a>
    		<a href="read_actor.php"><i class="fas fa-address-book"></i>Actor</a>
			<a href="read_address.php"><i class="fas fa-address-book"></i>Address</a>
			<a href="read_category.php"><i class="fas fa-address-book"></i>Category</a>
			<a href="read_city.php"><i class="fas fa-address-book"></i>City</a>
			<a href="read_country.php"><i class="fas fa-address-book"></i>Country</a>
			<a href="read_customer.php"><i class="fas fa-address-book"></i>Customer</a>
			<a href="read_customer_payment_rental_details.php"><i class="fas fa-address-book"></i>Customer_Payment_Rental</a>
			<a href="read_customer_store.php"><i class="fas fa-address-book"></i>Customer_Store</a>
			<a href="read_film.php"><i class="fas fa-address-book"></i>Film</a>
			<a href="read_film_actor.php"><i class="fas fa-address-book"></i>Film_Actor</a>
			<a href="read_film_category.php"><i class="fas fa-address-book"></i>Film_Category</a>
			<a href="read_film_rental.php"><i class="fas fa-address-book"></i>Film_Rental</a>
			<a href="read_film_text.php"><i class="fas fa-address-book"></i>Film_Text</a>
			<a href="read_inventory.php"><i class="fas fa-address-book"></i>Inventory</a>
			<a href="read_language.php"><i class="fas fa-address-book"></i>Language</a>
			<a href="read_payment.php"><i class="fas fa-address-book"></i>Payment</a>
			<a href="read_rental.php"><i class="fas fa-address-book"></i>Rental</a>
			<a href="read_staff.php"><i class="fas fa-address-book"></i>Staff</a>
			<a href="read_staff_store.php"><i class="fas fa-address-book"></i>Staff_store</a>
			<a href="read_store.php"><i class="fas fa-address-book"></i>Store</a>
    </nav>
EOT;
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>