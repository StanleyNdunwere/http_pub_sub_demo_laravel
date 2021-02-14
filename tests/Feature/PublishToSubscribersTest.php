<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PublishToSubscribersTest extends TestCase
{
  use DatabaseTransactions;
  
  public function testNonExistingTopics()
  {
    $response = $this->post('/publish/missing-topic', ["url" => "hellow.com"]);
    $this->assertDatabaseMissing('subscriptions', [
      'topic' => 'missing-topic',
      'subscriber_url' => 'hellow.com'
    ]);
    $response->assertStatus(401);
    $response->assertJson(['status' => 'failed']);
  }

  public function testEmptyBroadcastMessageBody()
  {
    $response = $this->post('/publish/empty-topic', []);
    $this->assertDatabaseMissing('subscriptions', [
      'topic' => 'empty-topic',
    ]);
    $response->assertStatus(401);
    $response->assertJson(['status' => 'failed']);
  }


  public function testSuccessfulBroadCast()
  {
    $response = $this->post(
      '/subscribe/successful-topic',
      ["url" => "successful.com"]
    );
    $this->assertDatabaseHas('subscriptions', [
      'topic' => 'successful-topic',
      'subscriber_url' => 'successful.com'
    ]);
    $response->assertStatus(200);
    $response->assertJson(['status' => 'success']);
    $response_publish = $this->post(
      '/publish/successful-topic',
      ["message" => "your ship are belong to us"]
    );
    $response_publish->assertJson([
      "status" => "success",
      "message" => "Broadcasted messages successfully",
      "topic" => "successful-topic",
      "message_content" => ["message" => "your ship are belong to us"],
      "downline_subscribers" => ["successful.com"],
    ]);
    $response_publish->assertStatus(200);
  }
}
