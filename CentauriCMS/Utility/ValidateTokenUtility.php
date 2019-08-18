<?php

namespace CentauriCMS\Centauri\Utility;

class ValidateTokenUtility {
    /**
     * Validates a token given in a GET-request when returning a call_user_func
     * 
     * @return void
     */
    public function validate() {
        $request = Request();

        $sessionToken = $request->session()->token();
        $token = $request->input("_token");

        return ($sessionToken == $token);
    }
}
