<?php
class HomesController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');

/*	public function beforeFilter() {
		parent::beforeFilter();
		// Allow users to register and logout.
		$this->Auth->allow('add', 'logout','login');
	}
	
/*	public function isAuthorized($user) {
			if ($user['role'] == 'admin') {
				return true;
			}
			if (in_array($this->action, array('edit', 'delete'))) {
				if ($user['id'] != $this->request->params['pass'][0]) {
					return false;
				}
			}
			return true;
		}*/

	public function login() {
    	if ($this->request->is('post')) {
        debug($this->Auth->login());	
            if ($this->Auth->login()) {
				
            	return $this->redirect($this->Auth->redirectUrl());
        	}
        $this->Session->setFlash(__('Invalid username or password, try again'));
    	}
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}
	
   /*     public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->User->find('all')); // $this->set('users', $this->paginate());
    }*/
        public function index() {
            
            
        }

   /*     public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if (!$id) {
			$this->Session->setFlash('Invalid user');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read());
	}

        public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.')
            );
        }
    }

        public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

        public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }
        public function isAuthorized($user){
                if(in_array($this->action, array('add'))){
                        return true;
                }
                if(in_array($this->action, array('view', 'edit', 'delete'))){
                        $userId = $this->request->params['pass'][0];
                        if($this->Auth->user('id')=== $userId){
                               return true;
                        }
                        else{
                        $this->Session->setFlash(__('Sorry only Admin users may modify , view or delete other users'));	
                        }
                }
                return parent::isAuthorized($user);
            }
   /* public function isAuthorized($user) {
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
}*/
    
}
/** 
public function isAuthorized($user) {
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
} */

?>
