<?php

declare(strict_types=1);

namespace Output;

use Output\OutputPrint;

class Codec implements CodecInterface
{
  protected $Codec = [];
  protected $value;

  public function __construct($value = '')
  {
    $this->value = $value;
  }

  /**
   * 
   * @param array  $args
   * @param string $encoder
   * @param string $decoder
   * 
   * @return \Codec\Codec
   */
  private function register(array $args, $encoder, $decoder)
  {
    $this->Codec['encoder'] = $encoder;
    $this->Codec['decoder'] = $decoder;
    $this->Codec['args'] = $args;
    return $this;
  }

  /**
   * 
   * 
   * @param mixed $args [optional]
   * @return \Codec\Codec
   */
  public function json(...$args)
  {
    return $this->register($args, '\json_encode', '\json_decode');
  }

  /**
   * 
   * @param mixed $args [optional]
   * @return \Codec\Codec
   */
  public function url(...$args)
  {
    return $this->register($args, '\urlencode', '\urldecode');
  }

  /**
   * 
   * @param mixed $args [optional]
   * @return \Codec\Codec
   */
  public function utf8(...$args)
  {
    return $this->register($args, '\utf8_encode', '\utf8_decode');
  }

  /**
   * 
   * @param mixed $args [optional]
   * @return \Codec\Codec
   */
  public function gz(...$args)
  {
    return $this->register($args, '\gzencode', '\gzdecode');
  }

  /**
   * 
   * @param mixed $args [optional]
   * @return \Codec\Codec
   */
  public function base64(...$args)
  {
    return $this->register($args, '\base64_encode', '\base64_decode');
  }

  /**
   * 
   * @param mixed $args [optional]
   * @return \Codec\Codec
   */
  public function entitiy(...$args)
  {
    return $this->register($args,
      \function_exists('htmlentities') ? '\htmlentities' : '\htmlspecialchars',
      \function_exists('html_entity_decode') ? '\html_entity_decode' : '\htmlspecialchars_decode'
    );
  }

  /**
   * 
   * @param bool $encoding [optional]
   * @return string
   */
  public function encode(bool $encoding = true)
  {
    $this->setPrev($this->value);
    $args = $this->Codec['args'];
    \array_unshift($args, $this->value);
    return $encoding ? ($this->value = \call_user_func_array($this->Codec['encoder'], $args)) : $this->value;
  }

  /**
   * 
   * @param bool $decoding [optional]
   * @return string|false
   */
  public function decode(bool $decoding = true)
  {
    $this->setPrev($this->value);
    $args = $this->Codec['args'];
    \array_unshift($args, $this->value);
    return $decoding ? ($this->value = \call_user_func_array($this->Codec['decoder'], $args)) : $this->value;
  }
}
?>