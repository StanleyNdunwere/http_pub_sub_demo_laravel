<?php

namespace App\Http\Controllers\Traits;

trait SubscriptionTraits
{

  public function reduceToTopicsToSubscribersUrl($array)
  {
    if (count($array) < 1) {
      return [];
    }

    $reduced = [];

    for ($i = 0; $i < count($array); $i++) {
      if (!array_key_exists($array[$i]->topic, $reduced)) {
        $reduced[$array[$i]->topic] = [];
      }
      $reduced[$array[$i]->topic]
        = array_merge($reduced[$array[$i]->topic], [$array[$i]->subscriber_url]);
    }
    return $reduced;
  }
}
