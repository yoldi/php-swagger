<?php
/**
 * Yoldi © 2020
 * User: melodic
 */

declare(strict_types=1);

namespace Yoldi\Swagger;

use FilesystemIterator;
use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use ReflectionClass;
use ReflectionException;
use RegexIterator;

/**
 * need refactoring or best practice, stolen from doctrines class loader
 * @codeCoverageIgnore
 * @psalm-suppress all
 */
class ClassScanner
{


    private ?array $classNames = null;

    /**
     * Thanks to doctrine
     * @param array $directories
     * @return ReflectionClass[]
     * @throws ReflectionException
     */
    public function scan(array $directories): array
    {

        if ($this->classNames !== null) {
            return array_map(fn(string $class) => new ReflectionClass($class), $this->classNames);
        }

        $classes = [];
        $includedFiles = [];

        foreach ($directories as $path) {
            if (!is_dir($path)) {
                throw new InvalidArgumentException("Path $path must be dir");
            }

            $iterator = new RegexIterator(
                new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
                    RecursiveIteratorIterator::LEAVES_ONLY
                ),
                '/^.+' . preg_quote('php') . '$/i',
                RecursiveRegexIterator::GET_MATCH
            );

            foreach ($iterator as $file) {
                $sourceFile = $file[0];

                if (!preg_match('(^phar:)i', $sourceFile)) {
                    $sourceFile = realpath($sourceFile);
                }
                require_once $sourceFile;

                $includedFiles[] = $sourceFile;
            }
        }

        $declared = get_declared_classes();

        foreach ($declared as $className) {
            $rc = new ReflectionClass($className);
            $sourceFile = $rc->getFileName();
            if (!in_array($sourceFile, $includedFiles)) {
                continue;
            }

            $classes[] = $className;
        }

        $this->classNames = $classes;

        return array_map(fn(string $class) => new ReflectionClass($class), $classes);
    }
}
