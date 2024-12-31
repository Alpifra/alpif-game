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
                'question' => "L'écrivaine connu pour avoir écrit la saga Harry Potter s'appelle JK Rowling, que signifie JK ?",
                'answers'  => [
                    ['answer' => 'Joanne Kathleen', 'valid' => true],
                    ['answer' => 'Joanne King', 'valid' => false],
                    ['answer' => 'Joanne Kenneth', 'valid' => false],
                    ['answer' => 'Joanne Kate', 'valid' => false],
                ]
            ],
            [
                'question' => "Parmi ces villes finistériennes, laquelle n'existe pas ?",
                'answers'  => [
                    ['answer' => 'Plougoulm', 'valid' => false],
                    ['answer' => 'Ploudiry', 'valid' => false],
                    ['answer' => 'Plouézan', 'valid' => true],
                    ['answer' => 'Plougar', 'valid' => false],
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
