let exploreBtn = document.querySelector(".explore");

exploreBtn.addEventListener("click", function () {

    let localstorageItem = localStorage.getItem("user");

    if (userSession || localStorageItem) {
        
        window.location.href = "homepage.php"; // Replace with the actual homepage URL
    } else {
        // If neither exists, redirect to the login page
        window.location.href = "login.php"; // Replace with the actual login page URL
    }

});