<?php

//エスケープ処理
function h($s)
{
	return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

$fileName = "bbs.dat";

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	// var_dump($_POST);
	$title = $_POST['title'];
	$impression = $_POST['impression'];
	$name = $_POST['name'];

	//バリデーション
	if ($title != '' && $impression != '')
	{
		if ($name == '')
		{
			$name = '名無し';
		}

		$createdAt = date('Y-m-d H:i:s');
		$data = $title . "\t" . $impression . "\t" . $name . "\t" . $createdAt . "\n";

		$fp = fopen($fileName, "a");
		fwrite($fp, $data);
		fclose($fp);

	}
}

$posts = file($fileName, FILE_IGNORE_NEW_LINES); //FILE_IGNORE_NEW_LINESで$dataの"\n"を削る
// var_dump($posts);
$posts = array_reverse($posts); //取得したデータを逆に表示する
// var_dump($posts);

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>映画の感想</title>
	</head>
	<body>
		<h1>映画の感想掲示板</h1>
		<form action="" method="post">
			タイトル:<input type="text" name="title">
			感想:<input type="text" name="impression">
			名前:<input type="text" name="name">
			<input type="submit" value="感想を投稿">
		</form>
		<h3>現在の投稿は<?php echo count($posts); ?>件</h3>
		<?php if (count($posts)) : ?>
			<?php foreach ($posts as $post) : ?>
				 <!-- $post = "タイトル  感想  名前  2015-04-14 22:31:54" -->
				<?php list($title, $impression, $name, $createdAt) = explode("\t", $post); ?>
				<li>
					[<?php echo h($title); ?>]「<?php echo h($impression); ?>」
					(<?php echo h($name); ?>) - <?php echo h($createdAt); ?>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</body>
</html>
