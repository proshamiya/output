<?php

declare(strict_types=1);

namespace Output;

interface OutputInterface
{
  /**
   * Make a primary returnable value switch to current and previous output data
   * 
   * @param bool $currentValue
   * @return \Output\Output
   */
  public function makePrimary(bool $currentValue = true);

  /**
   * Reset the current value and temp value, And assign prev in previous current value
   * 
   * @param mixed $newValue
   * @return \Output\Output
   */
  public function reset($newValue = '');

  /**
   * Returns the original data
   * 
   * @return mixed
   */
  public function getOriginal();

  /**
   * Returns the current data value with original dataType, Its used to get final value
   * 
   * @return mixed
   */
  public function get();

  /**
   * Returns the previous data value with original dataType, Its used to get prev value
   * 
   * @return mixed
   */
  public function getPrev();

  /**
   * SET the previous value, Its used to getPrev with getting previous data
   * 
   * @param mixed $value
   * @return \Output\Output
   */
  public function setPrev($value = '');

  /**
   * Returns always all types of data to string format, Its used to get data only String format
   * Don't get output with original dataType,
   * 
   * @return string
   */
  public function toString() : string;

  /**
   * Returns always all types of data to string format, Its used to get data only String format
   * Don't get output with original dataType,
   * 
   * @param mixed $value
   * @return string
   */
  public static function String($value = '') : string;
}
?>