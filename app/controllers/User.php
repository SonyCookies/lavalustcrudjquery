<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class User extends Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->call->model('User_model');

    // $this->call->database();
    // $this->call->helper('url');
  }

  public function index()
  {
    $data['users'] = $this->User_model->get_users();
    $this->call->view('user_page', $data);
  }
  public function show()
  {
    $this->call->view('view_user_page');
  }
  public function create()
  {
    $this->call->view('add_user_page');
  }
  public function create_user()
  {
    $last_name = $this->io->post('sps_last_name');
    $first_name = $this->io->post('sps_first_name');
    $email = $this->io->post('sps_email');
    $gender = $this->io->post('sps_gender');
    $address = $this->io->post('sps_address');

    if ($this->User_model->insert_user($last_name, $first_name, $email, $gender, $address)) {
      echo json_encode(['status' => 'success', 'message' => 'User added successfully']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to add user']);
    }
  }


  public function edit_user($id)
  {
    $user['user'] = $this->User_model->getUserById($id);
    $this->call->view('edit_user_page', $user);
  }

  public function update_user($id)
  {
    $data = array(
      'sps_last_name' => $this->io->post('sps_last_name'),
      'sps_first_name' => $this->io->post('sps_first_name'),
      'sps_email' => $this->io->post('sps_email'),
      'sps_gender' => $this->io->post('sps_gender'),
      'sps_address' => $this->io->post('sps_address')
    );

    if ($this->User_model->update_user($id, $data)) {
      echo json_encode(['status' => 'success', 'message' => 'User updated successfully']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to update user']);
    }
  }


  public function delete_user($id)
  {
    if ($this->User_model->delete_user($id)) {
      echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
    }

    header('Content-Type: application/json');
  }


  public function get_all()
  {
    $users = $this->User_model->get_users();
    if (!empty($users)) {
      echo json_encode(['status' => 'success', 'users' => $users]);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'No users found']);
    }
  }
}
