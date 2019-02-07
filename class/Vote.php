<?php 


/**
 * @package
**/

class Vote
{
        /**
         * @var \PDO
        **/
        private $pdo;
        
        /**
         * vote precedent
         * @var string
        **/
        private $former_vote;


        /**
         * @param \PDO $pdo
        **/
        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        /**
         * Verifie si le record est valid 
         * Si oui alors il retoure l'operation, 
         * Si non il envoit une Exception d'erreur
         * @param string $ref
         * @param string $ref_id
         * @return bool
         * @throws \Exception
        **/

        private function recordExists($ref, $ref_id)
        {
            $req = $this->pdo->prepare("SELECT * FROM $ref WHERE id = ?");
	    	$req->execute([$ref_id]);

	    	if($req->rowCount() == 0)
	    	{
	    		  throw new Exception("Impossible de voter pour un enregistrement qui n'existe pas");
	    	}
        }


        /**
         * @param string $ref
         * @param string $ref_id
         * @param string $user_id
         * 1 pour like
        **/
	    public function like($ref, $ref_id, $user_id)
	    { 
	    	if($this->vote($ref, $ref_id, $user_id, 1))
	    	{
	    		$sql_part = "";

	    		if($this->former_vote)
	    		{
	    			$sql_part = ", dislike_count = dislike_count -1";
	    		}

	    		$this->pdo->query("UPDATE $ref SET like_count = like_count + 1 $sql_part  WHERE id = $ref_id");

                return true;

	    	}else{

                $this->pdo->query("UPDATE $ref SET like_count = like_count - 1  WHERE id = $ref_id");
            }

            return false;
	    }
        
        /**
         * @param string $ref
         * @param int $ref_id
         * @param int $user_id
         * -1 pour dislike
        **/
	    public function dislike($ref, $ref_id, $user_id)
	    { 
	    	if($this->vote($ref, $ref_id, $user_id, -1))
	    	{
	    		$sql_part = "";

	    		if($this->former_vote)
	    		{
	    			$sql_part = ", like_count = like_count -1";
	    		}

	    		$this->pdo->query("UPDATE $ref SET dislike_count = dislike_count + 1  $sql_part  WHERE id = $ref_id");

                return true;

	    	}else{
                  
                $this->pdo->query("UPDATE $ref SET dislike_count = dislike_count - 1  WHERE id = $ref_id");

            }

            return false;
	    }

        /**
         * @param string $ref
         * @param int $ref_id
         * @param int $user_id
         * @param int $vote [1/-1]
        **/
        private function vote($ref, $ref_id, $user_id, $vote)
        {

	    	$this->recordExists($ref, $ref_id);
	    	$req = $this->pdo->prepare("SELECT id, vote FROM votes WHERE ref = ? AND ref_id = ? AND user_id = ?");
	    	$req->execute([$ref, $ref_id, $user_id]);
	    	$vote_row = $req->fetch();
           
            //> On verifit s'il y a eu vote alors on fait juste une mise ajour
            //> sur notre table
	    	if($vote_row)
	    	{
               if($vote_row->vote == $vote)
               {
                    $this->pdo->query('DELETE FROM votes WHERE id = ' . $vote_row->id);
               	    return false;
               }
               
               $this->former_vote = $vote_row;

               $this->pdo->prepare("UPDATE votes SET vote = ?, created_at = ? WHERE id = {$vote_row->id}")->execute([$vote, date('Y-m-d H:i:s')]);

               return true;
	    	
	        }

    		$req = $this->pdo->prepare("INSERT INTO votes SET ref = ?, ref_id = ?, user_id = ?, created_at = ?, vote = $vote");
    		$req->execute([
                $ref,
                $ref_id, 
                $user_id,
                date('Y-m-d H:i:s')
    		]);
    		return true;
        }


        public function updateCount($ref, $ref_id)
        {
        	  $req = $this->pdo->prepare("SELECT COUNT(id) as count, vote FROM votes WHERE ref = ? AND ref_id = ? GROUP BY vote");

        	  $req->execute([$ref, $ref_id]);

        	  $votes = $req->fetchAll();

        	   // debug($votes);

        	  $counts = [
                '-1' => 0,
                '1'  => 0
        	  ];
              
              // $vote->count, count est l'alias COUNT(id) 
        	  foreach($votes as $vote)
        	  {
    	  	   	   $counts[$vote->vote] = $vote->count;
        	  }

    	     // debug($counts);

        	  $req = $this->pdo->query("UPDATE $ref SET like_count = {$counts[1]}, dislike_count = {$counts[-1]} WHERE id = $ref_id");
        	  return true;
        }


        /**
         * Permet d'ajouter une class is-liked ou is-disliked suivant un enregistrement
         * @param $vote mixed false|PDORow
        **/
	    public static function getClass($vote) 
	    {
              if($vote)
              {
              	 return $vote->vote == 1 ? 'is-liked' : 'is-disliked';
              }

              return null;
	    }

}