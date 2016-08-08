<?php

namespace Controllers;

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

    /**
     * @api {GET} /users  3.GetAll
     * @apiName UserList
     * @apiGroup User
     * @apiVersion 1.0.0
     * @apiDescription List all users present in the system with user details
     * @apiSuccess {200} message successfully fetched all users
     * @apiError {204} message no user found
     * @apiSuccessExample {json} Success-Response Example:
     * {
        "message": "successfully fetched all users",
        "data": {
            "users": [
                {
                    "id": 6,
                    "userid": "110708593716",
                    "email": "user1@gmail.com",
                    "password": "4bdbbab266c08f25f9c62c50049ab9091d0dbe1c",
                    "firstName": "John",
                    "lastName": "Cena"
                },
                {
                    "id": 7,
                    "userid": "120808253916",
                    "email": "user2@gmail.com",
                    "password": "4bdbbab266c08f25f9c62c50049ab9091d0dbe1c",
                    "firstName": "Eric",
                    "lastName": "Joshep"
                }
            ]
        }
    }
     * @apiErrorExample {json} Error-Response Example:
     *{
        "message": "no user found",
        "data": ""
    }
    */
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

    /**
     * @api {GET} /user/{userid}  2.Details
     * @apiName UserDetails
     * @apiGroup User
     * @apiVersion 1.0.0
     * @apiDescription Get the details of a specific user
     * @apiParam {String} userid user id of the user you want to fetch the details
     * @apiSuccess {200} message user details found
     * @apiError {204} message user details not found
     * @apiSuccessExample {json} Success-Response Example:
     * {
    "message": "user details found",
        "data": {
            "id": 8,
            "userid": "010808212716",
            "email": "user1@gmail.com",
            "password": "4bdbbab266c08f25f9c62c50049ab9091d0dbe1c",
            "firstName": "John",
            "lastName": "Cena"
        }
    }
     * @apiErrorExample {json} Error-Response Example:
     *{
        "message": "user details not found",
        "data": ""
    }
    */
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

    /**
     * @api {POST} /user/add  1.Add
     * @apiName UserAdd
     * @apiGroup User
     * @apiVersion 1.0.0
     * @apiDescription create a new user in the system
     * @apiParam {String} first_name First Name of the user
     * @apiParam {String} last_name Last name of the user
     * @apiParam {String} email email address of the user, email is unique for each user
     * @apiParam {String} password the password of the user for login authencation.
     * @apiSuccess {201} message user added sussecfully
     * @apiError {500} message user add was not sussecful
     * @apiSuccessExample {json} Success-Response Example:
     * {
        "message": "user added sussecfully",
        "data": {
            "userid": "010808424716"
        }
    }
     * @apiErrorExample {json} Error-Response Example:
     *{
        "message": "user add was not sussecful",
        "data": ""
    }
    */
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

    /**
     * @api {PUT} /user/update/{userId}  4.Update
     * @apiName UserUpdate
     * @apiGroup User
     * @apiVersion 1.0.0
     * @apiDescription update a existing user in the system
     * @apiParam {String} first_name First Name of the user
     * @apiParam {String} last_name Last Name of the user
     * @apiParam {String} email email address of the user, email is unique for each user
     * @apiParam {String} password the password of the user for login authencation.
     * @apiSuccess {200} message user update was successful
     * @apiError {500} message user update was not successful
     * @apiSuccessExample {json} Success-Response Example:
     * {
    "message": "user update was successful",
        "data": {
            "userid": "010808424716"
        }
    }
     * @apiErrorExample {json} Error-Response Example:
     *{
        "message": "user update was not successful",
        "data": ""
    }
    */
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

    /**
     * @api {DELETE} /user/delete/{userId}  5.Delete
     * @apiName UserDelete
     * @apiGroup User
     * @apiVersion 1.0.0
     * @apiDescription delete a user from the system
     * @apiParam {String} userId user id of the user we want to remove
     * @apiSuccess {200} message user deleted successfully
     * @apiError {500} message user deletion was not successful
     * @apiSuccessExample {json} Success-Response Example:
     * {
    "message": "user deleted successfully",
        "data": ""
    }
     * @apiErrorExample {json} Error-Response Example:
     *{
        "message": "user deletion was not successful",
        "data": ""
    }
    */
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
    
    /**
     * @api {POST} /user/authencate  6.Login
     * @apiName UserLogin
     * @apiGroup User
     * @apiVersion 1.0.0
     * @apiDescription Check login against an email and password
     * @apiParam {String} email email address of the user
     * @apiParam {String} password the password of the user
     * @apiSuccess {200} message login was valid
     * @apiError {401} message login was invalid
     * @apiSuccessExample {json} Success-Response Example:
     * {
        "message": "login was valid",
        "data": {
            "login": true
        }
    }
     * @apiErrorExample {json} Error-Response Example:
     *{
        "message": "login was invalid",
        "data": {
            "login": false
        }
    }
    */
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
