<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Actor_id = isset($_POST['actor_id']) && !empty($_POST['actor_id']) && $_POST['actor_id'] != 'auto' ? $_POST['actor_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $First_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $Last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO actor VALUES (?, ?, ?, ?)');
    $stmt->execute([$Actor_id, $First_name, $Last_name, $Last_update]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Contact</h2>
    <form action="create_actor.php" method="post">
        <label for="actor_id">Actor_ID</label>
        <label for="first_name">First_Name</label>
        <input type="text" name="actor_id" placeholder="1" value="auto" id="actor_id">
        <input type="text" name="first_name" placeholder="John Doe" id="first_name">
        <label for="last_name">Last_Name</label>
        <input type="text" name="last_name" placeholder="khalil" id="last_name">
        <label for="last_update">Last_Update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i')?>" id="last_update">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>