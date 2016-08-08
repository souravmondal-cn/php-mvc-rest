<?php

namespace Controllers\Web;

use Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Models\User;

class UserController extends Controller
{

    private $userModel;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->userModel = new User($this->app['doctrine']);
    }

    public function getAll()
    {
        $allUsers = $this->userModel->getAll();
        $response = array(
            'message' => 'successfully fetched all users',
            'data' => array(
                'users' => json_decode($this->serializer->serialize($allUsers, 'json'))
            )
        );
        $httpStatus = 200;
        if (empty($allUsers)) {
            $response = array(
                'message' => 'no user found',
                'data' => ''
            );
            $httpStatus = 204;
        }
        return new JsonResponse($response, $httpStatus);
    }

    public function getUser($userId)
    {
        $userDetails = $this->userModel->getUser($userId);
        $response = array(
            'message' => 'user details found',
            'data' => json_decode($this->serializer->serialize($userDetails, 'json'))
        );
        $httpStatus = 200;
        if (!$userDetails) {
            $response = array(
                'message' => 'user details not found',
                'data' => ''
            );
            $httpStatus = 204;
        }
        return new JsonResponse($response, $httpStatus);
    }

    public function addUser(Request $request)
    {
        $userDetails = array(
            'first_name' => $request->request->get('first_name'),
            'last_name' => $request->request->get('last_name'),
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password')
        );
        $userAdd = $this->userModel->addUser($userDetails);
        $response = array(
            'message' => 'user added sussecfully',
            'data' => array(
                'userid' => $userAdd
            )
        );
        $httpStatus = 201;
        if (!$userAdd) {
            $response = array(
                'message' => 'user add was not sussecful',
                'data' => ''
            );
            $httpStatus = 500;
        }
        return new JsonResponse($response, $httpStatus);
    }

    public function updateUser($userId, Request $request)
    {
        $userDetails = array(
            'first_name' => $request->request->get('first_name'),
            'last_name' => $request->request->get('last_name'),
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password')
        );
        $userUpdate = $this->userModel->updateUser($userId, $userDetails);
        $response = array(
            'message' => 'user update was successful',
            'data' => array(
                'userid' => $userUpdate
            )
        );
        $httpStatus = 200;
        if (!$userUpdate) {
            $response = array(
                'message' => 'user update was not successful',
                'data' => ''
            );
            $httpStatus = 500;
        }
        return new JsonResponse($response, $httpStatus);
    }

    public function deleteUser($userId)
    {
        $userDelete = $this->userModel->deleteUser($userId);
        $response = array(
            'message' => 'user deleted successfully',
            'data' => ''
        );
        $httpStatus = 200;
        if (!$userDelete) {
            $response = array(
                'message' => 'user deletion was not successful',
                'data' => ''
            );
            $httpStatus = 500;
        }
        return new JsonResponse($response, $httpStatus);
    }
    
    public function login(Request $request)
    {
        $userDetails = array(
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password')
        );
        $userLogin = $this->userModel->login($userDetails);
        $response = array(
            'message' => 'login was valid',
            'data' => array(
                'login' => true
            )
        );
        $httpStatus = 200;
        if (!$userLogin) {
            $response = array(
                'message' => 'login was invalid',
                'data' => array(
                    'login' => false
                )
            );
            $httpStatus = 401;
        }
        return new JsonResponse($response, $httpStatus);
    }
}
