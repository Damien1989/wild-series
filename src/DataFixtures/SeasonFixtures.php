<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public const SEASONS = [
        array(
            '1',
            '2010',
            'Season 1',
            '1'
        ),
        array(
            '1',
            '2011',
            'Season 2',
            '1'
        ),
        array(
            '1',
            '2012',
            'Season 3',
            '1'
        ),
        array(
            '1',
            '2013',
            'Season 4',
            '1'
        ),
        array(
            '1',
            '2014',
            'Season 5',
            '1'
        ),
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SEASONS as $key => $value) {
            list($programId, $seasonYear, $seasonDescription, $seasonNumber) = $value;
            $season = new Season();
            $season->setYear($seasonYear);
            $season->setDescription($seasonDescription);
            $season->setNumber($seasonNumber);
            $season->setProgram($this->getReference('program_0'));
            $manager->persist($season);
            $this->addReference('season_' . $key, $season);
            }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}