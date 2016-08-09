<?php

namespace Controllers\Web;

use Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Models\User;

class UserController extends Controller {

    private $userModel;

    public function __construct($app) {
        parent::__construct($app);
        $this->userModel = new User($this->app['doctrine']);
    }

    public function login() {
        return $this->app['twig']->render('login.twig');
    }

    public function loginCheck(Request $request) {
        $userDetails = array(
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password')
        );

        if ($this->userModel->login($userDetails)) {
            $this->session->getFlashBag()->add(
                    'message', array(
                'type' => "success",
                'content' => "Welcome " . $request->request->get('email')
                    )
            );
            return new RedirectResponse('/home');
        }
        $this->session->getFlashBag()->add(
                'message', array(
            'type' => "danger",
            'content' => "Invalid credientials.Login Failed"
                )
        );
        return new RedirectResponse('/login');
    }

    public function signup() {
        return $this->app['twig']->render('signup.twig');
    }

    public function signupProcess(Request $request) {
        $userDetails = array(
            'first_name' => $request->request->get('first_name'),
            'last_name' => $request->request->get('last_name'),
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password')
        );
        $userSignup = $this->userModel->addUser($userDetails);
        if ($userSignup) {
            $this->session->getFlashBag()->add(
                    'message', array(
                'type' => "success",
                'content' => "Registration was successful.Login now"
                    )
            );
            return new RedirectResponse('/login');
        }
        $this->session->getFlashBag()->add(
                'message', array(
            'type' => "success",
            'content' => "Registration was not successful.Try Again"
                )
        );
        return new RedirectResponse('/signup');
    }
    
    public function home() {
        return $this->app['twig']->render('home.twig',array(
            'title' => 'Home'
        ));
    }

}
