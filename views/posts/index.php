<?php 

$req = $pdo->query('SELECT * FROM articles');
foreach($req->fetchAll() as $post):
?>

<article>
	 <h1><?= $post->title; ?></h1>
	 <p><?= $post->content; ?></p>
	 <p>
	 	<a href="?p=single&id=<?= $post->id; ?>">Lire la suite</a>
	 </p>
</article>
<?php endforeach; ?>
