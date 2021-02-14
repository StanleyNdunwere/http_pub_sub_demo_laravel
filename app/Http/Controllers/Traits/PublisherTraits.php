<?php

namespace App\Http\Controllers\Traits;

use App\Models\Subscription;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait PublisherTraits
{

  private function verifyThatTopicExists($topic_name)
  {
    return Subscription::where("topic", $topic_name)->get()->count() > 0;
  }

  private function sendMessageToSubscribers($sub_urls, $message_content)
  {
    $resp_arr = [];
    foreach ($sub_urls as $url) {
      Log::debug("$url => Starting request...");
      try {
        $response = Http::post($url, $message_content);
        $resp_arr[] = [
          "successful" => $response->successful(),
          "status_code" => $response->status(),
          "response_body" => $response->body(),
        ];
        Log::debug("$url => Completed request...");
      } catch (Exception $ex) {
        Log::debug("Connection to $url failed due to lack of internet connectivity. \n\n($ex)");
        $resp_arr[] = ["message" => "Failed to connect to $url. No internet"];
      }
    }
    return $resp_arr;
  }
}
