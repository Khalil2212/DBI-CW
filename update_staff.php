<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['staff_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $f_ID = isset($_POST['staff_id']) ? $_POST['staff_id'] : NULL;
        $Title = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $Desc = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $Release_year = isset($_POST['address_id']) ? $_POST['address_id'] : '';
        $Lang_id = isset($_POST['picture']) ? $_POST['picture'] : '';
        $O_Lang = isset($_POST['email']) ? $_POST['email'] : '';
        $Ren = isset($_POST['store_id']) ? $_POST['store_id'] : '';
        $Rent_Rate = isset($_POST['active']) ? $_POST['active'] :'';
        $Leng = isset($_POST['username']) ? $_POST['username'] :'';
        $Rep = isset($_POST['password']) ? $_POST['password'] :'';
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE staff SET staff_id = ?, first_name = ?, last_name = ?, address_id = ?,  picture= ?, email = ?, active = ?, username = ?,password = ? , last_update = ? WHERE staff_id = ?');
        $stmt->execute([$f_ID, $Title, $Desc,$Release_year,$Lang_id,$O_Lang, $Ren, $Rent_Rate,$Leng, $Rep, $Last_update,$_GET['staff_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM staff WHERE staff_id = ?');
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
	<h2>Update Staff #<?=$A['staff_id']?></h2>
    <form action="update_staff.php?staff_id=<?=$A['staff_id']?>" method="post">
    <label for="staff_id">staff_ID</label>
        <label for="first_name">First_Name</label>
        <input type="text" name="staff_id" value=<?=$A['staff_id']?> id="staff_id">
        <input type="text" name="first_name" value=<?=$A['first_name']?> id="first_name">
        <label for="last_name">Last_Name</label>
        <label for="address_id">Address_id</label>
        <input type="text" name="last_name" value=<?=$A['last_name']?> id="last_name">
        <input type="text" name="address_id" value=<?=$A['address_id']?> id="address_id">
        <label for="picture">Picture</label>
        <label for="email">Email</label>
        <input type="text" name="picture" value= <?=$A['picture']?> id="picture">
        <input type="text" name="email" value= <?=$A['email']?> id="email">
        <label for="active">Active</label>
        <label for="username">Username</label>
        <input type="text" name="active" value= <?=$A['active']?> id="active">
        <input type="text" name="username"value= <?=$A['username']?> id="username">
        <label for="password">Password</label>
        <label for="last_update">Last_Update</label>
        <input type="text" name="password" value=<?=$A['password']?> id="password">
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($A['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>