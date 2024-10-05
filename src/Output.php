<?php

declare(strict_types=1);

namespace Output;

use Output\Codec;

class Output extends Codec implements OutputInterface
{
  /**
   * 
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
   * @param bool $currentValue
   * @return mixed
   */
  public function makePrimary(bool $currentValue = true)
  {
    $this->temp  = !$currentValue ? $this->value : $this->temp;
    $this->value = $currentValue ? $this->temp ?? $this->value : $this->prev;
    return $this;
  }

  /**
   * 
   * @return mixed
   */
  public function getOriginal()
  {
    return $this->original;
  }

  /**
   * @param mixed $value
   * @return \Output\Output
   */
  public function setPrev($value = '')
  {
    $this->prev = $value;
    return $this;
  }

  /**
   * 
   * 
   * @return mixed
   */
  public function get()
  {
    return $this->value;
  }

  /**
   * 
   * 
   * @return mixed
   */
  public function getPrev()
  {
    return $this->prev;
  }

  /**
   * 
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
   * 
   * 
   * @return string
   */
  public function toString() : string
  {
    return self::String($this->value);
  }

  /**
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