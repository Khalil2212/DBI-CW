<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['store_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $CityID = isset($_POST['store_id']) ? $_POST['store_id'] : NULL;
        $City = isset($_POST['manager_staff_id']) ? $_POST['manager_staff_id'] : '';
        $Country = isset($_POST['Address_id']) ? $_POST['Address_id'] : '';
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE store SET store_id = ?, manager_staff_id = ?, Address_id = ?, last_update = ? WHERE store_id = ?');
        $stmt->execute([$CityID, $City, $Country, $Last_update,$_GET['store_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM store WHERE store_id = ?');
    $stmt->execute([$_GET['store_id']]);
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
	<h2>Update Store #<?=$Cat['store_id']?></h2>
    <form action="update_store.php?store_id=<?=$Cat['store_id']?>" method="post">
        <label for="store_id">store_id</label>
        <label for="manager_staff_id">Manager_Staff_Id</label>
        <input type="text" name="store_id" value="<?=$Cat['store_id']?>" id="store_id">
        <input type="text" name="manager_staff_id" value="<?=$Cat['manager_staff_id']?>" id="manager_staff_id">
        <label for="Address_id">Address_ID</label>
        <label for="last_update">Last_update</label>
        <input type="text" name="Address_id" value="<?=$Cat['Address_id']?>" id="Address_id">
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($Cat['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>