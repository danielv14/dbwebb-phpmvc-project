<?php

namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware {
	
	use \Anax\DI\TInjectable;

	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize() {
	    $this->users = new \Anax\Users\User();
	    $this->users->setDI($this->di);
	    $this->users->setTablePrefix('breakingstack_');
	    date_default_timezone_set('Europe/London');
	}

	/**
	 * List all users.
	 *
	 * @return void
	 */
	public function listAction() {
	    $all = $this->users->findAll();
	 
	    $this->theme->setTitle("List all users");
	    $this->views->add('users/list-all', [
	    	
	        'users' => $all,
	        'title' => "All users on the site",
	    ]);
	    $this->views->add('theme/page', [
        'content'=> '<p>Click on any user to display all the topics created by the user, as well as individual responses by the user. </p>',
        ]);  
	}

	/**
	 * List user with id.
	 *
	 * @param int $id of user to display
	 *
	 * @return void
	 */
	public function idAction($id = null) {
	    $user = $this->users->find($id);
	 
	    $this->theme->setTitle("Profile");
	    $this->views->add('users/profile', [
	        'user' => $user,
	    ]);
	}

	


	/**
	 * Add new user.
	 *
	 * @param string $acronym of user to add.
	 *
	 * @return void
	 */
	public function addAction($acronym = null) {
	    
	    if (!isset($acronym)) {
            $form = $this->form->create([], [
			    'acronym' => [
			      'type'        => 'text',
			      'label'       => 'Acronym: ',
			      'placeholder' => 'Enter username',
			      'required'    => true,
			      'validation'  => ['not_empty'],
			    ],
			    'submit' => [
			        'type'      => 'submit',
			        'callback'  => function($form) {
			            $form->AddOutput("<p><i>Form submitted.</i><p>");
			            $form->AddOutput("<p>Welcome! " . $form->Value('acronym') . "</strong> has been added. Login by enter the name both as acrynom and password.</p>");
			            $form->saveInSession = true;
			            return true;
			        }
			    ],
			]);

			// Prepare the page content
			$this->views->add('users/view-default', [
		        'title' => "Add a new user",
		        'main' => $form->getHTML(),
		    ]);
			$this->theme->setVariable('title', "Add new user");

			// Check the status of the form
			$status = $form->check();
			 
			if ($status === true) {

			    // Get data from and and unset the session variable
		        $acronym = $_SESSION['form-save']['acronym']['value'];
				unset($_SESSION['form-save']);

				// Route to prefered controller function
		        $url = $this->url->create('users/add/' . $acronym);
		        $this->response->redirect($url);
			 
			} else if ($status === false) {	 

			    // What to do when form could not be processed?
			    $form->AddOutput("<p><i>Form submitted but did not checkout.</i></p>");

			}
		};

	    // Create and display new user if acronym is present. 
	    if (isset($acronym)) {  	   
				$now = date("Y-m-d H:i:s");		   
				$this->users->save([
		        'acronym' => $acronym,
		        'email' => $acronym . '@gmail.com',
		        'gravatar' => getGravatar('', 65),
		        'name' =>  $acronym,
		        'password' => password_hash($acronym, PASSWORD_DEFAULT),
		        'created' => $now,
		        'active' => $now,
		    ]);
		    $url = $this->url->create('../index.php');
	    	$this->response->redirect($url);
		}	 
	}

	/**
	 * Update user.
	 *
	 * @param integer $id of user to update.
	 *
	 * @return void
	 */
	public function updateAction($id = null) {	    
	    if (!isset($id)) {
            die("Missing id");
        }

        if ($this->isActiveUser($id) == null) {
        	die("You can only edit your own details.");
        }

        $user = $this->users->find($id);

	    $form = $this->form->create([], [
		    'acronym' => [
		      'type'        => 'text',
		      'label'       => 'Acronym: ',
		      'required'    => true,
		      'validation'  => ['not_empty'],
		      'value'		=> $user->acronym,
		    ],
		    'name' => [
		      'type'        => 'text',
		      'label'       => 'Name: ',
		      'required'    => true,
		      'validation'  => ['not_empty'],
		      'value'		=> $user->name,
		    ],
		    'email' => [
		      'type'        => 'text',
		      'label'       => 'Email: ',
		      'required'    => true,
		      'validation'  => ['not_empty', 'email_adress'],
		      'value'		=> $user->email,
		    ],
		    'submit' => [
		        'type'      => 'submit',
		        'callback'  => function($form) {
		            $form->saveInSession = true;
		            return true;
		        }
		    ],
		]);

		// Check the status of the form
		$status = $form->check();
		 
		if ($status === true) {

		    // Collect data and unset the session variable
		    $updated_user['id'] = $id;
	        $updated_user['acronym'] = $_SESSION['form-save']['acronym']['value'];
	        $updated_user['name'] = $_SESSION['form-save']['name']['value'];
	        $updated_user['email'] = $_SESSION['form-save']['email']['value'];
	        $updated_user['gravatar'] = getGravatar($updated_user['email'], 65);
			unset($_SESSION['form-save']);

			// Save updated user data
	        $res = $this->users->save($updated_user);	      
	        if($res) { 
	        	$url = $this->url->create('users/id/' . $id);
	    		$this->response->redirect($url);
	        }
		 
		} else if ($status === false) {	 

		    // What to do when form could not be processed?
		    $form->AddOutput("<p><i>Form submitted but did not checkout.</i></p>");

		}

		// Prepare the page content
		$this->views->add('users/view-default', [
		    'title' => "Update user",
		    'main' => $form->getHTML(),
		]);
	}




/* Login */
	public function loginAction() {
	    
        $form = $this->form->create([], [
		    'acronym' => [
		      'type'        => 'text',
		      'placeholder' => 'Enter your acronym',
		    ],
		    'password' => [
		      'type'        => 'password',
		      'placeholder' => 'Enter your password',
		    ],
		    'login' => [
		        'type'      => 'submit',
		        'callback'  => function($form) {
		            $form->saveInSession = true;
		            return true;
		        }
		    ],
		]);

		// Check the status of the form
		$status = $form->check();
		 
		if ($status === true) {

		    // Get data from and and unset the session variable
	        $acronym = $_SESSION['form-save']['acronym']['value'];
	        $password = $_SESSION['form-save']['password']['value'];
			unset($_SESSION['form-save']);

			// Get user from database
			$dbres = $this->users->findAcronym($acronym);

			if ($dbres) {
				// Login the user
		        if ($acronym == $dbres->acronym && password_verify($password, $dbres->password)) {           
		            $form->AddOutput = "User logged in successfully.";
		            $_SESSION['authenticated']['valid'] = true;
		            $_SESSION['authenticated']['user'] = $dbres;

		            // Route to prefered controller function
	        		$url = $this->url->create('');
	        		$this->response->redirect($url);
		        } 

	    	} else {

		    	$form->AddOutput = "<p><i>Login not successful. Acronym or password might be invalid.</i></p>";
		        
		    }
		 
		} else if ($status === false) {	 

		    // What to do when form could not be processed?
		    $form->AddOutput("<p><i>Acronym or password invalid.</i></p>");

		}


		// Prepare the page content
		$this->views->add('users/view-login', [
	        'title' => "Login to enter site",
	        'main' => $form->getHTML(),
	    ]);
	    $this->views->add('theme/page', [
        'content'=> '<br/><p>If you dont want to create a user right now, just enter admin / admin </p>',
        ]);  

		$this->theme->setVariable('title', "Login user");
	 
	}


	/* Logout */
	public function logoutAction() {
		unset($_SESSION['authenticated']);
		$url = $this->url->create('');
	    $this->response->redirect($url);
		return 'User logged out.';
	}


	/* Is user id logged in */
	private function isActiveUser($id) {
        if ($_SESSION['authenticated']['user']->id == $id) {
            return true;
        } else {
        	return false;
        }       
    }

 
}