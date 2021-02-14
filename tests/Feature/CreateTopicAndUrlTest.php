<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateTopicAndUrlTest extends TestCase
{
  use DatabaseTransactions;

  public function testSubscribeToTopic()
  {
    $response = $this->post('/subscribe/pay-house', ["url" => "jalinga.com"]);
    $this->assertDatabaseHas('subscriptions', [
      'topic' => 'pay-house',
      'subscriber_url' => 'jalinga.com'
    ]);
    $response->assertStatus(200);
    $response->assertJson(['status' => 'success']);
  }

  public function testRetrieveAllSubscriptions()
  {
    $response = $this->get("subscribe/test-topic");
    $response->assertStatus(200);
    $response->assertJson([
      "status" => "success",
      "message" => "Successfully retrieved all subscriptions for topic: test-topic",
    ]);
  }

  public function testRetrieveAllTopicsToSubscriptionUrl()
  {
    $response = $this->get("subscribe/all");
    $response->assertStatus(200);
    $response->assertJson([
      "status" => "success",
      "data" => [],
    ]);
  }

  public function testEmptySubscriptionUrl()
  {
    $response = $this->post('/subscribe/random', []);
    $this->assertDatabaseMissing('subscriptions', [
      'topic' => 'random',
      'subscriber_url' => ''
    ]);
    $response->assertStatus(401);
    $response->assertJson(['status' => 'failed']);
  }
}
