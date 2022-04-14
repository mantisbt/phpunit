<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework;

use RecursiveIterator;

/**
 * Iterator for test suites.
 */
class TestSuiteIterator implements RecursiveIterator
{
    /**
     * @var int
     */
    protected $position;

    /**
     * @var Test[]
     */
    protected $tests;

    /**
     * @param TestSuite $testSuite
     */
    public function __construct(TestSuite $testSuite)
    {
        $this->tests = $testSuite->tests();
    }

    /**
     * Rewinds the Iterator to the first element.
     */
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Checks if there is a current element after calls to rewind() or next().
     *
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        return $this->position < \count($this->tests);
    }

    /**
     * Returns the key of the current element.
     *
     * @return int
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->position;
    }

    /**
     * Returns the current element.
     *
     * @return Test
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->valid() ? $this->tests[$this->position] : null;
    }

    /**
     * Moves forward to next element.
     */
    #[\ReturnTypeWillChange]
    public function next()
    {
        $this->position++;
    }

    /**
     * Returns the sub iterator for the current element.
     *
     * @return TestSuiteIterator
     */
    #[\ReturnTypeWillChange]
    public function getChildren()
    {
        return new self(
            $this->tests[$this->position]
        );
    }

    /**
     * Checks whether the current element has children.
     *
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function hasChildren()
    {
        return $this->tests[$this->position] instanceof TestSuite;
    }
}
