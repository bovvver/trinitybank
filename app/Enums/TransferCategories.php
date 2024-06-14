<?php

namespace App\Enums;

enum TransferCategories : string
{
    case EDUCATION = "Education";
    case FOOD = "Food";
    case HYGIENE = "Hygiene";
    case TRANSPORT = "Transport";
    case WORK = "Work";
    case INVESTMENTS = "Investments";
    case OTHERS = "Others";
}