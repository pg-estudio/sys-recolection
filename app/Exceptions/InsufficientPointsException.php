<?php

namespace App\Exceptions;

use Exception;

class InsufficientPointsException extends Exception
{
    public function __construct($message = "No tienes suficientes puntos para esta recompensa.", $code = 0, Exception $previous = null)
    {
        parent::__construct(__($message), $code, $previous);
    }
}