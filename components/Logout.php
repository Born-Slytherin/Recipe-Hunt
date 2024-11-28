<?php
$userName = $_COOKIE['user'];

if (!$userName) {
    header("Location: ../login/index.php");
    exit;
}
?>

<div class="logout">
    <span id="userName" onclick="toggleLogoutDiv()" style="color: black; text-align:center;">Hi <span style="color: red;"><?php echo $userName ?></span></span>
    <div id="logoutDiv" style="display: none;">
        <div style="width: 100%; height: 1px; background: #00000080"></div>
        <button onclick="logout()" class="logoutBtn">Logout</button>
    </div>
</div>

<style>
    div.logout {
        position: fixed;
        right: 20px;
        top: 25px;
        z-index: 1000;
        background: whitesmoke;
        height: max-content;
        border-radius: 10px;
        padding: 5px;
        width: 125px;
        display: flex;
        flex-direction: column;
        font-size: 20px;
    }

    #logoutDiv {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    button.logoutBtn {
        background: red;
        color: white;
        width: 100%;
        padding: 3px;
        border-radius: 3px;
        border: none;
    }
</style>

<script>
    function toggleLogoutDiv() {
        const logoutDiv = document.getElementById("logoutDiv");
        logoutDiv.style.display = logoutDiv.style.display === "none" ? "flex" : "none";
    }

    function logout() {
        document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        location.reload();
    }
</script>