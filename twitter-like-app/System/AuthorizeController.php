<?php
/**
 * This controller has the responsibility to check if the current user is logged in.
 * So far, since the authencation feature is not available, it's just creating a new session.
 */
class AuthorizeController extends Controller
{
    public function __construct() {
        parent::__construct();
        /*if(session_status() !== PHP_SESSION_ACTIVE) {
            header('Location: /twitter-like-app/');
        }*/

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        } 
    }
}