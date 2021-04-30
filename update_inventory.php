<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['inventory_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $CityID = isset($_POST['inventory_id']) ? $_POST['inventory_id'] : NULL;
        $City = isset($_POST['film_id']) ? $_POST['film_id'] : '';
        $Country = isset($_POST['store_id']) ? $_POST['store_id'] : '';
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE inventory SET inventory_id = ?, film_id = ?, store_id = ?, last_update = ? WHERE inventory_id = ?');
        $stmt->execute([$CityID, $City, $Country, $Last_update,$_GET['inventory_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM inventory WHERE inventory_id = ?');
    $stmt->execute([$_GET['inventory_id']]);
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
	<h2>Update inventory #<?=$Cat['inventory_id']?></h2>
    <form action="update_inventory.php?inventory_id=<?=$Cat['inventory_id']?>" method="post">
        <label for="inventory_id">Inventory_Id</label>
        <label for="film_id">Film_Id</label>
        <input type="text" name="inventory_id" value="<?=$Cat['inventory_id']?>" id="inventory_id">
        <input type="text" name="film_id" value="<?=$Cat['film_id']?>" id="film_id">
        <label for="store_id">Store_Id</label>
        <label for="last_update">Last_update</label>
        <input type="text" name="store_id" value="<?=$Cat['store_id']?>" id="store_id">
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($Cat['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>