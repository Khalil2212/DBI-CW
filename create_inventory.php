<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Cit = isset($_POST['inventory_id']) && !empty($_POST['inventory_id']) && $_POST['inventory_id'] != 'auto' ? $_POST['inventory_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Ci = isset($_POST['film_id']) ? $_POST['film_id'] : '';
    $COuntry = isset($_POST['store_id']) ? $_POST['store_id'] : '';
    $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO inventory VALUES (?, ?, ?, ?)');
    $stmt->execute([$Cit, $Ci,$COuntry, $Last_update]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create inventory</h2>
    <form action="create_inventory.php" method="post">
        <label for="inventory_id">Inventory_Id</label>
        <input type="text" name="inventory_id"value="auto" id="inventory_id">
        <label for="film_id">Film_Id</label>
        <input type="text" name="film_id" id="film_id">
        <label for="store_id">Store_Id</label>
        <input type="text" name="store_id" id="store_id">
        <label for="last_update">Last_Update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i')?>" id="last_update">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>