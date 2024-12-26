<?php 

enum QuestionType: string
{

    case single   = "Multiple propositions - single answer";
    case multiple = "Multiple propositions - multiple answers";
    case text     = "Input text as answer";
    case petitBac = "Specific Petit Bac question";

}