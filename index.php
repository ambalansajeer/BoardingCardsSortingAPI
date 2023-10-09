<?php

// curl -G "https://example.com/api/resource" --data-urlencode "items=one,two,three"




class AllBoardingCards
{
    public array $cards;
    function __construct($data)
    {
        foreach ($data['data'] as $key => $value) {
            $this->cards[] = new BoardingCard($value);
        }
    }


    function sortCards()
    {
        $count = count($this->cards);
        for ($i = 0; $i < $count - 1; $i++) {
            for ($j = 0; $j < $count - $i - 1; $j++) {
                if ($this->cards[$j]->from !== $this->cards[$j + 1]->to) {
                    // Swap the two boarding cards
                    $temp = $this->cards[$j];
                    $this->cards[$j] = $this->cards[$j + 1];
                    $this->cards[$j + 1] = $temp;
                }
            }
        }
        $this->cards = array_reverse($this->cards);
        $messages = [];
        foreach ($this->cards as $key => $value) {
            # code...
            $messages[] =  $value->createDescription();
        }
        $messages[] = "You've arrived at your destination.";
        return $messages;
    }
}

class BoardingCard
{
    public $from, $message, $to, $transportation, $transportation_number, $seat, $baggage_drop, $gate;
    function __construct($data)
    {
        $this->from  = $data['from'] ?? "";
        $this->to  = $data['to'] ?? "";
        $this->transportation  = $data['transportation'] ?? "";
        $this->transportation_number  = $data['transportation_number'] ?? "";
        $this->seat  = $data['seat'] ?? "";
        $this->gate  = $data['gate'] ?? "";
        $this->baggage_drop  = $data['baggage_drop'] ?? "";
    }

    function createDescription()
    {
        if (strtolower($this->transportation) === "train") {
            $arr[] = "Take";
            $arr[] = $this->transportation;
            $arr[] = $this->transportation_number;
            $arr[] = "from";
            $arr[] = ucfirst($this->from);
            $arr[] = "to";
            $arr[] = ucfirst($this->to);
            if ($this->seat) {
                $arr[] = ", Sit in seat " . $this->seat;
            }
            $this->message = implode(" ", array_filter($arr));
        } else if (strtolower($this->transportation) === "bus") {
            $arr[] = "Take";
            $arr[] = $this->transportation;
            $arr[] = $this->transportation_number;
            $arr[] = "from";
            $arr[] = ucfirst($this->from);
            $arr[] = "to";
            $arr[] = ucfirst($this->to) . ".";
            if ($this->seat) {
                $arr[] = ", Sit in seat " . $this->seat;
            } else {
                $arr[] = "No seat assignment.";
            }
            $this->message = implode(" ", array_filter($arr));
        } else if (strtolower($this->transportation) === "flight") {
            $arr[] = "Form";
            $arr[] = ucfirst($this->from);
            $arr[] = "take";
            $arr[] = $this->transportation;
            $arr[] = $this->transportation_number;
            $arr[] = "to";
            $arr[] = ucfirst($this->to);
            if ($this->gate) {
                $arr[] = "gate " . $this->gate . ",";
            }
            if ($this->seat) {
                $arr[] = "Sit in seat " . $this->seat . ".";
            }

            if ($this->baggage_drop) {
                if ($this->baggage_drop == "automatic") {
                    $arr[] = "Baggage from your previous flight will be automatically transferred.";
                } else
                    $arr[] = "Baggage drop at " . $this->baggage_drop;
            }
            $this->message = implode(" ", array_filter($arr));
        }
        return $this->message;
    }
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
// Define your API routes and logic

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle GET request
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data)) {
        // foreach ($data['data'] ?? [] as $one) {
        $all = new AllBoardingCards($data);
        // }
        $message = $all->sortCards();
        $response = [
            "Sorted Order" => $message
        ];
        echo json_encode($response);
    } else {
        // Invalid request
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
