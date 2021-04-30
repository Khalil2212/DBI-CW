<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['actor_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $Actor_id = isset($_POST['actor_id']) ? $_POST['actor_id'] : NULL;
        $First_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $Last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE actor SET actor_id = ?, first_name = ?, last_name = ?, last_update = ? WHERE actor_id = ?');
        $stmt->execute([$Actor_id, $First_name, $Last_name, $Last_update,$_GET['actor_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM actor WHERE actor_id = ?');
    $stmt->execute([$_GET['actor_id']]);
    $Actor = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$Actor) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Actor #<?=$Actor['actor_id']?></h2>
    <form action="update.php?actor_id=<?=$Actor['actor_id']?>" method="post">
        <label for="actor_id">Actor_ID</label>
        <label for="first_name">First_Name</label>
        <input type="text" name="actor_id" placeholder="1" value="<?=$Actor['actor_id']?>" id="actor_id">
        <input type="text" name="first_name" placeholder="John" value="<?=$Actor['first_name']?>" id="first_name">
        <label for="last_name">Last_Name</label>
        <label for="last_update">Last_update</label>
        <input type="text" name="last_name" placeholder="Khalil" value="<?=$Actor['last_name']?>" id="last_name">
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($Actor['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>