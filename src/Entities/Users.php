<?php

namespace Entities;

/**
 * Users
 *
 * @Table(name="users",
 * uniqueConstraints={
 * @UniqueConstraint(name="userid", columns={"userid"}),
 * @UniqueConstraint(name="email", columns={"email"})})
 * @Entity
 */
class Users
{

    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="userid", type="string", length=50, nullable=false)
     */
    private $userid;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=70, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="password", type="string", length=50, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @Column(name="first_name", type="string", length=50, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @Column(name="last_name", type="string", length=50, nullable=false)
     */
    private $lastName;

    public function getId()
    {
        return $this->id;
    }

    public function getUserid()
    {
        return $this->userid;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setUserid($userid)
    {
        $this->userid = $userid;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
}
