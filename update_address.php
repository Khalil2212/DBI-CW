<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['address_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $Address_id = isset($_POST['address_id']) ? $_POST['address_id'] : NULL;
        $Address = isset($_POST['address']) ? $_POST['address'] : '';
        $District = isset($_POST['district']) ? $_POST['district'] : '';
        $City_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';
        $Postal_code = isset($_POST['postal_code']) ? $_POST['postal_code'] : '';
        $Phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE address SET address_id = ?, address = ?, district = ?, city_id = ?,  postal_code= ?, phone = ?, last_update = ? WHERE address_id = ?');
        $stmt->execute([$Address_id, $Address, $District,$City_id,$Postal_code,$Phone, $Last_update,$_GET['address_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM address WHERE address_id = ?');
    $stmt->execute([$_GET['address_id']]);
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
	<h2>Update Address #<?=$A['address_id']?></h2>
    <form action="update_address.php?address_id=<?=$A['address_id']?>" method="post">
        <label for="address_id">Address_ID</label>
        <label for="address">Address</label>
        <input type="text" name="address_id"value="<?=$A['address_id']?>" id="address_id">
        <input type="text" name="address" value="<?=$A['address']?>" id="address">
        <label for="district">District</label>
        <label for="city_id">City_id</label>
        <input type="text" name="district"value="<?=$A['district']?>" id="district">
        <input type="text" name="city_id" value="<?=$A['city_id']?>" id="city_id">
        <label for="postal_code">Postal_Code</label>
        <label for="phone">Phone</label>
        <input type="text" name="postal_code"value="<?=$A['postal_code']?>" id="postal_code">
        <input type="text" name="phone" value="<?=$A['phone']?>" id="phone">
        <label for="last_update">Last_update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($A['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>