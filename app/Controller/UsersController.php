<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'logout');
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {

		$timezones = timezone_identifiers_list();
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $this->Auth->user('id')));
		$this->set('user', $this->User->find('first', $options));
		$this->set(compact('timezones'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$files = $this->request->data['User']['profile_pic'];
			if (empty($files[0])) {
				$this->Session->setFlash('Please upload the profile picture');
				return false;
			}
			$uploadPath = WWW_ROOT . 'img' . DS . 'Profiles';
			if (!is_dir($uploadPath)) {
				mkdir($uploadPath, 0777, true);
			}

			$fileName = $this->getCleanFileName($files[0]['name']);
			$this->request->data['User']['profile_pic'] = $fileName;

			if (move_uploaded_file($files[0]['tmp_name'], $uploadPath . DS . $fileName)) {
				$this->User->create();
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The user has been saved.'));
					return $this->redirect(array('controller' => 'Users', 'action' => 'login'));
				} else {
					$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
					return false;
				}
			} else {
				$this->Session->setFlash(__('Profile picture has not been uploaded.'));
				return false;
			}
		}
		$timezone = array();
		$timezones = timezone_identifiers_list();
		$this->set(compact('timezones'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->request->is(array('post', 'put'))) {


			$files = $this->request->data['User']['profile_pic'];
			if (!empty($files[0]) && !empty($files[0]['name'])) {
				$uploadPath = WWW_ROOT . 'img' . DS . 'Profiles';
				if (!is_dir($uploadPath)) {
					mkdir($uploadPath, 0777, true);
				}
				$fileName = $this->getCleanFileName($files[0]['name']);
				if(move_uploaded_file($files[0]['tmp_name'], $uploadPath . DS . $fileName)){
					$this->request->data['User']['profile_pic'] = $fileName;
				}
			}else{
				unset($this->request->data['User']['profile_pic']);
			}

			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'view'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$data = $this->request->data = $this->User->find('first', $options);
			$timezones = timezone_identifiers_list();
			$this->set(compact('data','timezones'));
		}
	}


    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect(array('controller' => 'Users', 'action' => 'view')));
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
		return $this->redirect($this->Auth->logout());
    }

	public function getCleanFileName($name = NULL){
		$setFileName    =   null;
		$file_string = strtolower(pathinfo($name, PATHINFO_FILENAME));


		$file_string  =   strtolower(trim($file_string));
		$file_string  =   str_replace(' ', '-', $file_string); // Replaces all spaces with hyphens.
		$setFileName    =   preg_replace('/[^A-Za-z0-9\-\_]/', '', $file_string); // Removes special chars.

		$setFileExt  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
		$fileName    = $setFileName."-".time().".".$setFileExt; // Appending timestamp to fill

		return $fileName;
	}
}
