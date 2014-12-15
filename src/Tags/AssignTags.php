<?php


namespace Anax\Tags;

class AssignTags extends \Anax\MVC\CDatabaseModel {

	/* Delete row */
	public function delete($id) {
	    $this->db->delete(
	        $this->getSource(),
	        'idComment = ?'
	    );
	 
	    return $this->db->execute([$id]);
	}

	/* Get tag name */
	public function getTagName($id) {

	    $this->db->select('name')
            ->from('tags')
            ->where('id = ?')
        ;
	 
	    $this->db->execute([$id]);
	    return $this->db->fetchOne();
	}

	
	/* Save Current */
	public function save($values = []) {
	    return $this->create($values);
	}


	/* Return matching id and tag */
	public function find($id) {
	    $this->db->select('idTag')
	             ->from('assigntags')
	             ->where('idComment = ?');
	 
	    $this->db->execute([$id]);
	    $this->db->setFetchModeClass(__CLASS__);
	    return $this->db->fetchAll();
	}

	

	
	/* Get all tags */
	public function findAllTags() {

	    $this->db->select('id, name')
            ->from('tags')
        ;
	 
	    $this->db->execute();
	    $this->db->setFetchModeClass(__CLASS__);
	    return $this->db->fetchAll();
	}

    /* Get tags in use */
	public function findTags() {

	    $this->db->select('DISTINCT T.name')
            ->from('tags AS T')
            ->join('assigntags AS C2T', 'T.id = C2T.idTag')
        ;
	 
	    $this->db->execute();
	    $this->db->setFetchModeClass(__CLASS__);
	    return $this->db->fetchAll();
	}


}