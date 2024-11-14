<?php
declare(strict_types=1);

namespace Src\Container\Exceptions;

use Exception;
use Psr\Container\ContainerExceptionInterface;

class DependencyIsNotInstantiableException extends Exception implements ContainerExceptionInterface
{

}