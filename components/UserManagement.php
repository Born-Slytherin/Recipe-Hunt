<div class="userManagementContainer">
    <div class="searchBar">
        <input type="text" id="searchInput" placeholder="Search users...">
    </div>

    <div class="userFetchContainer">

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
        /* grid-template-columns: 1fr 50px;
        gap: 5px;
        padding: 10px; */

        & input {
            width: 30%;
            height: 50px;
        }
    }

    div.searchBar input {
        background: transparent;
        border: 1px solid #383736;
        border-radius: 50px;
        padding: 10px;
        font-size: 17px;
        color: white;
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
        align-items: center;
        justify-content: space-between;
    }

    button.deleteUserBtn {
        width: 80px;
        background: red;
        color: white;
        padding: 7px;
        border: 1px solid white;
        border-radius: 10px;
    }
</style>