<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['staff_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $f_ID = isset($_POST['staff_id']) ? $_POST['staff_id'] : NULL;
        $Title = isset($_POST['active']) ? $_POST['active'] : '';
        $Desc = isset($_POST['username']) ? $_POST['username'] : '';
        $Release_year = isset($_POST['passwrod']) ? $_POST['passwrod'] : '';
        $Lang_id = isset($_POST['store_id']) ? $_POST['store_id'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE staff_store SET staff_id = ?, active = ?, username = ?, passwrod = ?,  store_id= ? WHERE staff_id = ?');
        $stmt->execute([$f_ID, $Title, $Desc,$Release_year,$Lang_id,$_GET['staff_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM staff_store WHERE staff_id = ?');
    $stmt->execute([$_GET['staff_id']]);
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
	<h2>Update Staff_store #<?=$A['staff_id']?></h2>
    <form action="update_staff_store.php?staff_id=<?=$A['staff_id']?>" method="post">
    <label for="staff_id">Staff_ID</label>
        <label for="active">Active</label>
        <input type="text" name="staff_id" value=<?=$A['staff_id']?> id="staff_id">
        <input type="text" name="active" value=<?=$A['active']?> id="active">
        <label for="username">Username</label>
        <label for="passwrod">Password</label>
        <input type="text" name="username" value=<?=$A['username']?> id="username">
        <input type="text" name="passwrod" value=<?=$A['passwrod']?> id="passwrod">
        <label for="store_id">Store_Id</label>
        <input type="text" name="store_id" value= <?=$A['store_id']?> id="store_id">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>