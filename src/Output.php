<?php

declare(strict_types=1);

namespace Output;

use Output\Codec;

class Output extends Codec implements OutputInterface
{
  /**
   * The $original variable represents the original current data
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
   * Create Output instance and call parent::__construct($value) of \Output\Codec class
   * 
   * @param mixed $value
   * @param mixed $prev
   * 
   * @return void
   */
  public function __construct($value, $prev = null)
  {
    $this->original = $value;
    $this->value    = $value;
    $this->prev     = $prev;
    parent::__construct($value);
  }

  /**
   * Returns the current data value with original dataType,
   * Its used to get final value
   * If given param $key then return existing key arr-val
   * if value is Associative array.
   * 
   * @param string $key
   * @return mixed
   */
  protected function get(?string $key = null)
  {
    return \is_array($this->value) && $key != null ? $this->value[$key] ?? false : $this->value;
  }

  /**
   * Make a primary returnable value switch to current and previous output data
   * 
   * @param bool $currentValue
   * @return \Output\Output
   */
  protected function makePrimary(bool $currentValue = true)
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
  protected function getOriginal()
  {
    return $this->original;
  }

  /**
   * SET the previous value, Its used to getPrev with getting previous data
   * 
   * @param mixed $value
   * @return \Output\Output
   */
  protected function setPrev($value)
  {
    $this->prev = $value;
    return $this;
  }

  /**
   * Prints human-readable information about a variable
   * 
   * @param bool $returns
   * @return mixed
   */
  public function print(bool $returns = false)
  {
    return \print_r($this->value);
  }

  /**
   * Equivalent to exit/die Stop next execute PHP Code
   * @return void
   */
  public function die()
  {
    die($this->toString());
  }

  /**
   * Returns the previous data value with original dataType, Its used to get prev value
   * 
   * @return mixed
   */
  protected function getPrev()
  {
    return $this->prev;
  }

  /**
   * Method finish work as same get()
   * Returns the previous data value with original dataType, Its used to get prev value
   * 
   * @return mixed
   */
  public function finish()
  {
    return $this->get();
  }

  /**
   * Reset the current value and temp value, And assign prev in previous current value
   * 
   * @param mixed $newValue
   * @return \Output\Output
   */
  protected function reset($newValue)
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
  protected static function String($value = '') : string
  {
    return \is_array($value) ? \implode(',', $value) : (string) (\is_object($value) ? $value::class : $value);
  }
}
?>