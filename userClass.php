<?php
    class User{
        public $id;
        public $username;
        public $displayName;
        public $created;

        function __construct($i, $un, $dn, $c){
            $this->id = $i;
            $this->username = $un;
            $this->displayName = $dn;
            $this->created = $c;
        }
    }
?>