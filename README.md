<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Publisher-Subscriber Demo

This small demo project simulates the core of a typical Publisher-Subscriber pattern in real-time and async processing. The publisher sends messages to subscribers registerd to the its instance.
As soon as the publisher receives any new requests or input, it promptly forwards them to the subscribers registered for that message signature -topics in this case.

## High Level Architecture
The Subscriptions and information are stored in a small sqlite database included in this repository. The entire architecture is HTTP/REST dependent. And asides the storage of the subscriptions the rest of the process is stateless i.e. once a message is published successfully, it is no longer stored in the system.

## Code Descriptions
Two key classes are the SubscriptionController and PublisherController that handle requests to their endpoints.

The SubscriptionController accepts new requests from external services (simulated via API calls) to subscribe/listen to specific topics. It promptly examines the subscription requests for any anomalies before registering them in the sqlite database. These anomalies are captured in the Feature tests included in the project.

The PublisherController handles all requests to publish a message to listening subscribers. Like the SubscriptionController it inspects the requests for any unexpected anomalies and if it finds none, it promptly sends them to the subscribers.

## Tests
The tests included in this project are Feature/Integration tests - hence they test a group of classes and methods in one run cycle to validate the functionality of a feature.
Both the Publishing and Subcription processes are tested and validated for correctness.
Some cases tested for include:
  ✓ subscribe to topic
  ✓ retrieve all subscriptions
  ✓ retrieve all topics to subscription url
  ✓ empty subscription url
  ✓ non existing topics
  ✓ empty broadcast message body
  ✓ successful broadcast to subscribers
## Running The Project
This project is written entirely in Laravel. To run it on your local machine, pull this project into your desired folder and open the project in any suitable IDE. Open the terminal/commandline in the root of the project and run the following:

```sh
composer install
```
This should run and pull all the dependencies of the project into their necessary folders. Next run the following:

```sh
php artisan serve
```
This will start up the project on port 8000 on your local machine. Once started you can find out if the project is running properly by visiting the link below:

```sh
http://localhost:8000/
```
An empty page showing the the status should appear reading thus: "Up and Running Correctly"

Now the application is ready to recieve requests.
##Endpoints and thier corresponding Payload:

### Create topic and subscription
```bash
POST REQUEST -> localhost:8000/subscribe/{topic} -- [topic can be replaced with any random string indicating the topic title]
body -> {
            "url": "test.com"
        }
GET REQUEST -> localhost:8000/subscribe/{topic} -- [returns all the subscribers to a specific topic if the topic exists]
GET REQUEST -> localhost:8000/subscribe/{topic} -- [returns all the subscribers to a specific topic if the topic exists]
```
### Publish to subscribers via specific topic
```bash
POST REQUEST -> localhost:8000/subscribe/all -[returns all the subscribers per topic]
body -> {
            "message": "Your base are belong to us"
        }
```
## License

The project is open-source and licensed under the [MIT license](https://opensource.org/licenses/MIT).
