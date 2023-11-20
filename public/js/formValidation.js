document.getElementById('product_form').addEventListener('submit', function (event) {
    if (!validateForm()) {
      event.preventDefault();
    }
  });

function validateField(input) {
    var inputValue = input.value.trim();
    var fieldName = input.id;
    var validationMessage = document.getElementById(`${fieldName}-validation-message`);

    if (!inputValue) {
        validationMessage.innerText = 'Please, submit required data.';
        return false;
    } else if (!isValidValue(inputValue)) {
        validationMessage.innerText = 'Please, provide data of indicated type.';
        return false;
    } else {
        return true;
    }
}

  function isValidValue(value) {
    return /^[a-zA-Z0-9#€$]{1,20}$/.test(value);
  }

  function validateForm() {
    var fields = ['sku', 'name', 'price', 'productType'];

    var isValid = true;

    fields.forEach(function (fieldName) {
      var input = document.getElementById(fieldName);
      var validationMessage = document.getElementById(`${fieldName}-validation-message`);

      if (!validateField(input)) {
        isValid = false;
      }
    });

    var productType = document.getElementById('productType');
    switch (productType.value) {
      case 'DVD':
      case 'Book':
      case 'Furniture':
        productFields[productType.value].forEach(field => {
          var input = document.getElementById(field.id);
          var validationMessage = document.getElementById(`${field.id}-validation-message`);

          if (!validateField(input)) {
            isValid = false;
          }
        });
        break;
      default:
        showValidationMessage('Invalid product type.', 'productType');
        isValid = false;
        break;
    }

    return isValid;
  }