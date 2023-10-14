<?php

$file = 'votes.txt';

$votes = ['Candidate1' => 0, 'Candidate2' => 0, 'Candidate3' => 0];
if (file_exists($file)) {
    $votes = unserialize(file_get_contents($file));
}
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_candidate = $_POST['candidate'];

    if (isset($votes[$selected_candidate])) {
        $votes[$selected_candidate]++;
        file_put_contents($file, serialize($votes));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voting System</title>
    <style>
        .bar {
            height: 30px;
            background-color: green;
            text-align: center;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<form action="" method="post">
    <?php foreach ($votes as $candidate => $vote): ?>
        <input type="radio" name="candidate" value="<?= htmlspecialchars($candidate) ?>" required> <?= htmlspecialchars($candidate) ?> <br>
    <?php endforeach; ?>
    <button type="submit">Vote</button>
</form>

<h2>Results</h2>
<?php
$totalVotes = array_sum($votes);
foreach ($votes as $candidate => $vote):
    $percentage = ($totalVotes > 0) ? ($vote / $totalVotes) * 100 : 0;
    ?>
    <div>
        <?= htmlspecialchars($candidate) ?>:
        <div class="bar" style="width: <?= $percentage ?>%">
            <?= $vote ?>
        </div>
    </div>
<?php endforeach; ?>
</body>
</html>