<?php
session_start();
session_destroy();
echo "Logging out. Please wait a moment.";
header("Refresh:2; URL=index.html")

?>