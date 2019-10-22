<?php

namespace CentauriCMS\Centauri\Component;

use \Illuminate\Support\Facades\DB;

class ElementComponent {
    public $defaultTableColumns = [
        "uid",
        "pid",
        "lid",
        "hidden",
        "CType",
        "position",
        "colPos"
    ];

    public function findByPid($pid) {
        $elements = DB::table("elements")
            ->select("*")
            ->where("pid", $pid)
            ->orderBy("position", "asc")
        ->get();

        return $elements;
    }

    public function findByPidLid($pid, $lid) {
        $elements = DB::table("elements")
            ->select("*")
            ->where([
                "pid" => $pid,
                "lid" => $lid
            ])
            ->orderBy("position", "asc")
        ->get();

        return $elements;
    }

    public function findByUid($uid) {
        $element = DB::table("elements")
            ->select("*")
            ->where("uid", $uid)
            ->orderBy("position", "asc")
        ->get()
        ->first();

        return $element;
    }

    public function findBy($pid, $colPos, $lid = null) {
        $elements = null;

        if(is_null($lid)) {
            $elements = DB::table("elements")
                ->select("*")
                ->where([
                    "pid" => $pid,
                    "colPos" => $colPos
                ])
                ->orderBy("position", "asc")
            ->get();
        }

        return $elements;
    }

    public function saveElementByElement($element) {
        foreach($element as $key => $value) {
            DB::table("elements")
                ->where("uid", $element->uid)
                ->update([
                    $key => $value
                ]);
        }

        return true;
    }

    public function removeByUid($uid) {
        DB::table("elements")
            ->where("uid", $uid)
        ->delete();

        return true;
    }
}
