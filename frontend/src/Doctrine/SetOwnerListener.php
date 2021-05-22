<?php


namespace App\Doctrine;


use App\Entity\Category;
use Symfony\Component\Security\Core\Security;

class SetOwnerListener
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security=$security;
    }

    /**
     * If user not set in entity, then set it to logged in user
     *
     * @param $object
     */
    public function setOwnerIfNotSet($object)
    {
        if ($object->getUserAccount()) {
            return;
        }

        if ($this->security->getUser()) {
            $object->setUserAccount($this->security->getUser());
        }

    }

}
