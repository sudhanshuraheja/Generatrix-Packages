<?php

  class packages extends Model {
    public function __construct($database) {
      $this->construct($database, "packages", array(
				"id" => "int",
				"user" => "varchar_128",
				"repo" => "varchar_128",
				"description" => "varchar_2048",
				"is_approved" => "int",
				"created" => "int",
				"updated" => "int"
      ));
    }
  }

  class releases extends Model {
    public function __construct($database) {
      $this->construct($database, "releases", array(
				"id" => "int",
				"package" => "int",
				"tag" => "varchar_128",
				"created" => "int",
				"is_deleted" => "int"
      ));
    }
  }

?>