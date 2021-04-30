<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['payment_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $Pay_ID = isset($_POST['payment_id']) ? $_POST['payment_id'] : NULL;
        $Cus_ID = isset($_POST['customer_id']) ? $_POST['customer_id'] : '';
        $Staff_ID = isset($_POST['staff_id']) ? $_POST['staff_id'] : '';
        $Rent = isset($_POST['rental_id']) ? $_POST['rental_id'] : '';
        $AM = isset($_POST['amount']) ? $_POST['amount'] : '';
        $Pay_Date = isset($_POST['payment_date']) ? $_POST['payment_date'] :date('Y-m-d H:i:s');
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE payment SET payment_id = ?, customer_id = ?, staff_id = ?, rental_id = ?,  amount= ?, payment_date = ?, last_update = ? WHERE payment_id = ?');
        $stmt->execute([$Pay_ID, $Cus_ID, $Staff_ID,$Rent,$AM,$Pay_Date, $Last_update,$_GET['payment_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM payment WHERE payment_id = ?');
    $stmt->execute([$_GET['payment_id']]);
    $A = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$A) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Payment #<?=$A['payment_id']?></h2>
    <form action="update_payment.php?payment_id=<?=$A['payment_id']?>" method="post">
        <label for="payment_id">Payment_Id</label>
        <label for="customer_id">Customer_Id</label>
        <input type="text" name="payment_id"value="<?=$A['payment_id']?>" id="payment_id">
        <input type="text" name="customer_id" value="<?=$A['customer_id']?>" id="customer_id">
        <label for="staff_id">Staff_Id</label>
        <label for="rental_id">Rental_Id</label>
        <input type="text" name="staff_id"value="<?=$A['staff_id']?>" id="staff_id">
        <input type="text" name="rental_id" value="<?=$A['rental_id']?>" id="rental_id">
        <label for="amount">Amount</label>
        <label for="payment_date">Payment_Date</label>
        <input type="text" name="amount"value="<?=$A['amount']?>" id="amount">
        <input type="datetime-local" name="payment_date" value="<?=date('Y-m-d\TH:i', strtotime($A['payment_date']))?>" id="payment_date">
        <label for="last_update">Last_update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($A['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>