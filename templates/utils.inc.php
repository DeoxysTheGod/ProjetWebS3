<?php
function start_page($title, $stylesheet='styles'): void
{
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?php echo $stylesheet;?>.css">
	<title><?php echo $title; ?></title>
</head>
<body>
<?php
	}
?>

<?php
	function end_page(): void
	{
?></body>
</html>
<?php
	}
?>