<?php
declare(strict_types=1);

namespace Framework\Container\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundContainerException extends Exception implements NotFoundExceptionInterface
{

}