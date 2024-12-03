<div class="tipsInput">
    <label>Tips:</label>
    <div class="tip-input-group">
        <input type="text" name="tip[]" placeholder="Tip">
        <button type="button" class="add-tip">+</button>
    </div>
</div>

<style>
    .tipsInput {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;

        label {
            display: block;
            font-weight: bold;
        }

        .tip-input-group {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 40px 40px;
            place-content: center;
            gap: 10px;

            input {
                padding: 10px;
                height: 100%;
                box-sizing: border-box;
                background: #00000050;
                border: none;
                border-bottom: 1px solid #ff8e26;
                font-size: 15px;
                color: white;
            }

            button.add-tip {
                width: 100%;
                height: 100%;
                aspect-ratio: 1;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                background-color: #ffffff;
                color: #000000;
                cursor: pointer;
                font-weight: bold;
            }

            button.remove-tip {
                width: 100%;
                height: 100%;
                aspect-ratio: 1;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                background-color: #ff4c4c;
                color: #ffffff;
                cursor: pointer;
                font-weight: bold;
            }
        }
    }
</style>

<script>
    function addNewTipInput() {
        // Create a new input group for tips
        const newTipGroup = document.createElement('div');
        newTipGroup.classList.add('tip-input-group');

        const tipInput = document.createElement('input');
        tipInput.type = 'text';
        tipInput.name = 'tip[]'; // Use array syntax to handle multiple tips
        tipInput.placeholder = 'Tip';

        const addButton = document.createElement('button');
        addButton.type = 'button';
        addButton.classList.add('add-tip');
        addButton.textContent = '+';

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('remove-tip');
        removeButton.textContent = '-';

        newTipGroup.appendChild(tipInput);
        newTipGroup.appendChild(addButton);
        newTipGroup.appendChild(removeButton);

        document.querySelector('.tipsInput').appendChild(newTipGroup);

        // Update all add buttons to only trigger for the last button
        updateTipButtonListeners();

        // Add event listener for the remove button
        removeButton.addEventListener('click', () => {
            newTipGroup.remove(); // Remove the tip input group
            updateTipButtonListeners(); // Update listeners after removal
        });
    }

    function updateTipButtonListeners() {
        const addTipButtons = document.querySelectorAll('.add-tip');

        addTipButtons.forEach((button, index) => {
            button.removeEventListener('click', addNewTipInput); // Remove any previous event listeners
            if (index === addTipButtons.length - 1) { // Add listener only to the last button
                button.addEventListener('click', addNewTipInput);
            }
        });
    }

    // Initialize the first add button with the event listener
    updateTipButtonListeners();
</script>