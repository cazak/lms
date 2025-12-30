<?php

declare(strict_types=1);

namespace App\Member\Author\Entity;

/**
 * OneToMany Author->networks (соц. сети просто доступные в константах, не в админке настройка идет, поэтому там внутри привязка к автору)
 * OneToMany Author->awards
 * OneToMany Author->experiences
 * ManyToMany Author->expertises
 */
final class Author
{
    private readonly Id $id;

    private Name $name;

    private Email $email;

    private Phone $phone;

    private Avatar $avatar;

    private string $address;

    private string $biography;

//    /** @var Collection<int, Specialization> */
//    private Collection $specializations;

    /** @var Collection<int, Expertise> */
    private Collection $expertises;

    /** @var Collection<int, Award> */
    private Collection $awards;

    /** @var Collection<int, Experience> */
    private Collection $experiences;

    /** @var Collection<int, SocialNetwork> */
    private Collection $socialNetworks;

    private WorkingTime $workingTime;

    private Degree $degree;

    private int $startedYearOfTeaching;

    private int $rating;

    private DateTimeImmutable $createdAt;

    private DateTimeImmutable $updatedAt;

//    /**
//     * @param array<int, Specialization> $specializations
//     */
    public function __construct(
        Id $id,
        Name $name,
        Email $email,
        Phone $phone,
//        array $specializations
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
//        $this->specializations = new ArrayCollection($specializations);
    }
}
