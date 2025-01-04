<body>
    <div class="recipeFetchContainer">

    </div>
</body>

<style>
    .recipeFetchContainer {
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 10px;
    }

    .headingRow {
        color: white;
        border: 1px solid #676767;
        padding: 10px;
        margin-bottom: 5px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        display: grid;
        grid-template-columns: 50px 1fr 1fr 100px;

        & span {
            text-align: center;
        }
    }

    .recipeItem {
        background: #2c2c2c;
        padding: 10px;
        margin-bottom: 5px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        display: grid;
        grid-template-columns: 50px 1fr 1fr 100px;
        place-content: center;

        & span {
            text-align: center;
        }
    }

    .deleteRecipeBtn {
        width: 100%;
        background: red;
        color: white;
        padding: 7px;
        border: 1px solid white;
        border-radius: 10px;
    }
</style>