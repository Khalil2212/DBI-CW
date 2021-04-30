<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Cit = isset($_POST['customer_id']) && !empty($_POST['customer_id']) && $_POST['customer_id'] != 'auto' ? $_POST['customer_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Ci = isset($_POST['payment_id']) ? $_POST['payment_id'] : '';
    $COuntry = isset($_POST['rental_id']) ? $_POST['rental_id'] : '';
    $staf = isset($_POST['staff_id']) ? $_POST['staff_id'] :'';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO customer_payment_rental_details VALUES (?, ?, ?, ?)');
    $stmt->execute([$Cit, $Ci,$COuntry, $staf]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create record</h2>
    <form action="create_customer_payment_rental_details.php" method="post">
        <label for="customer_id">Customer_Id</label>
        <input type="text" name="customer_id"value="auto" id="customer_id">
        <label for="payment_id">Payment_Id</label>
        <input type="text" name="payment_id" id="payment_id">
        <label for="rental_id">Rental_Id</label>
        <input type="text" name="rental_id" id="rental_id">
        <label for="staff_id">Staff_Id</label>
        <input type="text" name="staff_id" id="staff_id">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>