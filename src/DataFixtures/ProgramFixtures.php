<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        array (
            'The Big Bang Theory',
            'Leonard Hofstadter et Sheldon Cooper vivent en colocation à Pasadena, ville de l agglomération de Los Angeles. 
            Ce sont tous deux des physiciens surdoués, « geeks » de surcroît. C est d ailleurs autour de cela qu est axée la majeure partie comique de la série. 
            Ils partagent quasiment tout leur temps libre avec leurs deux amis Howard Wolowitz et Rajesh Koothrappali pour jouer à des jeux vidéo comme Halo, organiser un marathon de la saga Star Wars, jouer à des jeux de société comme le Boggle klingon ou de rôles tel que Donjons et Dragons, voire discuter de théories scientifiques très complexes.Leur univers routinier est perturbé lorsqu une jeune femme, Penny, s installe dans l appartement d en face. 
            Leonard a immédiatement des vues sur elle et va tout faire pour la séduire ainsi que l intégrer au groupe et à son univers, auquel elle ne connaît rien.',
            'https://upload.wikimedia.org/wikipedia/fr/6/69/BigBangTheory_Logo.png',
            '5'
            ),
        array(
            'The Haunting Of Hill House',
            'Plusieurs frères et sœurs qui, enfants,
            ont grandi dans la demeure qui allait devenir la maison hantée la plus célèbre des États-Unis,
            sont contraints de se réunir pour finalement affronter les fantômes de leur passé.',
            'https://m.media-amazon.com/images/M/MV5BMTU4NzA4MDEwNF5BMl5BanBnXkFtZTgwMTQxODYzNjM@._V1_SY1000_CR0,0,674,1000_AL_.jpg',
            '2'
            ),
        array(
            'American Horror Story',
            'A chaque saison, son histoire.
            American Horror Story nous embarque dans des récits à la fois poignants et cauchemardesques,
            mêlant la peur, le gore et le politiquement correct.',
            'https://m.media-amazon.com/images/M/MV5BODZlYzc2ODYtYmQyZS00ZTM4LTk4ZDQtMTMyZDdhMDgzZTU0XkEyXkFqcGdeQXVyMzQ2MDI5NjU@._V1_SY1000_CR0,0,666,1000_AL_.jpg',
            '4'
            ),
        array(
            'Penny Dreadful',
            'Dans le Londres ancien, Vanessa Ives, une jeune femme puissante aux pouvoirs hypnotiques,
            allie ses forces à celles d Ethan, un garçon rebelle et violent aux allures de cowboy,
            et de Sir Malcolm, un vieil homme riche aux ressources inépuisables. 
            Ensemble, ils combattent un ennemi inconnu, presque invisible,
            qui ne semble pas humain et qui massacre la population.',
            'https://m.media-amazon.com/images/M/MV5BNmE5MDE0ZmMtY2I5Mi00Y2RjLWJlYjMtODkxODQ5OWY1ODdkXkEyXkFqcGdeQXVyNjU2NjA5NjM@._V1_SY1000_CR0,0,695,1000_AL_.jpg',
            '3'
            ),
        array(
            'Fear The Walking Dead',
            'La série se déroule au tout début de l épidémie relatée dans la série-mère
            The Walking Dead et se passe dans la ville de Los Angeles, et non à Atlanta.
            Madison est conseillère dans un lycée de Los Angeles. Depuis la mort de son mari,
            elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux,
            et son grand frère Nick qui a quitté la fac et a sombré dans la drogue.',
            'https://m.media-amazon.com/images/M/MV5BYWNmY2Y1NTgtYTExMS00NGUxLWIxYWQtMjU4MjNkZjZlZjQ3XkEyXkFqcGdeQXVyMzQ2MDI5NjU@._V1_SY1000_CR0,0,666,1000_AL_.jpg',
            '2'
        ),
            ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $key => $value) {
            list($programTitle, $programSummary, $programPoster, $programCategory) = $value;
            $program = new Program();
            $program->setTitle($programTitle);
            $program->setSummary($programSummary);
            $program->setPoster($programPoster);
            $program->setCategory($this->getReference('category_' . $programCategory));
        /* $program = new Program();
        $program->setTitle('test');
        $program->setSummary('test');
        $program->setCategory($this->getReference('category_0'));
        $program->setPoster('test');
        $program->addActor($this->getReference('actor_0')); */
            for ($i = 0; $i < count(ActorFixtures::ACTORS); $i++) {
                $program->addActor($this->getReference('actor_' . $i));
            }
            $manager->persist($program);
            $this->addReference('program_' . $key, $program);
            $manager->flush();
        }
        }

    public function getDependencies()
    {
        return [
            ActorFixtures::class,
            CategoryFixtures::class,
            ];
    }
}
