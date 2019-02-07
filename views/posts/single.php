<?php 

$id = isset($_GET['id']) ? $_GET['id'] : null;


$vote = false;

if(isset($_SESSION['user_id']))
{
     $req = $pdo->prepare('SELECT * FROM votes WHERE ref = ? AND ref_id = ? AND user_id = ?');
     $req->execute([
        'articles', 
        $id, 
        $_SESSION['user_id']
     ]);

     $vote = $req->fetch();

     // dump($vote);
}



try 
{
	$req = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
    $req->execute([$id]);
    $post = $req->fetch();

    /**
    Juste un test
    $vote = new Vote($pdo);
    $vote->updateCount('articles', 3);
    **/

}catch(Exception $e){

	$e->getMessage();
}

$divider = $post->like_count + $post->dislike_count;
$status = ($divider == 0) ? 100 : round(100 * ($post->like_count / $divider));

?>

<article>
	 <h1><?= $post->title; ?></h1>
	 <p><?= $post->content; ?></p>
</article>


<div class="vote <?= Vote::getClass($vote); ?>" 
	 id="vote" 
	 data-ref="articles" 
	 data-ref_id="<?= $post->id; ?>"
	 data-user_id="<?= isset($_SESSION['user_id']) ? $_SESSION['user_id']: null; ?>">

	<div class="vote_bar">
		<div class="vote_progress" style="width:<?= $status; ?>%"></div>
	</div>
	<div class="vote_loading">
		Chargement ...
	</div>	
	<div class="vote_btns">
		 <button class="vote_btn vote_like">
	       	<i class="fa fa-thumbs-up">
	       		<span id="like_count"><?= $post->like_count; ?></span>
	       	</i>
	     </button>
		 <button class="vote_btn vote_dislike">
	        <i class="fa fa-thumbs-down">
	        	<span id="dislike_count"><?= $post->dislike_count; ?></span>
	        </i>
	     </button>
	</div>	
</div>
