<div class="stepsInput">
    <label>Steps:</label>
    <div class="step-input-container">
        <input type="text" name="step[]" placeholder="Step">
        <button type="button" class="add-step">+</button>
    </div>
</div>

<style>
    .stepsInput {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;

        label {
            display: block;
            font-weight: bold;
        }

        .step-input-container {
            width: 100%;
            display: grid;
            gap: 10px;
            grid-template-columns: 1fr 40px 40px;
            /* Space for add and remove buttons */
            place-content: center;

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

            .add-step,
            .remove-step {
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
                border: none;
                font-weight: bold;
            }

            .remove-step {
                background-color: #ff4c4c;
                color: #ffffff;
            }
        }
    }
</style>

<script>
    function addNewStepInput() {
        // Create a new step input container
        const newStepContainer = document.createElement('div');
        newStepContainer.classList.add('step-input-container');

        const stepInput = document.createElement('input');
        stepInput.type = 'text';
        stepInput.name = 'step[]'; // Use array syntax to handle multiple steps
        stepInput.placeholder = 'Step';

        const addButton = document.createElement('button');
        addButton.type = 'button';
        addButton.classList.add('add-step');
        addButton.textContent = '+'; // Button to add new steps

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('remove-step');
        removeButton.textContent = '-'; // Button to remove this step

        // Append the new input and buttons to the container
        newStepContainer.appendChild(stepInput);
        newStepContainer.appendChild(addButton);
        newStepContainer.appendChild(removeButton);

        // Append the new step input container to the main stepsInput div
        document.querySelector('.stepsInput').appendChild(newStepContainer);

        // Update all add-step buttons to only trigger for the last button
        updateAddStepListeners();

        // Add event listener for the remove button
        removeButton.addEventListener('click', () => {
            newStepContainer.remove(); // Remove the step input container
            updateAddStepListeners(); // Ensure add-step listeners are updated after removal
        });
    }

    function updateAddStepListeners() {
        const addButtons = document.querySelectorAll('.add-step');

        addButtons.forEach((button, index) => {
            button.removeEventListener('click', addNewStepInput); // Remove any previous event listeners
            if (index === addButtons.length - 1) { // Add listener only to the last button
                button.addEventListener('click', addNewStepInput);
            }
        });
    }

    // Initialize the first add-step button with the event listener
    updateAddStepListeners();
</script>