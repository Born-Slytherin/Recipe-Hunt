<div class="modal">

    <form method="post"
    +>

        <!-- Thumbnail Image -->
        <div class="image">
            <label for="thumbnail">
                <input type="file" name="thumbnail" id="thumbnail" hidden>
            </label>
        </div>

        <div>
            <input type="text" name="title" placeholder="Enter recipe title" required>

            <!-- Cuisine meal and servings -->
            <div>
                <div>
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

                <div>
                    <label for="meal">Meal:</label>
                    <select name="meal" id="meal">
                        <option value="breakfast" selected>Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                        <option value="dessert">Dessert</option>
                    </select>
                </div>

                <div>
                    <label for="servings">Servings:</label>
                    <input type="number" name="servings" id="servings" min="1" max="10" placeholder="1">
                </div>
            </div>

            <div>

            </div>

        </div>

    </form>
</div>