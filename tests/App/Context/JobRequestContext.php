<?php

namespace App\Tests\App\Context;


trait JobRequestContext
{
    public static $validPayload = [
        "categoryId" => "804040",
        "userId" =>  "524",
        "locationId" =>  "1",
        "title" =>  "Umzug von Pankow nach Charlottenburg",
        "description" =>  "Ich brauche Hilfe. Ich muss nach Charlottenburg umziehen aber habe kein Auto dafür.",
        "requestedDateTime" =>  "2018-10-11T10:10:00Z",
    ];

    public static $invalidPayload = [
        "categoryId" => "804040",
        "userId" =>  "524",
        "locationId" =>  "999",
        "title" =>  "Umzug von Pankow nach Charlottenburg",
        "description" =>  "Ich brauche Hilfe. Ich muss nach Charlottenburg umziehen aber habe kein Auto dafür.",
        "requestedDateTime" =>  "2018-10-11T10:10:00Z",
    ];
}
