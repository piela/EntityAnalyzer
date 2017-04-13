<?php

namespace Flexix\SandboxBundle\Sample;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Flexix\PrototypeBundle\Util\TicketInterface;

/**
 * Description of Voter
 *
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class SampleVoter extends Voter {

    private $decisionManager;

    protected function supports($attribute, $subject) {

        //exit('You need to add Security logic first');
        //Some security logic, sample http://symfony.com/doc/current/security/voters.html

        if (!$subject instanceof TicketInterface) {
            return false;
        }
        return true;
    }

    public function __construct(AccessDecisionManagerInterface $decisionManager) {
        $this->decisionManager = $decisionManager;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {

        //Some security logic, sample http://symfony.com/doc/current/security/voters.html
        return true;
    }

}
