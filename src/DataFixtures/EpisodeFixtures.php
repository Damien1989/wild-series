<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public const EPISODES = [
        array(
            'Title',
            1,
            'Sypnosis',
            0
        ),
        array(
            'Terminator Come back',
            1,
            'Sypnosis',
            0
        ),
        array(
            'Untitled',
            1,
            'Sypnosis',
            0
        ),
        array(
            'Va à la Kouizine',
            1,
            'Sypnosis',
            0
        ),
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::EPISODES as $key => $value) {
            list($episodeTitle, $episodeNumber, $episodeSypnosis, $episodeSeasonId) = $value;
            $episode = new Episode();
            $episode->setTitle($episodeTitle);
            $episode->setNumber($episodeNumber);
            $episode->setSynopsis($episodeSypnosis);
            $episode->setSeason($this->getReference('season_0'));

            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}

