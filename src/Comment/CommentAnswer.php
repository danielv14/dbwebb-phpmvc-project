<?php



namespace Anax\Comment;

/**
 * Model for Comment to Comment connection.
 *
 */
class CommentAnswer extends \Anax\MVC\CDatabaseModel {

	/* Delete a discussion */
	public function delete($id) {
	    $this->db->delete(
	        $this->getSource(),
	        'idQuestion = ?'
	    );
	 
	    return $this->db->execute([$id]);
	}

	/* Save object */
	public function save($values = []) {
	    return $this->create($values);
	}

	/* Get answers tied to discussions */
	public function find($id) {
	    $this->db->select('idAnswer')
	             ->from($this->getSource())
	             ->where('idQuestion = ?');
	 
	    $this->db->execute([$id]);
	    $this->db->setFetchModeClass(__CLASS__);
	    return $this->db->fetchAll();
	}

	/* Is it an answer? */
	public function isAnswer($id) {
	    $this->db->select('*')
	             ->from($this->getSource())
	             ->where('idAnswer = ?')
	    ;
	 
	    $this->db->execute([$id]);
	    $this->db->setFetchModeClass(__CLASS__);
	    $res = $this->db->fetchAll();

    	if ($res != null) { 
    		return true; 
    	} else { 
    		return false;
    	}
	}

	/* Get all answers tied to discussion */
	public function numberAnswers($id) {
	    $this->db->select('idQuestion, count(*) AS answers')
	             ->from($this->getSource())
	             ->where('idQuestion = ?')
	    ;
	 
	    $this->db->execute([$id]);
	    $this->db->setFetchModeClass(__CLASS__);
	    return $this->db->fetchAll();
	}


}