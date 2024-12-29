<?php
class Session {
    private $user_is_logged_in = false;
    private $msg = [];

    public function __construct() {
        session_start();
        $this->userLoginSetup();
        $this->flash_msg();
    }

    public function isUserLoggedIn() {
        return $this->user_is_logged_in;
    }

    public function login($user_id, $user_role) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_role'] = $user_role;
        $this->user_is_logged_in = true;
    }

    private function userLoginSetup() {
        if (isset($_SESSION['user_id'])) {
            $this->user_is_logged_in = true;
        } else {
            $this->user_is_logged_in = false;
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_role']);
        $this->user_is_logged_in = false;
    }

    public function msg($type = '', $msg = '') {
        if (!empty($msg)) {
            if (strlen(trim($type)) == 1) {
                $type = str_replace(array('d', 'i', 'w', 's'), array('danger', 'info', 'warning', 'success'), $type);
            }
            $_SESSION['msg'][$type] = $msg;
        } else {
            return $this->msg;
        }
    }

    private function flash_msg() {
        if (isset($_SESSION['msg'])) {
            $this->msg = $_SESSION['msg'];
            unset($_SESSION['msg']);
        } else {
            $this->msg = [];
        }
    }
}
?>