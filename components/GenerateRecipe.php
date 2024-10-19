<div class="container">
    <form action="" class="advanced-features">
        <div>
            <label for="cuisine">Cuisine</label>
            <select name="cuisine" id="cuisine">
                <?php
                $cuisines = ["Indian", "Italian", "Chinese", "Mexican", "American"];
                foreach ($cuisines as $cuisine) {
                    $selected = ($cuisine === "Indian") ? "selected" : "";
                    echo "<option value='" . $cuisine . "' $selected>" . $cuisine . "</option>";
                }
                ?>

            </select>
        </div>
        <div>
            <label for="meal">Select Meal</label>
            <select name="meal" id="meal">
                <option value="breakfast" selected>Breakfast</option>
                <option value="lunch">Lunch</option>
                <option value="dinner">Dinner</option>
                <option value="dessert">Dessert</option>
            </select>
        </div>
        <div>
            <label for="servings-select">Servings</label>
            <select name="servings" id="servings-select">
                <option value="1" selected>1 Serving</option>
                <option value="2">2 Servings</option>
                <option value="3">3 Servings</option>
                <option value="4">4 Servings</option>
                <option value="5">5 Servings</option>
                <option value="6">6 Servings</option>
                <option value="7">7 Servings</option>
                <option value="8">8 Servings</option>
                <option value="9">9 Servings</option>
                <option value="10">10 Servings</option>
            </select>
        </div>
    </form>
    <div class="chat_box">
        <div class="output"></div>
        <div class="search_btn">
            <form action="" name="ingredients-form" class="ingredients-form">
                <input type="text" id="search_box" placeholder="Enter ingredients separated by comma">
                <button type="submit" class="plane_btn">
                    <img src="../../assets/home/paper-plane.svg" alt="">
                </button>
            </form>
        </div>
    </div>
</div>