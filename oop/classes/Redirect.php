<?php

class Redirect {

    /**
     * redirect to locations
     *
     * @param null $location
     */
    public static function to($location = null) {
        if ($location) {

            if (is_numeric($location)) {
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        required('includes/errors/' . $location);
                        die();
                    break;
                }
            }

            header('Location: ' . $location . '.php'); die();
        }
    }


}