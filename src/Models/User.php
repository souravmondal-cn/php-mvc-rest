<?php

namespace Models;

use Entities\Users;

class User
{

    private $em;
    private $userRepository;

    public function __construct($em)
    {
        $this->em = $em;
        $this->userRepository = $em->getRepository('Entities\Users');
    }

    public function getAll()
    {
        return $this->userRepository->findAll();
    }

    public function getUser($userId)
    {
        $userDetails = $this->userRepository->findOneBy(array(
            'userid' => $userId
        ));
        if (empty($userDetails)) {
            return false;
        }
        return $userDetails;
    }

    public function addUser($userDetails)
    {

        $existingUser = $this->userRepository->findOneBy(array(
            'email' => $userDetails['email']
        ));
        if ($existingUser) {
            return false;
        }
        if (!$this->validateUserData($userDetails)) {
            return false;
        }
        $userId = date('hdmisy');
        $newUser = new Users();
        $newUser->setEmail($userDetails['email']);
        $newUser->setFirstName($userDetails['first_name']);
        $newUser->setLastName($userDetails['last_name']);
        $newUser->setUserid($userId);
        $newUser->setPassword($this->generatePassword($userDetails['password']));
        try {
            $this->em->persist($newUser);
            $this->em->flush();
            return $newUser->getUserid();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateUser($userId, $userDetails)
    {
        if (!$this->validateUserData($userDetails)) {
            return false;
        }
        $user = $this->userRepository->findOneBy(array(
            'userid' => $userId
        ));
        $user->setEmail($userDetails['email']);
        $user->setFirstName($userDetails['first_name']);
        $user->setLastName($userDetails['last_name']);
        $user->setPassword($this->generatePassword($userDetails['password']));
        try {
            $this->em->persist($user);
            $this->em->flush();
            return $user->getUserid();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteUser($userId)
    {
        $user = $this->userRepository->findOneBy(array(
            'userid' => $userId
        ));
        try {
            $this->em->remove($user);
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function login($userDetails)
    {
        $user = $this->userRepository->findOneBy(array(
            'email' => $userDetails['email'],
            'password' => $this->generatePassword($userDetails['password'])
        ));
        if (!empty($user)) {
            return true;
        }
        return false;
    }

    private function validateUserData($userData)
    {
        foreach ($userData as $key => $value) {
            if (empty($value)) {
                return false;
            }
            if ($key == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }
        return true;
    }
    
    private function generatePassword($rawPassword)
    {
        return hash_hmac('ripemd160', $rawPassword, 'sfffafa242sds35753usfbsfh');
    }
}
