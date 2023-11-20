const productFields = {
    DVD: [{ label: "DVD-Disc size (in MB)", id: "size" }],
    Book: [{ label: "Weight (in Kg)", id: "weight" }],
    Furniture: [
        { label: "Height", id: "height" },
        { label: "Width", id: "width" },
        { label: "Length", id: "length" }
    ]
};

function showAdditionalFields() {
    const productType = document.getElementById("productType").value;
    const additionalFieldsContainer = document.getElementById("additionalFieldsContainer");
    const message = document.getElementById("message");

    additionalFieldsContainer.innerHTML = "";

    productFields[productType].forEach(field => {
        const fieldContainer = document.createElement("div");
        fieldContainer.className = "form-group";
        fieldContainer.innerHTML = `
        <label for="${field.id}">${field.label}</label>
        <input type="text" class="form-control" id="${field.id}" name="${field.id}" oninput="validateField(this)">
        <span class="validation-message" id="${field.id}-validation-message"></span>
        `;
        additionalFieldsContainer.appendChild(fieldContainer);
    });

    var messages = {
      'DVD': 'Please, provide size',
      'Book': 'Please, provide weight.',
      'Furniture': 'Please, provide dimensions.'
    };

    message.innerText = messages[productType];

    document.getElementById("additionalFields").style.display = "block";
}