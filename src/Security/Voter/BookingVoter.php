<?php

namespace App\Security\Voter;

use App\Entity\Event;
use App\Repository\BookingRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class BookingVoter extends Voter
{
    const ATTRIBUTES = ['BOOK_EVENT', 'DISPLAY_BOOK_EVENT'];
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

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
        if (!$user instanceof UserInterface && $attribute === 'BOOK_EVENT') {
            return false;
        }

        $countBooking = $this->bookingRepository->count([
            'event' => $subject,
            'user' => $user,
        ]);

        if($countBooking > 0){
            return false;
        }

        return true;
    }
}
