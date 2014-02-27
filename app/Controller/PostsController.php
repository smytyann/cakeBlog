<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
	// Finding all the records in the Post table and handing the resulting 
    public function index() {
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
    public function add() {// LET ME ADD NEW POST
        if ($this->request->is('post')) { //Checking if this is a HTTP POST request//Request an Object
            $this->Post->create();//Initialising the Post Model//Making sure the POST MODEL IS READY
            if ($this->Post->save($this->request->data)) { //Handing the request object data to be save by the post model
                $this->Session->setFlash(__('Your post has been saved.'));//Displaying an Success confirmation msg 
                return $this->redirect(array('action' => 'index'));//Redirecting to the Postes index action
            }
            $this->Session->setFlash(__('Unable to add your post.'));//Flash a message saying we werent able to do it
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

    if (!$this->request->data) {
        $this->request->data = $post;
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
}
?>