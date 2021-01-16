<?php


namespace App\ViewModel\RequestViewModel;


use App\Entity\Contact;
use JMS\Serializer\Annotation as JMS;

class ReservationRequestViewModel
{
    /**
     * @JMS\Type("string")
     */
    private string $date;

    /**
     * @var \DateTime|null
     * @JMS\Type("datetime")
     */
    private ?\DateTime $dateOfReservation = null;

    /**
     * @var int
     * @JMS\Type("integer")
     */
    private int $numberOfSeats;

    private ?Contact $contact;

    /**
     * @return int
     */
    public function getNumberOfSeats(): int
    {
        return $this->numberOfSeats;
    }

    /**
     * @param int $numberOfSeats
     */
    public function setNumberOfSeats(int $numberOfSeats): void
    {
        $this->numberOfSeats = $numberOfSeats;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateOfReservation(): ?\DateTime
    {
        return $this->dateOfReservation;
    }

    /**
     * @param \DateTime|null $dateOfReservation
     */
    public function setDateOfReservation(?\DateTime $dateOfReservation): void
    {
        $this->dateOfReservation = $dateOfReservation;
    }

    /**
     * @return Contact|null
     */
    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    /**
     * @param Contact|null $contact
     */
    public function setContact(?Contact $contact): void
    {
        $this->contact = $contact;
    }
}