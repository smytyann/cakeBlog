<?php
// app/Controller/UsersController.php
class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();// Before filter lives in the appController
        // Allow users to register and logout.
	   $this->Auth->allow('add', 'logout');//Auth is a class and Allow is a component in Cakephp is an allow method //we are allowing the USER to ADD functions//
		
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

    public function index() {
        $this->User->recursive = 0;//dont go to far when is doing  a each 
        $this->set('users', $this->paginate());//we are passing the data to the user view //this paginate is an methodo in the cakepho core file that will display the posts in a page
    }

    public function view($id = null) {
        $this->User->id = $id;//tell the Model to find the id that we are looking for 
        if (!$this->User->exists()) {// If the user does not exist , throw an erro
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));//Read and pass the data to the ID, is setting a back over//$this means the class name
		    }

    public function add() {
        if ($this->request->is('post')) {// Is a HTTP POST request , check to see if it comes from a form  
            $this->User->create();// this = class User = UserModel , and create is a method that clean and star new section 
            if ($this->User->saves($this->request->data)) {//request is Object , the request object holds all the data that the user has input and save to user in the database
                $this->Session->setFlash(__('The user has been saved'));//Message that will display to inform the user
                return $this->redirect(array('action' => 'index'));//redirect is a method that send the user to another page or any where we want
				//return $this->redirect(array(controller => post 'action' => 'index'))// redirect to the POST controller
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        }
    }

    public function edit($id = null) {//We are edit an single user
        $this->User->id = $id;//User here is the User model
        if (!$this->User->exists()) {//If User doesnot exist in the database throw an erro
            throw new NotFoundException(__('Invalid user'));// display erro
        }
        if ($this->request->is('post') || $this->request->is('put')) {//we are making sure is the HTTP request post or put
            if ($this->User->save($this->request->data)) {//save the data to the user
                $this->Session->setFlash(__('The user has been updated'));
                return $this->redirect(array('action' => 'index'));// redirection the the index function of the class
            }
            $this->Session->setFlash(// display erro msg
                __('The user could not be saved. Please, try again.')
            );
        } else {//
            $this->request->data = $this->User->read(null, $id);//Restrict what the data will be when is send back
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');//onlyAllow post HTTP requests

        $this->User->id = $id;
        if (!$this->User->exists()) {// if is not a post request , shuts down
            throw new NotFoundException(__('Invalid user'));//invalid user
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

}




?>
