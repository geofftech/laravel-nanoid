<?php
use Hidehalo\Nanoid\Client;

const CLEAN_ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

function nanoid(int $length = 32, string $alphabet = CLEAN_ALPHABET)
{
  $client = new Client();

  return $client->formattedId($alphabet, $length);
}
