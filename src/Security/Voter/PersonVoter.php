<?php

namespace App\Security\Voter;

use App\Entity\Person;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class PersonVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['view', 'edit'])
            && $subject instanceof Person;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'view':
                // logic to determine if the user can VIEW
                if($user->getId() === $subject->getUserClient()->getId() ){
                    return true;
                }
                break;
            case 'edit':
                // logic to determine if the user can EDIT
                // return true or false
                return true;
                break;
        }

        return false;
    }
}
