<?php

namespace Anax\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentDbController implements \Anax\DI\IInjectionAware {

    use \Anax\DI\TInjectable;

  /* init controllers */
      public function initialize() {

        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
        $this->users->setTablePrefix('breakingstack_');

        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);
        $this->comments->setTablePrefix('breakingstack_');

        $this->tags = new \Anax\Tags\AssignTags();
        $this->tags->setDI($this->di);
        $this->tags->setTablePrefix('breakingstack_');

        $this->assignTags = new \Anax\Tags\AssignTags();
        $this->assignTags->setDI($this->di);
        $this->assignTags->setTablePrefix('breakingstack_');

        $this->commentanswer = new \Anax\Comment\CommentAnswer();
        $this->commentanswer->setDI($this->di);
        $this->commentanswer->setTablePrefix('breakingstack_');

        
    }

    /**
     * View all comments.
     */
    public function viewAction() {
        $all = $this->comments->findAll();

        $all = $this->Tags2String($all);
        $all = $this->addUserData($all);
        $all = $this->filterMarkdown($all);

        $this->views->add('comment/commentsdb', [
            'comments' => $all,
        ]);
    }

    /**
     * View answers related to the original topic
     */
    public function viewQuestionsAction() {
        $all = $this->comments->findAll();

        $res = [];
        foreach ($all as $value) {
            if ($this->commentanswer->isAnswer($value->id) == null) {
                $res[] = $value;
            }
        }

        $res = $this->Tags2String($res);
        $res = $this->addUserData($res);
        $res = $this->filterMarkdown($res);

        $this->views->add('comment/commentsdb', [
            'comments' => $res,
            'title' => 'Browse discussions',
        ]);
    }

    /**
     * Top 4 tags, users, and newest topics
     *
     * @return void
     */
    public function viewTopFourAction() {

        $this->db->select('*')
            ->from("comment WHERE title NOT LIKE '%Reply%' ORDER BY timestamp DESC LIMIT 4");
        $top_new = $this->db->executeFetchAll();

         $this->db->select('*')
            ->from("comment WHERE title NOT LIKE '%Reply%' ORDER BY timestamp ASC LIMIT 4");
        $top_old = $this->db->executeFetchAll();

        $this->db->select('idTag, COUNT(idTag) as tc')
            ->from('assigntags GROUP BY idTag ORDER BY tc DESC LIMIT 4');
        $top_tags = $this->db->executeFetchAll();
        foreach ($top_tags as $value) {
            $value->tag = $this->assignTags->getTagName($value->idTag)->name;
        }

        $this->db->select('userId, COUNT(userId) as uc')
            ->from('comment GROUP BY userId ORDER BY uc DESC LIMIT 4');
        $top_users = $this->db->executeFetchAll();
        foreach ($top_users as $value) {
            $value->name = $this->users->find($value->userId)->name;
        }

        $this->views->add('comment/topfour', [
            'new' => $top_new,
            'tags' => $top_tags,
            'users' => $top_users,
            'old' => $top_old,
            'title' => 'stats',
        ]);

    }

    /**
     * Get commets by id of the user
     */
    public function viewByUserAction($userId) {
        $res = $this->comments->findByUser($userId);

        $res = $this->Tags2String($res);
        $res = $this->addUserData($res);
        $res = $this->filterMarkdown($res);

        $user = isset($res[0]->name) ? $res[0]->name : null;

        $this->views->add('comment/commentsdb', [
            'comments' => $res,
            'title' => 'Contribution by ' . $user,
        ]);
    }

    /**
     * get linked answers to comment id
     */
    public function answersAction($id) {
        $all_id = $this->commentanswer->find($id);

        $all = [];
        foreach ($all_id as $key => $value) {
            $all[] = $this->comments->find($value->idAnswer);
        }

        $all = $this->Tags2String($all);
        $all = $this->addUserData($all);
        $all = $this->filterMarkdown($all);

        $question[0] = $this->comments->find($id);
        $question = $this->Tags2String($question);
        $question = $this->addUserData($question);
        $question = $this->filterMarkdown($question);

        $this->views->add('comment/commentsdb', [
            'question' => $question,
            'comments' => $all,
            'title' => 'Question',
        ]);
    }

    /**
     * Markdown
     */
    private function filterMarkdown($all) {
        foreach ($all as $value) {

            $value->comment = $this->textFilter->doFilter($value->comment, 'shortcode, markdown');

        }
        return $all;
    }

    /**
     * Add Tag string array to a comment object.
     *
     */
    private function Tags2String($all) {
        foreach ($all as $value) {

            $tag_names = [];

            foreach ($this->assignTags->find($value->id) as $inner_value) {
                $tag_names[] = $this->assignTags->getTagName($inner_value->idTag)->name;
            }

            $value->tags = $tag_names;

        }
        return $all;
    }

    /**
     * apply data to comment objects
     */
    private function addUserData($all) {

        foreach ($all as $value) {

            $user_data = $this->users->find($value->userId);
            $value->name = $user_data->name;
            $value->mail = $user_data->email;
            $value->gravatar = $user_data->gravatar;

        }
        return $all;
    }

    /**
     * Display tags that are active
     */
    public function tagsAction() {
        $res = $this->tags->findTags();

        $this->views->add('comment/tags', [
            'tags' => $res,
            'title' => 'The following tags are used in discussions',
        ]);
        $this->views->add('theme/page', [
        'content'=> '<br/><p>The tags above are used in conversations on Breaking Stack. You can click one of the tags to
        get a filtered view with only topics related to said tag. To create a new topic and assign tags, please select "Add topic" in the dropdown menu related to Discussion. </p>',
        ]);  
    }

   

    /**
     * Get all comments tied to a tag
     */
    public function tagCommentsAction($name = null) {

        $this->db->select('C.*, T.name AS tag')
            ->from('comment AS C')
            ->leftOuterJoin('assigntags AS C2T', 'C.id = C2T.idComment')
            ->leftOuterJoin('tags AS T', 'C2T.idTag = T.id')
            ->where('T.name = "' . $name . '"')
        ;

        $res = $this->db->executeFetchAll();

        $res = $this->Tags2String($res);
        $res = $this->addUserData($res);
        $res = $this->filterMarkdown($res);

        $this->views->add('comment/commentsdb', [
            'comments' => $res,
            'title' => $this->theme->getVariable('title'),
        ]);
    }

    
    /**
     * Add a comment
     */
    public function addAction($id = null, $idFromQuestion = null) {

        if ($id == 'null') { $id = null; }
        $edit_comment = (object) [
            'tags' => '',
            'comment' => '',
            'title' => '',
        ];

        // Get relevant data if edit "is on the table"
        if ($id) {
            $edit_comment = $this->comments->find($id);

            // Authenticate edit
            if ($edit_comment->userId != $_SESSION['authenticated']['user']->id) {
                die("Can only");
            }

            foreach ($this->assignTags->find($id) as $key => $value) {
                $edit_comment->tags[] = $this->assignTags->getTagName($value->idTag)->name;
            }
        }

        // Convert tags db result to simple array
        $tags_array = [];
        foreach ($this->tags->findAllTags() as $key => $value) {
            $tags_array[$value->id] = $value->name;
        }

        $form_setup = [
            'comment' => [
              'type'        => 'textarea',
              'label'       => 'Comment: ',
              'required'    => true,
              'validation'  => ['not_empty'],
              'value'       => $edit_comment->comment,
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => function($form) {
                    $form->saveInSession = true;
                    return true;
                }
            ],
        ];

        $is_answer = $this->commentanswer->isAnswer($id);

        if( !isset($idFromQuestion) && ($is_answer == null) ) {
            
 $form_setup_add['title'] = [
              'type'        => 'text',
              'required'    => true,
              'validation'  => ['not_empty'],
              'value'       => $edit_comment->title,
            ];
            $form_setup_add['tags'] = [
              'type'        => 'checkbox-multiple',
              'values'      => $tags_array,
              'label'       => 'Available tags: ',
              'required'    => true,
              'checked'     => $edit_comment->tags,
            ];
           

            $form_setup = $form_setup_add + $form_setup;
        }

        // Create form
        $form = $this->form->create([], $form_setup );

        // Check the status of the form
        $status = $form->check();

        if(!isset($idFromQuestion) && !isset($_SESSION['form-save']['tags']['values'])) {
            $status = false;
            
        }
         
        if ($status === true) {

            // Get data from and and unset the session variable
            $comment['id']          = isset($id) ? $id : null;
            $comment['comment']     = $_SESSION['form-save']['comment']['value'];
            $comment['userId']      = $_SESSION['authenticated']['user']->id;
            $comment['timestamp']   = time();
            $comment['ip']          = $this->request->getServer('REMOTE_ADDR');
            $comment['title']       = !isset($idFromQuestion) ? $_SESSION['form-save']['title']['value'] : 'Reply: ' . $this->comments->find($idFromQuestion)->title;
            $tags                   = !isset($idFromQuestion) ? $_SESSION['form-save']['tags']['values'] : null;

            unset($_SESSION['form-save']);

            // Update or save comment.
            $this->comments->save($comment);
            $row['idComment'] = isset($id) ? $id : $this->comments->findLastInsert();

            // Update or save tags
            if (!isset($idFromQuestion)) {
                if(isset($id)) {
                    $this->assignTags->delete($id);
                }
                foreach ($tags as $key => $value) {
                    $row['idTag'] = array_search($value, $tags_array);
                    $this->assignTags->save($row);
                }
            }

            // Update or save questions to answers
            if ($idFromQuestion) {
                $data = [
                    'idQuestion' => $idFromQuestion,
                    'idAnswer' => $row['idComment'],
                ];
                $this->commentanswer->save($data);

                $url = $this->url->create('comment/answers/' . $idFromQuestion);

            } else {

                $url = $this->url->create('comment/view-questions');

            }

            // Route to prefered controller function
            $this->response->redirect($url);
         
        } else if ($status === false) {  

            // What to do when form could not be processed?
            $form->AddOutput("<p><i>Form submitted but did not checkout.</i></p>");
        }

        // Prepare the page content
        $this->views->add('comment/view-default', [
            'title' => "Join the discussions",
            'main' => $form->getHTML(),
        ]);
        $this->theme->setVariable('title', "Add Comment");

    }


    public function removeIdAction($id = null) {
        if (!isset($id)) {
            die("Missing id");
        }

        // Authenticate deletion
        $comment = $this->comments->find($id);
        if ($comment->userId != $_SESSION['authenticated']['user']->id) {
            die("You can only edit your own posts.");
        }

        $this->comments->delete($id);
        $this->assignTags->delete($id);
        $this->commentanswer->delete($id);

        $url = $this->url->create('comment/view-questions');
        $this->response->redirect($url);
    }

}
