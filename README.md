# Boarding Cards Sorting API

This PHP project provides an API for sorting a stack of unsorted boarding cards that represent different transportation segments on a journey from point A to point B. The API accepts an unsorted set of boarding cards, processes them, and generates a sorted list with step-by-step instructions for completing the journey.

## Project Overview

The main goal of this project is to create an internal API that can be used to organize and sort a list of boarding cards. Each boarding card contains information about the means of transportation (e.g., train, bus, flight), seat assignments, gates, and more. The API processes these cards and produces a sorted itinerary that guides travelers through their journey.

## Features

- Sorting of unordered boarding cards to create a coherent travel itinerary.
- Clear and human-readable instructions for each leg of the journey.
- Support for various modes of transportation, including trains, buses, and flights.
- Handling of seat assignments, gates, and baggage instructions when available.
- Input and output formats defined to ensure compatibility with different systems.

## API Endpoint

- Endpoint: `/index.php`
- Method: POST

## API Endpoint

- Endpoint: `/index.php`
- Method: POST

## Input

The API accepts an unordered collection of boarding cards in JSON format. The input format contains boarding card information such as departure, destination, mode of transportation, seat assignments, gates, and baggage instructions.

Example Input:

```json
{
  "data": [
    {
      "from": "Madrid",
      "to": "Barcelona",
      "transportation": "train",
      "transportation_number": "78A",
      "seat": "45B."
    },
    {
      "from": "Stockholm",
      "to": "New York JFK",
      "transportation": "flight",
      "transportation_number": "SK22",
      "seat": "7B",
      "gate": "22",
      "baggage_drop": "automatic"
    },
    {
      "from": "Gerona Airport",
      "to": "Stockholm",
      "transportation": "flight",
      "transportation_number": "SK455",
      "seat": "3A",
      "gate": "45B",
      "baggage_drop": "ticket counter 344."
    },
    {
      "from": "Barcelona",
      "to": "Gerona Airport",
      "transportation": "bus",
      "seat": ""
    }
  ]
}
```

## Output

The API responds with a sorted list of instructions for the journey. Each instruction includes details on how to proceed from one location to the next, along with any relevant information such as seat assignments and gates.

Example Output:

```json
{
  "Sorted Order": [
    "Take train 78A from Madrid to Barcelona , Sit in seat 45B.",
    "Take bus from Barcelona to Gerona Airport. No seat assignment.",
    "Form Gerona Airport take flight SK455 to Stockholm gate 45B, Sit in seat 3A. Baggage drop at ticket counter 344.",
    "Form Stockholm take flight SK22 to New York JFK gate 22, Sit in seat 7B. Baggage from your previous flight will be automatically transferred.",
    "You've arrived at your destination."
  ]
}
```

## Run

You can run this PHP file using PHP's built-in webserver by running the following command in terminal

```code
php -S localhost:8000 index.php

```

```curl
curl -X POST -H "Content-Type: application/json" -d @data.json http://localhost:8000

```
