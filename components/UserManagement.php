<div class="userManagementContainer">
    <div class="searchBar">
        <input type="text" placeholder="Enter the username" id="searchInput">
        <div class="searchBtn" onclick="fetchAllUsers()">
            <img src="../../assets/admin/search.svg" alt="Search Icon">
        </div>
    </div>

    <div class="userFetchContainer">
        <!-- Users will be dynamically populated here -->
    </div>
</div>

<style>
    div.userManagementContainer {
        height: 100%;
        display: grid;
        grid-template-rows: min-content 1fr;
        gap: 10px;
        padding: 10px;
    }

    div.searchBar {
        display: grid;
        grid-template-columns: 1fr 50px;
        gap: 5px;
        padding: 10px;
    }

    div.searchBar input {
        background: transparent;
        border: 1px solid #383736;
        border-radius: 50px;
        padding: 10px;
        font-size: 17px;
    }

    div.searchBtn {
        width: 100%;
        aspect-ratio: 1;
        background: blue;
        border-radius: 100px;
        padding: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    div.searchBtn img {
        width: 70%;
        aspect-ratio: 1;
    }

    /* Add styles for user list */
    div.userFetchContainer {
        padding: 10px;
        border: 1px solid #383736;
        border-radius: 10px;
        overflow-y: auto;
    }

    .userItem {
        background: #2c2c2c;
        padding: 10px;
        margin-bottom: 5px;
        border-radius: 5px;
        display: flex;
        justify-content: space-between;
    }
</style>
