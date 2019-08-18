<?php

namespace CentauriCMS\Centauri\Component;

use Illuminate\Support\Facades\App;

use \CentauriCMS\Centauri\Utility\DatasaverUtility;

class PageComponent {
    protected $validateNodes = [
        "action",
        "ajax"
    ];

    /**
     * Core functionality of the PageComponent which handles
     * general web-requests from the web-route
     * 
     * @param string $uri
     * 
     * @return void
     */
    public function handle($uri) {
        $Centauri = new \CentauriCMS\Centauri\Centauri;
        $request = Request();

        $filteredUri = $this->filteredUri($uri, $request);
        if($filteredUri != false) return $filteredUri;

        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;

        if(explode("/", $uri)[0] == "centauri") {
            $language = explode("/", $uri)[1] ?? "en";
            App::setLocale($language);

            $loggedIn = $request->session()->get("LOGGED_IN");

            if(is_null($loggedIn)) {
                return view("Backend.Templates.login", [
                    "data" => [
                        "_ENV" => $_ENV,
                        "label" => ["state" => "Login"]
                    ]
                ]);
            } else {
                $modules = $datasaverUtility->findByType("modules");
                $sessionToken = $request->session()->get("_token");

                return view("Backend.Templates.centauri", [
                    "data" => [
                        "_ENV" => $_ENV,
                        "token" => $sessionToken,
                        "label" => ["state" => "Login"],
                        "modules" => $modules
                    ]
                ]);
            }
        } else {
            $languageUtility = new \CentauriCMS\Centauri\Utility\LanguageUtility;
            $languageUtility->updateLanguage($request, explode("/", $uri)[0]);

            $pages = $datasaverUtility->findByType("pages");
            $page = $this->getPage($uri);

            // Condition to catch "404"-page requests -> which ain't fit to the requested URI from the client
            if(is_null($page)) {
                $config = \CentauriCMS\Centauri\Utility\ConfigUtility::get();
                $notFoundHook = explode("::", $config["hooks"]["404"]);

                $action = $notFoundHook[1];
                $class = $notFoundHook[0];

                return call_user_func([
                    $Centauri::makeInstance($class),
                    ucfirst($action)
                ], $request);

                dd("404");
                return $page;
            }

            $elements = $datasaverUtility->findByType("elements", ["page" => $page]);

            $renderingComponent = new \CentauriCMS\Centauri\Component\RenderingComponent;
            return $renderingComponent->frontendRender($elements);
        }
    }

    /**
     * Getter which returns the current page
     * by finding its urlmask inside the pages.json
     * 
     * @param string $uri
     * 
     * @return NULL|array
     */
    public function getPage($uri) {
        $config = \CentauriCMS\Centauri\Utility\ConfigUtility::get();
        $iCC = $config["web"]["requests"]["urlMasks"]["ignoreCamelCase"];

        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;
        $pages = $datasaverUtility->findByType("pages");

        $page = NULL;

        foreach($pages as $key => $ipage) {
            $urlmask = $ipage["urlmask"];
            $count = gettype($urlmask) == "array" ? count($urlmask) : 1;

            if($iCC) {
                if($count > 1) {
                    foreach($urlmask as $um) {
                        if(strtolower($um) == strtolower($uri)) {
                            $ipage["uid"] = "$key";
                            $page = $ipage;
                            break;
                        }
                    }
                } else {
                    if(strtolower($urlmask) == strtolower($uri)) {
                        $ipage["uid"] = "$key";
                        $page = $ipage;
                        break;
                    }
                }
            } else {
                if($count > 1) {
                    foreach($urlmask as $um) {
                        if($um == $uri) {
                            $ipage["uid"] = "$key";
                            $page = $ipage;
                            break;
                        }
                    }
                } else {
                    if($urlmask == $uri) {
                        $ipage["uid"] = "$key";
                        $page = $ipage;
                        break;
                    }
                }
            }
        }

        return $page;
    }

    /**
     * Finds a page from the pages.json array by its uid
     * 
     * @param int|string $uid
     * 
     * @return array|null
     */
    public function findByUid($uid) {
        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;
        $pages = $datasaverUtility->findByType("pages");

        $page = isset($pages[$uid]) ? $pages[$uid] : NULL;
        return $page;
    }

    /**
     * Filtered actions - when using custom redirects for custom urlmasks etc.
     * PageComponent prios this function before the handle will be called
     * e.g. a "beforePageRender"-call.
     * 
     * @param string $uri
     * 
     * @return void
     */
    public function filteredUri($uri, $request) {
        $Centauri = new \CentauriCMS\Centauri\Centauri;
        $nodes = explode("/", $uri);

        if(in_array($nodes[0], $this->validateNodes)) {
            $validateTokenUtility = new \CentauriCMS\Centauri\Utility\ValidateTokenUtility;
            $validated = $validateTokenUtility->validate();

            if(!$validated) {
                return json_encode(["error" => "Token expired."]);
            }
        }

        switch($nodes[0]) {
            case "action":
                $action = $nodes[1];
                $class = "\CentauriCMS\Centauri\Action\\" . ucfirst($action) . "Action";

                return call_user_func([
                    $Centauri::makeInstance($class),
                    ucfirst($action)
                ], $request);
                break;

            case "ajax":
                $ajax = $nodes[1];
                $class = "\CentauriCMS\Centauri\Ajax\\" . ucfirst($ajax) . "Ajax";

                return call_user_func([
                    $Centauri::makeInstance($class),
                    ucfirst($ajax)
                ]);

            default:
                return false;
                break;
        }
    }
}
