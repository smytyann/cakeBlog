<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form');//public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');//public $components = array('Auth','Session');
	
	public function index() {// Finding all the records in the Post table and handing the resulting 
        $this->set('posts', $this->Post->find('all'));
    }
    
	public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
    }
	//This function will allow us to add to the post datasabe
  /*  public function add() {// LET ME ADD NEW POST
        if ($this->request->is('post')) { //Checking if this is a HTTP POST request//Request an Object
           	   $this->Post->create();//Initialising the Post Model//Making sure the POST MODEL IS READY
				//Added this line
				//$this->request->data['Post']['user_id'] = $this->Auth->user('id');
		   if ($this->Post->save($this->request->data)) { //Handing the request object data to be save by the post model
                $this->Session->setFlash(__('Your post has been saved.'));//Displaying an Success confirmation msg 
                return $this->redirect(array('action' => 'index'));//Redirecting to the Postes index action
            }
            $this->Session->setFlash(__('Unable to add your post.'));//Flash a message saying we werent able to do it
        }
    }*/
	public function add() {
		if ($this->request->is('post')) {
			//Added this line
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
			  $this->Post->create();
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('Your post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			 //flash message saying we weren't able to do it. // 
            $this->Session->setFlash(__('Unable to add your post.'));
		}
	}			
	public function edit($id = null) {//Function will allow us to edit an existing post
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}

		$post = $this->Post->findById($id);// go and find my post by ID
		if (!$post) {
			throw new NotFoundException(__('Invalid post'));//If cant find Throw a erro
		}

		if ($this->request->is(array('post', 'put'))) {// HTTP post and HTTP put
				$this->Post->id = $id;//
			if ($this->Post->save($this->request->data)) {//
					$this->Session->setFlash(__('Your post has been updated.'));
					return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update your post.'));
                }

                if (!$this->request->data) {  $this->request->data = $post;
                }
        }

	public function delete($id) {//Function will allow us to Delete a exist post, we will get the ID to be deleted	
		if ($this->request->is('get')) {//if the request come from the URL Do not allow it HTTP GET
			throw new MethodNotAllowedException();//Break 
		}

		if ($this->Post->delete($id)) {//If this is sucess , Display a msg 
			$this->Session->setFlash(
				__('The post with id: %s has been deleted.', h($id))// Special character , is sanitizing our ID HTML special Characters
			);
			return $this->redirect(array('action' => 'index'));// When is done , redirect to INDEX
		}
	}

	public function isAuthorized($user) {//Adding the isAuthorized function it will allow authors
										//to create posts but prevent the edition of posts if the author does not match. 
		// All registered users can add posts
		if ($this->action === 'add') {
			return true;
		}

		// The owner of a post can edit and delete it
		if (in_array($this->action, array('edit', 'delete'))) {
			$postId = $this->request->params['pass'][0];
			if ($this->Post->isOwnedBy($postId, $user['id'])) {
				return true;
			}
		}

		return parent::isAuthorized($user);
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			}
			$this->Session->setFlash(__('Invalid username or password, try again'));
		}
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}
	
}
?>