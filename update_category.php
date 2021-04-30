<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['category_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $category = isset($_POST['category_id']) ? $_POST['category_id'] : NULL;
        $Name = isset($_POST['name']) ? $_POST['name'] : '';
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE category SET category_id = ?, name = ?, last_update = ? WHERE category_id = ?');
        $stmt->execute([$category, $Name, $Last_update,$_GET['category_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM category WHERE category_id = ?');
    $stmt->execute([$_GET['category_id']]);
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
	<h2>Update category #<?=$Cat['category_id']?></h2>
    <form action="update_category.php?category_id=<?=$Cat['category_id']?>" method="post">
        <label for="category_id">category_id</label>
        <label for="name">Name</label>
        <input type="text" name="category_id" placeholder="1" value="<?=$Cat['category_id']?>" id="category_id">
        <input type="text" name="name" value="<?=$Cat['name']?>" id="name">
        <label for="last_update">Last_update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($Cat['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>