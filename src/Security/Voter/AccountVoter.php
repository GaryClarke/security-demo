<?php

namespace App\Security\Voter;

use App\Entity\Account;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountVoter extends Voter
{
    public function __construct(public Security $security)
    {
    }

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
            'SHOW' => $this->show($account, $user),
            'DELETE' => $this->security->isGranted('ROLE_ADMIN')
        };

        return $accessIsGranted;
    }


    /**
     * Rules for showing an account
     *
     * @param $account
     * @param $user
     * @return bool
     */
    private function show($account, $user): bool
    {
        return $account->getAccountHolder() == $user
            || $account->getAccountManager() == $user
            || $this->security->isGranted('ROLE_ADMIN');
    }
}
