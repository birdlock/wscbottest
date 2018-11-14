<?php
$db = parse_url(getenv("https://data.heroku.com/datastores/fd26cf23-b905-447f-868f-82d7ae70969e#"));
$db["path"] = ltrim($db["path"], "/");
?>