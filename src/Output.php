<?php

declare(strict_types=1);

namespace Output;

use Output\Codec;

class Output extends Codec implements OutputInterface
{
  /**
   * The $original variable represents the original data
   * @var mixed
   */
  protected $original;

  /**
   * Stores the previous value for comparison the current data
   * 
   * @var mixed
   */
  protected $prev;
  
  /**
   * Returnable $value represents the current data
   * 
   * @var mixed
   */
  protected $value;

  /**
   * The $temp variable is used to store temporary data
   * 
   * @var mixed
   */
  protected $temp;

  /**
   * 
   * 
   * @param mixed $value
   * @return void
   */
  public function __construct($value = '')
  {
    $this->original = $value;
    $this->value    = $value;
    parent::__construct($value);
  }

  /**
   * Make a primary returnable value switch to current and previous output data
   * 
   * @param bool $currentValue
   * @return \Output\Output
   */
  public function makePrimary(bool $currentValue = true)
  {
    $this->temp  = !$currentValue ? $this->value : $this->temp;
    $this->value = $currentValue ? $this->temp ?? $this->value : $this->prev;
    return $this;
  }

  /**
   * Returns the original data
   * 
   * @return mixed
   */
  public function getOriginal()
  {
    return $this->original;
  }

  /**
   * SET the previous value, Its used to getPrev with getting previous data
   * 
   * @param mixed $value
   * @return \Output\Output
   */
  public function setPrev($value = '')
  {
    $this->prev = $value;
    return $this;
  }

  /**
   * Returns the current data value with original dataType, Its used to get final value
   * 
   * @return mixed
   */
  public function get()
  {
    return $this->value;
  }

  /**
   * Returns the previous data value with original dataType, Its used to get prev value
   * 
   * @return mixed
   */
  public function getPrev()
  {
    return $this->prev;
  }

  /**
   * Reset the current value and temp value, And assign prev in previous current value
   * 
   * @param mixed $newValue
   * @return \Output\Output
   */
  public function reset($newValue = '')
  {
    $this->prev = $this->value;
    $this->temp = '';
    return new self($newValue);
  }

  /**
   * Returns always all types of data to string format, Its used to get data only String format
   * Don't get output with original dataType,
   * 
   * @return string
   */
  public function toString() : string
  {
    return self::String($this->value);
  }

  /**
   * Returns always all types of data to string format, Its used to get data only String format
   * Don't get output with original dataType,
   * 
   * @param mixed $value
   * @return string
   */
  public static function String($value = '') : string
  {
    return \is_array($value) ? \implode(',', $value) : (string) (\is_object($value) ? $value::class : $value);
  }
}
?>