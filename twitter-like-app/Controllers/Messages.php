<?php

class Messages extends AuthorizeController {

    private $data_connector;

    public function __construct() {
        parent::__construct();
        $this->data_connector = new DataConnector('messages.json');
    }
    
    public function index() {
        
        if ($_SESSION['isSearhing'] && isset($_SESSION['messages'])) {
            $messages = $_SESSION['messages'];
        } else {
            $messages = $this->data_connector->fetchData();
        }
        
        $this->view->messages = $messages;
        $this->view->searchValue = isset($_SESSION['searchValue']) ? $_SESSION['searchValue'] : '';
        $this->view->currentDateFilter = isset($_SESSION['currentDateFilter']) ? $_SESSION['currentDateFilter'] : '';
        
        $this->view->render('messages/view', false);
    }

    public function add() {
        $data = $_POST;
        $data['username'] = 'pedro0125'; //TODO
        $data['created_at'] = time();
        $message = new Message($data);

        $this->data_connector->prependData($message->toArray());

        echo json_encode([
            'success' => true,
            'message' => 'New mesage was successfully posted'
        ]);
    }

    public function search() {
        $data = $_POST;
        $username = 'pedro0125'; //TODO

        $userTimezone = new DateTimeZone('America/Bogota');

        $date = DateTime::createFromFormat('Y-m-d H:i:s', $data['created_at'] . ' 23:59:59', $userTimezone);

        $created_at = $date->getTimestamp();

        if ($data['content'] !== '') {
            $messages = $this->data_connector->fetchData();

            $result = [];
    
            foreach ($messages as $message_raw) {
                $message = new Message($message_raw);
                if ($message->matches($username, $data['content'], $created_at)) {
                    $result[] = $message->toArray();
                }
            }
    
            $_SESSION['isSearhing'] = true;
            $_SESSION['currentDateFilter'] = $data['created_at'];
            $_SESSION['searchValue'] = $data['content'];
            $_SESSION['messages'] = $result;
        } else {
            $_SESSION['isSearhing'] = false;
            unset($_SESSION['messages'], $_SESSION['currentDateFilter'], $_SESSION['searchValue']);
        }

        echo json_encode([
            'success' => true,
            'message' => 'Searching was successfully applied'
        ]);
    }
}