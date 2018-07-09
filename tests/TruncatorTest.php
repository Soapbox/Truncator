<?php

namespace Tests\Unit\Helpers;

use PHPUnit\Framework\TestCase;
use SoapBox\Truncator\Truncator;

class TruncatorTest extends TestCase
{
    /**
     * @test
     */
    public function strings_shorter_than_the_max_length_are_not_truncated()
    {
        $value = Truncator::truncate('test string', 100);
        $this->assertEquals('test string', $value);
    }

    /**
     * @test
     */
    public function strings_of_equal_length_to_the_max_length_are_not_truncated()
    {
        $value = Truncator::truncate('test string', 11);
        $this->assertEquals('test string', $value);
    }

    /**
     * @test
     */
    public function strings_that_only_contain_one_word_are_cut_off_at_the_max_length()
    {
        $value = Truncator::truncate('test', 3);
        $this->assertEquals('tes...', $value);
    }

    /**
     * @test
     */
    public function strings_that_contain_muliple_words_are_truncated_at_the_end_of_a_word()
    {
        $value = Truncator::truncate('This is a test', 12);
        $this->assertEquals('This is a...', $value);
    }

    /**
     * @test
     */
    public function it_appends_the_suffix_when_the_string_is_truncated()
    {
        $value = Truncator::truncate('This is a test', 12, '!');
        $this->assertEquals('This is a!', $value);

        $value = Truncator::truncate('This is a test', 12, '');
        $this->assertEquals('This is a', $value);
    }

    /**
     * @test
     */
    public function it_returns_an_empty_string_when_given_an_empty_string()
    {
        $value = Truncator::truncate('', 1);
        $this->assertEquals('', $value);
    }

    /**
     * @test
     */
    public function it_properly_truncates_strings_to_the_specified_length()
    {
        $value = Truncator::truncate('n', 1);
        $this->assertEquals('n', $value);

        $value = Truncator::truncate('nn', 1);
        $this->assertEquals('n...', $value);

        $value = Truncator::truncate('nnn', 1);
        $this->assertEquals('n...', $value);

        $value = Truncator::truncate('n', 2);
        $this->assertEquals('n', $value);

        $value = Truncator::truncate('nn', 2);
        $this->assertEquals('nn', $value);

        $value = Truncator::truncate('nnn', 2);
        $this->assertEquals('nn...', $value);

        $value = Truncator::truncate('nnnn', 2);
        $this->assertEquals('nn...', $value);
    }

    /**
     * @test
     */
    public function it_properly_truncates_strings_to_the_nearest_space()
    {
        $value = Truncator::truncate('nn nn', 2);
        $this->assertEquals('nn...', $value);

        $value = Truncator::truncate('nn nn', 3);
        $this->assertEquals('nn...', $value);

        $value = Truncator::truncate('nn nn', 4);
        $this->assertEquals('nn...', $value);

        $value = Truncator::truncate('nn nn', 5);
        $this->assertEquals('nn nn', $value);

        $value = Truncator::truncate('n n nn', 3);
        $this->assertEquals('n n...', $value);

        $value = Truncator::truncate('n n nn', 4);
        $this->assertEquals('n n...', $value);

        $value = Truncator::truncate('n n nn', 5);
        $this->assertEquals('n n...', $value);

        $value = Truncator::truncate('n n nn', 6);
        $this->assertEquals('n n nn', $value);
    }

    /**
     * @test
     */
    public function it_properly_truncates_strings_with_multibyte_characets()
    {
        $value = Truncator::truncate('ñ', 1);
        $this->assertEquals('ñ', $value);

        $value = Truncator::truncate('ññ', 1);
        $this->assertEquals('ñ...', $value);

        $value = Truncator::truncate('ñññ', 1);
        $this->assertEquals('ñ...', $value);

        $value = Truncator::truncate('ñ', 2);
        $this->assertEquals('ñ', $value);

        $value = Truncator::truncate('ññ', 2);
        $this->assertEquals('ññ', $value);

        $value = Truncator::truncate('ñññ', 2);
        $this->assertEquals('ññ...', $value);

        $value = Truncator::truncate('ññññ', 2);
        $this->assertEquals('ññ...', $value);

        $value = Truncator::truncate('それは日本語のために働くのですか？', 7);
        $this->assertEquals('それは日本語の...', $value);

        $value = Truncator::truncate('سعدتبلقائك', 7);
        $this->assertEquals('سعدتبلق...', $value);
    }

    /**
     * @test
     */
    public function it_properly_truncates_multibyte_strings_to_the_nearest_space()
    {
        $value = Truncator::truncate('ññ ññ', 2);
        $this->assertEquals('ññ...', $value);

        $value = Truncator::truncate('ññ ññ', 3);
        $this->assertEquals('ññ...', $value);

        $value = Truncator::truncate('ññ ññ', 4);
        $this->assertEquals('ññ...', $value);

        $value = Truncator::truncate('ññ ññ', 5);
        $this->assertEquals('ññ ññ', $value);

        $value = Truncator::truncate('ñ ñ ññ', 3);
        $this->assertEquals('ñ ñ...', $value);

        $value = Truncator::truncate('ñ ñ ññ', 4);
        $this->assertEquals('ñ ñ...', $value);

        $value = Truncator::truncate('ñ ñ ññ', 5);
        $this->assertEquals('ñ ñ...', $value);

        $value = Truncator::truncate('ñ ñ ññ', 6);
        $this->assertEquals('ñ ñ ññ', $value);

        $value = Truncator::truncate('それは 日本語のために働くのですか？', 7);
        $this->assertEquals('それは...', $value);

        $value = Truncator::truncate('سعدت بلقائك', 7);
        $this->assertEquals('سعدت...', $value);
    }

    /**
     * @test
     */
    public function it_properly_truncates_strings_with_normal_and_multibyte_characets()
    {
        $value = Truncator::truncate('nñ', 1);
        $this->assertEquals('n...', $value);

        $value = Truncator::truncate('ñn', 1);
        $this->assertEquals('ñ...', $value);

        $value = Truncator::truncate('nñ', 2);
        $this->assertEquals('nñ', $value);

        $value = Truncator::truncate('ñn', 2);
        $this->assertEquals('ñn', $value);

        $value = Truncator::truncate('nnñ', 2);
        $this->assertEquals('nn...', $value);

        $value = Truncator::truncate('nñn', 2);
        $this->assertEquals('nñ...', $value);
    }

    /**
     * @test
     */
    public function it_properly_truncates_normal_and_multibyte_strings_to_the_nearest_space()
    {
        $value = Truncator::truncate('nñ ññ', 2);
        $this->assertEquals('nñ...', $value);

        $value = Truncator::truncate('ñn ññ', 2);
        $this->assertEquals('ñn...', $value);

        $value = Truncator::truncate('nñ ññ', 3);
        $this->assertEquals('nñ...', $value);

        $value = Truncator::truncate('ñn ññ', 3);
        $this->assertEquals('ñn...', $value);

        $value = Truncator::truncate('nñ nñ', 4);
        $this->assertEquals('nñ...', $value);

        $value = Truncator::truncate('ñn ñn', 4);
        $this->assertEquals('ñn...', $value);

        $value = Truncator::truncate('ñn ñn', 5);
        $this->assertEquals('ñn ñn', $value);

        $value = Truncator::truncate('ñ n ññ', 3);
        $this->assertEquals('ñ n...', $value);

        $value = Truncator::truncate('n ñ ññ', 3);
        $this->assertEquals('n ñ...', $value);

        $value = Truncator::truncate('ñ n ññ', 4);
        $this->assertEquals('ñ n...', $value);

        $value = Truncator::truncate('n ñ ññ', 4);
        $this->assertEquals('n ñ...', $value);
    }
}
