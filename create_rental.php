<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Pay_ID = isset($_POST['rental_id']) && !empty($_POST['rental_id']) && $_POST['rental_id'] != 'auto' ? $_POST['rental_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Cust_ID = isset($_POST['rental_date']) ? $_POST['rental_date'] :date('Y-m-d H:i:s');
    $S_ID = isset($_POST['inventory_id']) ? $_POST['inventory_id'] : '';
    $R_ID = isset($_POST['customer_id']) ? $_POST['customer_id'] : '';
    $A = isset($_POST['return_date']) ? $_POST['return_date'] :date('Y-m-d H:i:s');
    $Payment_date = isset($_POST['staff_id']) ? $_POST['staff_id'] :'';
    $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO rental VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$Pay_ID, $Cust_ID, $S_ID, $R_ID, $A, $Payment_date, $Last_update]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Record</h2>
    <form action="create_rental.php" method="post">
        <label for="rental_id">Rental_id</label>
        <label for="rental_date">rental_date</label>
        <input type="text" name="rental_id" placeholder="1" value="auto" id="rental_id">
        <input type="datetime-local" name="rental_date" value="<?=date('Y-m-d\TH:i')?>" id="rental_date">
        <label for="inventory_id">inventory_id</label>
        <label for="customer_id">customer_id</label>
        <input type="text" name="inventory_id" id="inventory_id">
        <input type="text" name="customer_id" id="customer_id">
        <label for="return_date">Return_Date</label>
        <label for="staff_id">Staff_Id</label>
        <input type="datetime-local" name="return_date" value="<?=date('Y-m-d\TH:i')?>" id="return_date">
        <input type="text" name="staff_id" id="staff_id">
        <label for="last_update">Last_Update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i')?>" id="last_update">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>