<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PublisherTraits;
use App\Http\Controllers\Traits\SubscriptionTraits;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
	use SubscriptionTraits;
	use PublisherTraits;
	
	public function broadcastToSubscribers(Request $request)
	{
		$subscribers_url = [];
		$topic = $request->topic;
		if (empty($request->all())) {
			return response()->json([
				"status" => "failed",
				"message" => "Cannot broadcast empty messages to subscribers. Set a valid broadcast message and try again",
			])->setStatusCode(401);
		} else {
			$topic_exists = $this->verifyThatTopicExists($topic);

			if (!$topic_exists) {
				return response()->json([
					"status" => "failed",
					"message" => "The topic you want to publish to does not exist.",
				])->setStatusCode(401);
			} else {
				$all_subscribers = Subscription::where("topic", $topic)->get();
				$subscribers_url = $this->reduceToTopicsToSubscribersUrl($all_subscribers)[$topic];
				$response_sent = $this->sendMessageToSubscribers($subscribers_url, $request->all());

				return response()->json([
					"status" => "success",
					"message" => "Broadcasted messages successfully",
					"topic" => $topic,
					"message_content" => $request->all(),
					"downline_subscribers" => $subscribers_url,
				])->setStatusCode(200);
			}
		}
	}
}
