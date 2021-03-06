<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *   name="activity_subscriptions",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(
 *       name="activity_subscriptions_unique",
 *       columns={"followed_adherent_id", "following_adherent_id"}
 *     )
 *   }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActivitySubscriptionRepository")
 */
class ActivitySubscription
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Adherent|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     */
    private $followingAdherent;

    /**
     * @var Adherent|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     */
    private $followedAdherent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $subscribedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $unsubscribedAt;

    private function __construct(
        Adherent $followingAdherent,
        Adherent $followedAdherent,
        string $subscriptionDate = 'now'
    ) {
        $this->followingAdherent = $followingAdherent;
        $this->followedAdherent = $followedAdherent;
        $this->subscribedAt = new \DateTimeImmutable($subscriptionDate);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollowingAdherent(): Adherent
    {
        return $this->followingAdherent;
    }

    public function getFollowedAdherent(): Adherent
    {
        return $this->followedAdherent;
    }

    public function getSubscriptionDate(): \DateTimeImmutable
    {
        if ($this->subscribedAt instanceof \DateTime) {
            $this->subscribedAt = \DateTimeImmutable::createFromMutable($this->subscribedAt);
        }

        return $this->subscribedAt;
    }

    public function getUnsubscriptionDate(): ?\DateTimeImmutable
    {
        if ($this->unsubscribedAt instanceof \DateTime) {
            $this->unsubscribedAt = \DateTimeImmutable::createFromMutable($this->unsubscribedAt);
        }

        return $this->unsubscribedAt;
    }
}
