<?php

namespace Anax\Comment;


class Comment extends \Anax\MVC\CDatabaseModel {

	
	/* Fetch all user ID's */ 
	public function findByUser($id) {
	    $this->db->select('*')
	             ->from($this->getSource())
	             ->where("userId = ?");
	 
	    $this->db->execute([$id]);
	    return $this->db->fetchAll();
	}

}