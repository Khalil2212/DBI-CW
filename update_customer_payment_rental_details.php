<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['customer_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $CityID = isset($_POST['customer_id']) ? $_POST['customer_id'] : NULL;
        $City = isset($_POST['payment_id']) ? $_POST['payment_id'] : '';
        $Country = isset($_POST['rental_id']) ? $_POST['rental_id'] : '';
        $stor = isset($_POST['staff_id']) ? $_POST['staff_id'] :'';
        // Update the record
        $stmt = $pdo->prepare('UPDATE customer_payment_rental_details SET customer_id = ?, payment_id = ?, rental_id = ?, staff_id = ? WHERE customer_id = ?');
        $stmt->execute([$CityID, $City, $Country, $stor,$_GET['customer_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM customer_payment_rental_details WHERE customer_id = ?');
    $stmt->execute([$_GET['customer_id']]);
    $Cat = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$Cat) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Record #<?=$Cat['customer_id']?></h2>
    <form action="update_customer_payment_rental_details.php?customer_id=<?=$Cat['customer_id']?>" method="post">
        <label for="customer_id">Customer_Id</label>
        <label for="payment_id">Payment_Id</label>
        <input type="text" name="customer_id" value="<?=$Cat['customer_id']?>" id="customer_id">
        <input type="text" name="payment_id" value="<?=$Cat['payment_id']?>" id="payment_id">
        <label for="rental_id">Rental_Id</label>
        <label for="staff_id">Staff_Id</label>
        <input type="text" name="rental_id" value="<?=$Cat['rental_id']?>" id="rental_id">
        <input type="text" name="staff_id" value="<?=$Cat['staff_id']?>" id="staff_id">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>