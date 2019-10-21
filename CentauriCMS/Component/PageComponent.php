<?php

namespace CentauriCMS\Centauri\Component;

use Illuminate\Support\Facades\App;

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

        $elementComponent = new \CentauriCMS\Centauri\Component\ElementComponent;
        $datasaverUtility = new \CentauriCMS\Centauri\Utility\DatasaverUtility;

        if(explode("/", $uri)[0] == "centauri") {
            $language = explode("/", $uri)[1] ?? "en";
            App::setLocale($language);

            $loggedIn = $request->session()->get("LOGGED_IN");

            $languageComponent = new \CentauriCMS\Centauri\Component\LanguageComponent;
            $languages = $languageComponent->findAll();

            if(is_null($loggedIn)) {
                return view("Backend.Templates.login", [
                    "data" => [
                        "_ENV" => $_ENV,

                        "languages" => $languages,

                        "label" => [
                            "state" => "Login"
                        ]
                    ]
                ]);
            } else {
                $modules = $datasaverUtility->findByType("modules");
                $sessionToken = $request->session()->get("_token");

                return view("Backend.Templates.centauri", [
                    "data" => [
                        "_ENV" => $_ENV,

                        "token" => $sessionToken,
                        "languages" => $languages,

                        "label" => [
                            "state" => "Backend"
                        ],

                        "modules" => $modules
                    ]
                ]);
            }
        } else {
            $page = $this->findByUri($uri);

            if(is_null($page)) {
                $config = \CentauriCMS\Centauri\Utility\ConfigUtility::get();

                if(isset($config["hooks"]["404"])) {
                    $notFoundHook = null;

                    if(strpos($config["hooks"]["404"], "::") !== false) {
                        $notFoundHook = explode("::", $config["hooks"]["404"]);
                    }

                    if(strpos($config["hooks"]["404"], "->") !== false) {
                        $notFoundHook = explode("->", $config["hooks"]["404"]);
                    }

                    if(is_null($notFoundHook)) {
                        throw new \Exception("NotFoundHook can't be null!");
                    }

                    $class = $notFoundHook[0];
                    $action = $notFoundHook[1];

                    call_user_func([
                        $Centauri::makeInstance($class),
                        ucfirst($action)
                    ], $request);
                }

                return $page;
            }

            $pid = $page->pid;
            $elements = $elementComponent->findByPid($pid);

            $renderingComponent = new \CentauriCMS\Centauri\Component\RenderingComponent;
            return $renderingComponent->renderFrontend($page, $elements, []);
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
    public function findByUri($uri) {
        $pages = $this->findAll();

        foreach($pages as $page) {
            if(strpos($page->urlmasks, ",") !== false) {
                $urlmasks = explode(",", $page->urlmasks);

                foreach($urlmasks as $urlmaskitem) {
                    $urlmaskitem = trim($urlmaskitem);

                    if(strtolower($urlmaskitem) == strtolower($uri)) {
                        return $page;
                    }
                }
            } else {
                if(strtolower($page->urlmasks) == strtolower($uri)) {
                    return $page;
                }
            }
        }

        return;
    }

    /**
     * Returns a page by its uid
     * 
     * @param int $uid
     * 
     * @return void
     */
    public function findByUid($uid) {
        $page = \Illuminate\Support\Facades\DB::table("pages")->select("*")->where("uid", $uid)->get()->first();
        return $page;
    }

    /**
     * Returns a page by its pid
     * 
     * @param int $pid
     * 
     * @return void
     */
    public function findByPid($pid) {
        $page = \Illuminate\Support\Facades\DB::table("pages")->select("*")->where("pid", $pid)->get()->first();
        return $page;
    }

    public function findAll() {
        $pages = \Illuminate\Support\Facades\DB::table("pages")->select("*")->get();
        return $pages;
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

        $filtered = false;
        foreach($nodes as $node) {
            if(in_array($node, $this->validateNodes)) {
                $filtered = true;

                $validateTokenUtility = new \CentauriCMS\Centauri\Utility\ValidateTokenUtility;
                $validated = $validateTokenUtility->validate();
    
                if(!$validated) return json_encode(["error" => "Token expired."]);

                break;
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

    /**
     * Returns the page with additional datas e.g. publicUrl or pid etc.
     * 
     * @param array $page
     * @param null|int|string $pid
     * 
     * @return void
     */
    public function getPageDatas($page, $pid = null) {
        $pathsUtility = new \CentauriCMS\Centauri\Utility\PathsUtility;
        $rootPath = $pathsUtility->rootPath();

        $segment = $page["urlmask"];
        if(is_countable($segment) && count($segment) > 1) {
            foreach($segment as $pathsegment) { if($pathsegment != "/") $segment = $pathsegment; }
        }

        $url = $rootPath . $segment;

        $page["publicUrl"] = $url;
        $page["pid"] = $pid;

        return $page;
    }
}
