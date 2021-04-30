<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['staff_id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM staff WHERE staff_id = ?');
    $stmt->execute([$_GET['staff_id']]);
    $CA = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$CA) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM staff WHERE staff_id = ?');
            $stmt->execute([$_GET['staff_id']]);
            $msg = 'You have deleted the contact!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read_staff.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Record #<?=$CA['staff_id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete the record #<?=$CA['staff_id']?>?</p>
    <div class="yesno">
        <a href="delete_staff.php?staff_id=<?=$CA['staff_id']?>&confirm=yes">Yes</a>
        <a href="delete_staff.php?staff_id=<?=$CA['staff_id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>