<?php

namespace App\Security\Voter;

use App\Entity\Account;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['SHOW', 'DELETE'])
            && $subject instanceof \App\Entity\Account;
    }

    /**
     * @param string $attribute
     * @param Account $account
     * @param TokenInterface $token
     * @return false
     */
    protected function voteOnAttribute($attribute, $account, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $accessIsGranted = match ($attribute) {
            'SHOW' => $account->getAccountHolder() == $user || $account->getAccountManager() == $user,
            'DELETE' => false
        };

        return $accessIsGranted;
    }
}
