<?php

declare(strict_types=1);

namespace App\Member\Author\Test\Entity;

use DateTimeImmutable;

/**
 * Этот модуль написать сначала тесты, а потом классы
 *
 * Другие модули:
 * Сначала написать команд хэндлеры (там где операции и события задействовать, то есть саму бизнес-логику и поведение приложения). Потом уже сущности + тесты
 *
 * Либо если не пойдет попробовать сначала сущности, а потом остальное (тесты и хэндлеры)
 */
#[CoversClass(Author::class)]
final class AuthorTest
{
    public function success(): void
    {
        $author = new Author(
            $id = Id::generate(),
            $name = new Name('Alexandra', 'Chen'),
            $email = new Email('test@test.com'),
            $phone = new Phone('+15557890123'),
//            $specialization = [new Specialization('specialization')],
        );

        self::assertTrue($id->isEqualTo($author->getId()));
        self::assertTrue($name->isEqualTo($author->getName()));
        self::assertTrue($email->isEqualTo($author->getEmail()));
        self::assertTrue($phone->isEqualTo($author->getPhone()));
//        self::assertCount(1, $author->getSpecializations());
//        self::assertTrue($author->getSpecializations()->contains($specialization));

        $name = new Name('Martin', 'Lewis');
        $email = new Email('test@test.test');
        $phone = new Phone('+15557890111');
        $avatar = new Avatar('another.jpg');
        $address = 'Room 304, Computer Science Building';
        $biography = 'Biography';
//        $specialization = new Specialization('another');
        $expertise = new Expertize('Artificial Intelligence', new Avatar('artificial_intelligence.jpg'));
        $award = new Award(
            2019,
            'Excellence in Teaching Award',
            'MIT Computer Science Department',
            Award::OLYMPIAD,
        );
        $experience = new Experience(
            new ExperiencePeriod(
                2021,
                2020,
            ),
            'Lead AI Researcher',
            'TechForward Institute'
        );
        $socialNetwork = new SocialNetwork('VK', 'nickname');
        $working = new WorkingTime(['tuesday', 'thursday'], 14, 16);
        $degree = Degree::PhD;
        $startedYearOfTeaching = 2015;
        $rating = 5;

        $author->changeName($name);
        $author->changeEmail($email);
        $author->changePhone($phone);
//        $author->addSpecialization($specialization);
        $author->addExpertize($expertise);
        $author->addExperience($experience);
        $author->addAward($award);
        $author->addNetwork($socialNetwork);
        $author->setBiography($biography);
        $author->setAvatar($avatar);
        $author->setAddress($address);
        $author->setDegree($degree);
        $author->setWorkingTime($working);
        $author->setStartedYearOfTeaching($startedYearOfTeaching);
        $author->setRating($rating);

        self::assertTrue($name->isEqualTo($author->getName()));
        self::assertTrue($email->isEqualTo($author->getEmail()));
        self::assertTrue($phone->isEqualTo($author->getPhone()));
        self::assertTrue($avatar->isEqualTo($author->getAvatar()));
        self::assertTrue($working->isEqualTo($author->getWorkingTime()));
        self::assertTrue($degree->isEqualTo($author->getDegree()));
        self::assertEquals($address, $author->getAddress());
        self::assertEquals($biography, $author->getBiography());
        self::assertEquals($startedYearOfTeaching, $author->getStartedYearOfTeaching());
        self::assertEquals((int)date('Y') - $startedYearOfTeaching, $author->getYearsOfTeaching());
        self::assertEquals($rating, $author->getRating());

//        self::assertCount(2, $author->getSpecializations());
//        self::assertTrue($author->getSpecializations()->contains($specialization));
        self::assertCount(1, $author->getExpertises());
        self::assertTrue($author->getExpertises()->contains($expertise));
        self::assertCount(1, $author->getExperiences());
        self::assertTrue($author->getExperiences()->contains($experience));
        self::assertCount(1, $author->getSocialNetworks());
        self::assertTrue($author->getSocialNetworks()->contains($socialNetwork));
        self::assertCount(1, $author->getAwards());
        self::assertTrue($author->getAwards()->contains($award));
    }
}
