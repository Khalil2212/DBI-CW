<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Address_id = isset($_POST['address_id']) && !empty($_POST['address_id']) && $_POST['address_id'] != 'auto' ? $_POST['address_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Address = isset($_POST['address']) ? $_POST['address'] : '';
    $District = isset($_POST['district']) ? $_POST['district'] : '';
    $City_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';
    $Postal_code = isset($_POST['postal_code']) ? $_POST['postal_code'] : '';
    $Phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO address VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$Address_id, $Address, $District, $City_id, $Postal_code, $Phone, $Last_update]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Contact</h2>
    <form action="create_address.php" method="post">
        <label for="address_id">Address_ID</label>
        <label for="address">Address</label>
        <input type="text" name="address_id" placeholder="1" value="auto" id="address_id">
        <input type="text" name="address" id="address">
        <label for="district">District</label>
        <label for="city_id">City_id</label>
        <input type="text" name="district" id="district">
        <input type="text" name="city_id" id="city_id">
        <label for="postal_code">Postal_code</label>
        <label for="phone">Phone</label>
        <input type="text" name="postal_code" id="postal_code">
        <input type="text" name="phone" id="phone">
        <label for="last_update">Last_Update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i')?>" id="last_update">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>