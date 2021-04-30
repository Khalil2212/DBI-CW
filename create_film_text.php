<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Cat = isset($_POST['film_id']) && !empty($_POST['film_id']) && $_POST['film_id'] != 'auto' ? $_POST['film_id'] : NULL;
    // Check if POST variable "film_id" exists, if not default the value to blank, basically the same for all variables
    $Na = isset($_POST['title']) ? $_POST['title'] : '';
    $Last_update = isset($_POST['description']) ? $_POST['description'] :'';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO film_text VALUES (?, ?, ?)');
    $stmt->execute([$Cat, $Na, $Last_update]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Film_Text</h2>
    <form action="create_film_text.php" method="post">
        <label for="film_id">Film_Id</label>
        <label for="title">Title</label>
        <input type="text" name="film_id" id="film_id">
        <input type="text" name="title"value="auto" id="title">
        <label for="description">Description</label>
        <input type="text" name="description"value="auto" id="description">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>