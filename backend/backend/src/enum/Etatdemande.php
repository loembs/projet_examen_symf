<?php

namespace App\enum;

enum Etatdemande: string
{
    case EN_COURS = 'EN_COURS';
    case ACCEPTEE = 'ACCEPTEE';
    case ANNULEE = 'ANNULEE';
}
