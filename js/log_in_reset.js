// 獲取button元素
var buttonElement = document.getElementById("profile-reset");

// 獲取form元素
var formElement = document.getElementById("profile-form");

// 按下button時觸發的函式
buttonElement.addEventListener("click", function() {
  // 重設表單
  formElement.reset();
});


// 獲取button元素
var buttonElement1 = document.getElementById("sign-reset");

// 獲取form元素
var formElement1 = document.getElementById("sign-form");

// 按下button時觸發的函式
buttonElement1.addEventListener("click", function() {
  // 重設表單
  formElement1.reset();
});

// 獲取button元素
var buttonElement2 = document.getElementById("change-reset");

// 獲取form元素
var formElement2 = document.getElementById("password-form");

// 按下button時觸發的函式
buttonElement2.addEventListener("click", function() {
  // 重設表單
  formElement2.reset();
});


var newPasswordElement = document.getElementById("new_password");
var confirmPasswordElement = document.getElementById("confirm_password");

function validatePassword() {
  var newPassword = newPasswordElement.value;
  var confirmPassword = confirmPasswordElement.value;

  if (newPassword !== confirmPassword) {
    confirmPasswordElement.setCustomValidity("Passwords do not match");
  } else {
    confirmPasswordElement.setCustomValidity("");
  }
}

// 監聽 confirm_password 欄位的輸入事件
confirmPasswordElement.addEventListener("input", validatePassword);