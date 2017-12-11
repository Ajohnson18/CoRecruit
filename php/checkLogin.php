<?php
echo '
<script>
$(document).ready(function() {
var SNID = "'.$_COOKIE['SNIDCo'].'";
    if(SNID == "") {

        $(\'body\').html(`
        <center>
            <h1 class="display-3" style="margin-top: 40vh;">Uh Oh! You are not logged in!</h1>
        </center>
        `);

        setTimeout(function() {
            document.location.href = "index.php";
        }, 3000);
    }
});
</script>
';
?>