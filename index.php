<?php
session_start();
$id = session_id();

if ($id!="") {
$CurrentTime = time();
$LastTime = time() - 3600;
$base = "session.txt";
$file = file($base);
$k = 0;

    for ($i = 0; $i < sizeof($file); $i++) {
    $line = explode("|", $file[$i]);
    if ($line[1] > $LastTime) {
    $ResFile[$k] = $file[$i];
    $k++;
    }
    }

  for ($i = 0; $i<sizeof($ResFile); $i++) {
  $line = explode("|", $ResFile[$i]);
  if ($line[0]==$id) {
      $line[1] = trim($CurrentTime);
      $is_sid_in_file = 1;
  }
  $line = implode("|", $line); $ResFile[$i] = $line;
 }

    $fp = fopen($base, "w");
    for ($i = 0; $i<sizeof($ResFile); $i++) { 
        fputs($fp, $ResFile[$i]); 
    }
    fclose($fp);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Online</title>
</head>
<body>
    <?php
    if (!$is_sid_in_file) {
        $fp = fopen($base, "a-");
        $line = $id."|".$CurrentTime."\n";
        fputs($fp, $line);
            fclose($fp);
    }echo "<div>Онлайн: <h4>".sizeof(file($base))."</h4></div>";
}
    ?>
</body>
</html>