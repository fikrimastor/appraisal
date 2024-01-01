<?php

namespace App\Exceptions\Teams;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TeamAccessDeniedException extends HttpException
{
    public static function forTeam(): self
    {
        $message = 'User does not have access to the team.';

        return new static(403, $message, null, []);
    }
}
