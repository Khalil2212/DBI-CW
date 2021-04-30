<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['rental_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $Rent_ID = isset($_POST['rental_id']) ? $_POST['rental_id'] : NULL;
        $Rent_Date = isset($_POST['rental_date']) ? $_POST['rental_date'] :date('Y-m-d H:i:s');
        $Inven_id = isset($_POST['inventory_id']) ? $_POST['inventory_id'] : '';
        $Cust_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : '';
        $R_D = isset($_POST['return_date']) ? $_POST['return_date'] :date('Y-m-d H:i:s');
        $Staff_id = isset($_POST['staff_id']) ? $_POST['staff_id'] :'';
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE rental SET rental_id = ?, rental_date = ?, inventory_id = ?, customer_id = ?,  return_date= ?, staff_id = ?, last_update = ? WHERE rental_id = ?');
        $stmt->execute([$Rent_ID, $Rent_Date, $Inven_id,$Cust_id,$R_D,$Staff_id, $Last_update,$_GET['rental_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM rental WHERE rental_id = ?');
    $stmt->execute([$_GET['rental_id']]);
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
	<h2>Update Rental #<?=$A['rental_id']?></h2>
    <form action="update_rental.php?rental_id=<?=$A['rental_id']?>" method="post">
        <label for="rental_id">Rental_Id</label>
        <label for="rental_date">Rental_Date</label>
        <input type="text" name="rental_id"value="<?=$A['rental_id']?>" id="rental_id">
        <input type="datetime-local" name="rental_date" value="<?=date('Y-m-d\TH:i', strtotime($A['rental_date']))?>" id="rental_date">
        <label for="inventory_id">Inventory_Id</label>
        <label for="rental_id">Rental_Id</label>
        <input type="text" name="inventory_id"value="<?=$A['inventory_id']?>" id="inventory_id">
        <input type="text" name="rental_id" value="<?=$A['rental_id']?>" id="rental_id">
        <label for="return_date">return_date</label>
        <label for="staff_id">staff_id</label>
        <input type="datetime-local" name="return_date" value="<?=date('Y-m-d\TH:i', strtotime($A['return_date']))?>" id="return_date">
        <input type="text" name="staff_id"value="<?=$A['staff_id']?>" id="staff_id">
        <label for="last_update">Last_update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($A['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>