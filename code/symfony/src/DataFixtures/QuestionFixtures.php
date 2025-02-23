<?php

namespace App\DataFixtures;

use App\Config\QuestionEnum;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $questions = [
            [
                'question' => "Parmi ces villes finistériennes, laquelle n'existe pas ?",
                'more'     => null,
                'answers'  => [
                    ['answer' => 'Plougoulm', 'valid' => false],
                    ['answer' => 'Ploudiry', 'valid' => false],
                    ['answer' => 'Plouézan', 'valid' => true],
                    ['answer' => 'Plougar', 'valid' => false],
                ]
            ],
            [
                'question' => "Quelle est la devise de la commune de Landévennec ?",
                'more'     => '"Dalc\'h soñj dalc\'hmat" était la devise de Landerneau.',
                'answers'  => [
                    ['answer' => '"Da vro atao" (au pays toujours)', 'valid' => true],
                    ['answer' => '"Digompez ha dispar" (inconscient et exceptionnel)', 'valid' => false],
                    ['answer' => '"Dalc\'h soñj dalc\'hmat" (souvenir permanent)', 'valid' => false],
                    ['answer' => 'S\'ils te mordent, mords-les', 'valid' => false],
                ]
            ],
            [
                'question' => "Situé dans les monts d'Arrée, quelle est le point culminant de Bretagne",
                'more'     => 'A 385 mètres de hauteur, Roc\'h Ruz (« roc rouge ») offre une vue imprenable sur les Monts d\'Arrée.',
                'answers'  => [
                    ['answer' => 'Tuchenn Kador', 'valid' => true],
                    ['answer' => 'Roc\'h Ruz', 'valid' => false],
                    ['answer' => 'Roc\'h Trédudon', 'valid' => false],
                    ['answer' => 'Roc\'h Toullaëron', 'valid' => false],
                ]
            ],
            [
                'question' => "Que signifie le nom du drapeau breton, le Gwen ha du ?",
                'more'     => null,
                'answers'  => [
                    ['answer' => 'Blanche hermine', 'valid' => false],
                    ['answer' => 'Fier comme un breton', 'valid' => false],
                    ['answer' => 'Blanc et noir', 'valid' => true],
                    ['answer' => 'Jusqu\'à la mort', 'valid' => false],
                ]
            ],
            [
                'question' => "Parmi ces titres d'article de journaux, lequel n'existe pas ?",
                'more'     => null,
                'answers'  => [
                    ['answer' => 'Ivre, il rentre chez lui en engin de chantier et se fait pincer par les gendarmes (Cra\'ch)', 'valid' => false],
                    ['answer' => 'Ivre, il monte sur le toit du téléphérique (Brest)', 'valid' => false],
                    ['answer' => 'Ivre, il s’introduit dans un logement pour se cuisiner des lardons (Brest)', 'valid' => false],
                    ['answer' => 'ivre, il plonge dans l\'Odet pour échapper à la police (Quimper)', 'valid' => true],
                ]
            ],
            [
                'question' => "L'écrivaine connu pour avoir écrit la saga Harry Potter s'appelle JK Rowling, que signifie JK ?",
                'more'     => null,
                'answers'  => [
                    ['answer' => 'Joanne Kathleen', 'valid' => true],
                    ['answer' => 'Joanne King', 'valid' => false],
                    ['answer' => 'Joanne Kenneth', 'valid' => false],
                    ['answer' => 'Joanne Kate', 'valid' => false],
                ]
            ],
        ];

        foreach ($questions as $index => $question) {

            $question1 = new Question;
            $question1->setType(QuestionEnum::single);
            $question1->setPosition($index + 1);
            $question1->setContent(['question' => $question['question']]);
            $question1->setAnswers($question['answers']);
            $manager->persist($question1);
        }

        $manager->flush();
    }
}
