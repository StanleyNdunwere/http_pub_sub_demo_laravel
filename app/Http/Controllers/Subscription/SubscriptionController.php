<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\SubscriptionTraits;

class SubscriptionController extends Controller
{
	use SubscriptionTraits;

	public function index(Request $request)
	{
		$topic = $request->topic;
		return response()->json([
			"status" => "success",
			"message" => "Successfully retrieved all subscriptions for topic: $topic",
			"subscriptions" => Subscription::where("topic", $topic)->get(),
		]);
	}

	public function create(Request $request)
	{
		$topic = $request->topic;
		$url = $request->url;
		if (empty($url)) {
			return response()->json([
				"status" => "failed",
				"url" => $url,
				"message" => "you must specify the url that you want to subscribe this topic: $topic to",
			])->setStatusCode(401);
		}
		$sub = new Subscription();
		$sub->topic = $topic;
		$sub->subscriber_url = $url;
		$sub->save();

		return response()->json([
			"status" => "success",
			"message" => "you have successfully subscribed your url: $url to the topic: $topic",
			"record" => Subscription::where("id", $sub->id)->get(),
		]);
	}

	public function getAllSubscriptionsAndTopics()
	{
		$all_subs_topics = Subscription::all();
		$reduced = $this->reduceToTopicsToSubscribersUrl($all_subs_topics);
		return response()->json([
			"status" => "success",
			"data" => $reduced
		])->setStatusCode(200);
	}
}
