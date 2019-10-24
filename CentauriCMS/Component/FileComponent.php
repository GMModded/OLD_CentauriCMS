<?php

namespace CentauriCMS\Centauri\Component;

use \Illuminate\Support\Facades\DB;

class FileComponent {
    protected $table = "filereferences";

    public function findAll() {
        $files = DB::table($this->table)->select("*")->get();
        return $files;
    }

    public function findByUid($uid) {
        $file = DB::table($this->table)->select("*")->where("uid", $uid)->get()->first();
        return $file;
    }
}
