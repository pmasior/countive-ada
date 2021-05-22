<?php

namespace App\Security\Voter;

use App\Entity\Category;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CategoryVoter extends Voter
{
    const RETRIEVE_COLLECTION = 'CATEGORY_RETRIEVE_COLLECTION';
    const RETRIEVE_ITEM = 'CATEGORY_RETRIEVE_ITEM';
    const CREATE = 'CATEGORY_CREATE';
    const REPLACE = 'CATEGORY_REPLACE';
    const REMOVE = 'CATEGORY_REMOVE';
    const UPDATE = 'CATEGORY_UPDATE';

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html

        if (in_array($attribute, [self::CREATE, self::RETRIEVE_COLLECTION])) {
            return true;
        }

        if (in_array($attribute, [
                self::CREATE, self::REMOVE, self::REPLACE, self::RETRIEVE_ITEM, self::UPDATE,
            ])
            && $subject instanceof Category
        ) {
            return true;
        }

        return false;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var Category $subject */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::CREATE:
            case self::RETRIEVE_COLLECTION:
                return true;

            case self::RETRIEVE_ITEM:
            case self::REPLACE:
            case self::REMOVE:
            case self::UPDATE:
                if ($subject->getUserAccount() === $user) {
                    return true;
                }
                return false;
        }

        throw new \LogicException('Unhandled attribute' . $attribute);
    }
}
