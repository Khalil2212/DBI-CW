<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Pay_ID = isset($_POST['payment_id']) && !empty($_POST['payment_id']) && $_POST['payment_id'] != 'auto' ? $_POST['payment_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Cust_ID = isset($_POST['customer_id']) ? $_POST['customer_id'] : '';
    $S_ID = isset($_POST['staff_id']) ? $_POST['staff_id'] : '';
    $R_ID = isset($_POST['rental_id']) ? $_POST['rental_id'] : '';
    $A = isset($_POST['amount']) ? $_POST['amount'] : '';
    $Payment_date = isset($_POST['payment_date']) ? $_POST['payment_date'] :date('Y-m-d H:i:s');
    $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO customer_id VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$Pay_ID, $Cust_ID, $S_ID, $R_ID, $A, $Payment_date, $Last_update]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Record</h2>
    <form action="create_payment.php" method="post">
        <label for="payment_id">Payment_Id</label>
        <label for="customer_id">Customer_Id</label>
        <input type="text" name="payment_id" placeholder="1" value="auto" id="payment_id">
        <input type="text" name="customer_id" id="customer_id">
        <label for="staff_id">Staff_Id</label>
        <label for="rental_id">Rental_Id</label>
        <input type="text" name="staff_id" id="staff_id">
        <input type="text" name="rental_id" id="rental_id">
        <label for="amount">Amount</label>
        <label for="payment_date">Payment_Date</label>
        <input type="text" name="amount" id="amount">
        <input type="datetime-local" name="payment_date" value="<?=date('Y-m-d\TH:i')?>" id="payment_date">
        <label for="last_update">Last_Update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i')?>" id="last_update">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>