<?php
function getStars($total, $idx) {
    
    if ($total == 10) {
        switch ($idx) {
            case 1:
            case 2:
            case 3:
                return 5;
            case 4:
            case 5:
                return 4.5;
            case 6:
            case 7:
                return 4;
            case 8:
            case 9:
                return 3.5;
            case 10:
                return 3;
        }
    }
    
    if ($total == 9) {
        switch ($idx) {
            case 1:
            case 2:
                return 5;
            case 3:
            case 4:
                return 4.5;
            case 5:
            case 6:
                return 4;
            case 7:
            case 8:
                return 3.5;
            case 9:
                return 3;
        }
    }
    
    if ($total == 8) {
        switch ($idx) {
            case 1:
                return 5;
            case 2:
            case 3:
                return 4.5;
            case 4:
            case 5:
                return 4;
            case 6:
            case 7:
                return 3.5;
            case 8:
                return 3;
        }
    }
    
    if ($total == 7) {
        switch ($idx) {
            case 1:
                return 5;
            case 2:
            case 3:
                return 4.5;
            case 4:
            case 5:
                return 4;
            case 6:
                return 3.5;
            case 7:
                return 3;
        }
    }
    
    if ($total == 6) {
        switch ($idx) {
            case 1:
                return 5;
            case 2:
                return 4.5;
            case 3:
            case 4:
                return 4;
            case 5:
                return 3.5;
            case 6:
                return 3;
        }
    }
    
    if ($total == 5) {
        switch ($idx) {
            case 1:
                return 5;
            case 2:
                return 4.5;
            case 3:
                return 4;
            case 4:
                return 3.5;
            case 5:
                return 3;
        }
    }
    
    //echo " total : " . $total . " idx: " . $idx;
    
    return 1;
}

