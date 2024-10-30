<div class="modal">

    <form method="post">

        <div class="addRecipeContainer">
            <!-- Thumbnail Image -->
            <div class="image">
                <label for="thumbnail">
                    <input type="file" name="thumbnail" id="thumbnail" hidden>

                    <img src="../../assets/home/camera.svg" alt="">
                    <span>Upload an image</span>
                </label>
            </div>

            <div class="formContainer">
                <input type="text" name="title" placeholder="Enter recipe title" id="title" required>

                <!-- Cuisine meal and servings -->
                <div class="cuisineMealRecipe">
                    <div class="cuisineContainer">
                        <label for="cuisine">Cuisine:</label>
                        <select name="cuisine" id="cuisine">
                            <?php
                            $cuisines = ["Indian", "Italian", "Chinese", "Mexican", "American"];
                            foreach ($cuisines as $cuisine) {
                                // Check if the cuisine is "Indian" to set it as selected
                                $selected = ($cuisine === "Indian") ? "selected" : "";
                                echo "<option value='$cuisine' $selected>$cuisine</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mealContainer">
                        <label for="meal">Meal:</label>
                        <select name="meal" id="meal">
                            <option value="breakfast" selected>Breakfast</option>
                            <option value="lunch">Lunch</option>
                            <option value="dinner">Dinner</option>
                            <option value="dessert">Dessert</option>
                        </select>
                    </div>

                    <div class="servingContainer">
                        <label for="servings">Servings:</label>
                        <input type="number" name="servings" id="servings" min="1" max="10" placeholder="1">
                    </div>
                </div>

                <?php
                require("IngredientInput.php");
                ?>

                <?php
                require("StepsInput.php");
                ?>

                <?php
                require("TipsInput.php");
                ?>

            </div>
        </div>

        <button type="submit" name="add-recipe">
            Add Recipe
        </button>
    </form>
</div>

<style>
    /* Modal */
    div.modal {
        width: 100vw;
        height: 100vh;
        position: absolute;
        background: #00000089;
        z-index: 1000;
        display: none;
        color: white;
        place-items: center;

        & form {
            position: relative;
            width: 50%;
            height: 75%;
            border-radius: 20px;
            padding: 20px;
            background: #2f2f2f;
            overflow-y: scroll;

            & div.addRecipeContainer {
                width: 100%;
                height: 100%;

                & div.image {
                    width: 100%;
                    height: 250px;
                    background: #676767;
                    border-radius: 10px 10px 0 0;

                    & label {
                        width: 100%;
                        height: 100%;
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                        font-size: 12px;

                        & img {
                            width: 120px;
                            aspect-ratio: 1;
                        }
                    }
                }

                & div.formContainer {
                    width: 100%;
                    height: 100%;
                    padding: 20px 0;

                    & input#title {
                        width: 100%;
                        padding: 10px;
                        border: none;
                        border-bottom: 2px solid #ff8e26;
                        background: transparent;
                        font-size: 24px;
                    }

                    & div.cuisineMealRecipe {
                        padding: 10px 0;
                        display: flex;
                        flex-direction: column;
                        gap: 10px;

                        & div.cuisineContainer,
                        & div.mealContainer,
                        & div.servingContainer {
                            display: flex;
                            align-items: center;

                            & label {
                                width: 200px;
                            }

                            & select,
                            & input {
                                padding: 10px;
                                background: transparent;
                                color: #fff;
                                flex: 1;
                                outline: none;
                                border: none;
                                border-bottom: 2px solid #ff8e26;
                                font-size: 15px;

                                & option {
                                    background: #ff8e26;
                                }
                            }
                        }
                    }
                }
            }

            & button.add-recipe {
                width: 100%;
                padding: 20px;
                background: green;
                position: fixed;
                bottom: 0;
            }
        }
    }
</style>