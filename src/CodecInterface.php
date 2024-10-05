<?php

declare(strict_types=1);

namespace Output;

interface CodecInterface
{
  public function base64();
  public function gz();
  public function utf8();
  public function json();
  public function url();
  public function entitiy();
}
?>