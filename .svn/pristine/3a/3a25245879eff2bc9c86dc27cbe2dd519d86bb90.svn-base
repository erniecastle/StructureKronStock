<?php

// a function for comparing two float numbers  
// float 1 - The first number  
// float 2 - The number to compare against the first  
// operator - The operator. Valid options are =, <=, <, >=, >, <>, eq, lt, lte, gt, gte, ne

function compareFloatNumbers($float1, $float2, $operator = '=') {
    // Check numbers to 5 digits of precision  
    $epsilon = 0.00001;

    $float1 = (float) $float1;
    $float2 = (float) $float2;

    switch ($operator) {
        // equal  
        case "=":
        case "eq": {
                if (abs($float1 - $float2) < $epsilon) {
                    return true;
                }
                break;
            }
        // less than  
        case "<":
        case "lt": {
                if (abs($float1 - $float2) < $epsilon) {
                    return false;
                } else {
                    if ($float1 < $float2) {
                        return true;
                    }
                }
                break;
            }
        // less than or equal  
        case "<=":
        case "lte": {
                if (compareFloatNumbers($float1, $float2, '<') || compareFloatNumbers($float1, $float2, '=')) {
                    return true;
                }
                break;
            }
        // greater than  
        case ">":
        case "gt": {
                if (abs($float1 - $float2) < $epsilon) {
                    return false;
                } else {
                    if ($float1 > $float2) {
                        return true;
                    }
                }
                break;
            }
        // greater than or equal  
        case ">=":
        case "gte": {
                if (compareFloatNumbers($float1, $float2, '>') || compareFloatNumbers($float1, $float2, '=')) {
                    return true;
                }
                break;
            }
        case "<>":
        case "!=":
        case "ne": {
                if (abs($float1 - $float2) > $epsilon) {
                    return true;
                }
                break;
            }
        default: {
                die("Unknown operator '" . $operator . "' in compareFloatNumbers()");
            }
    }

    return false;
}
