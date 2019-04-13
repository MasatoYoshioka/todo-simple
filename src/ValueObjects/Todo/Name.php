<?php
declare(strict_types=1);

namespace App\ValueObjects\Todo;

use App\Exceptions\ValidationError;


/**
 * Name 
 * 
 * @package App\ValueObjects\Todo;
 */
class Name
{
    /** @var string **/
    private $name;

    /**
     * parse 
     * 
     * @param string $name 
     *
     * @return self
     */
    public function parse(string $name): self
    {
        $this->name = $this->validate($name);
        return $this;
    }

    /**
     * __toString 
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     *  validate
     *
     *  @param mixed $string
     *  @return string
     *  @throws ValidationError
     *
     */
    private function validate($string): string
    {
        if (!is_string($string)) {
            throw new ValidationError('名前は文字列でないといけません');
        }

        if (3 > strlen($string)) {
            throw new ValidationError('名前は３文字以上入力してください');
        }

        if (strlen($string) <= 100) {
            throw new ValidationError('名前は100文字以内で入力してください');
        }

        return $string;
    }
}
