<?php

namespace App\Validator;

use App\Entity\UserAccount;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsValidOwnerValidator extends ConstraintValidator
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Validate if Category owner is logged in user
     *
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint IsValidOwner */

        if (null === $value || '' === $value) {
            return;
        }

        if (!$value instanceof UserAccount) {
            throw new \InvalidArgumentException('@IsValidConstraint must be put on a property containing a User object');
        }

        $user = $this->security->getUser();
        if (!$user instanceof UserAccount) {
            $this->context->buildViolation($constraint->messageForAnonymousUser)
                ->addViolation();
            return;
        }

        if ($value !== $user) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
