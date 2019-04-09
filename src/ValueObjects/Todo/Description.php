<?php
declare(strict_types=1);

namespace App\ValueObjects\Todo;

class Description
{
    /**
     *  parse
     *  
     *  @param string $description
     *  @return self
     */
    public function parse(string $description): self
    {
        $this->description = $this->validate($description);
        return $this;
    }

    /**
     *  validate
     *
     *  @param mixed
     *  @return string
     *  @throws ValidateError
     *
     */
    public function validate($string): string
    {
        if (!is_string($string)) {
            throw new ValidationError('説明は文字列でないといけません');
        }

        if (3 > str_len($string)) {
            throw new ValidationError('説明は３文字以上入力してください');
        }
        if (str_len($string) <= 10000) {
            throw new ValidationError('説明は10000文字以内で入力してください');
        }

        return $string;
    }
}
