<?php
namespace App\Security\Voter;

use App\Entity\Event;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class EventVoter extends Voter
{
    const ATTRIBUTES = ['EVENT_FORM'];

    protected function supports(string $attribute, $subject): bool
    {
        if(!in_array($attribute, self::ATTRIBUTES)){
            return false;
        }

        if(!$subject instanceof Event){
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if(!$user instanceof UserInterface){
            return false;
        }

        if($subject->getOwner() !== $user){
            return false;
        }

        return true;
    }
}
