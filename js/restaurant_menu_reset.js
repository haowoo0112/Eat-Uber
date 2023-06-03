// 獲取button元素
var buttonElement = document.getElementById("update-reset");

// 獲取form元素
var formElement = document.getElementById("update-form");

// 按下button時觸發的函式
buttonElement.addEventListener("click", function() {
  // 重設表單
  formElement.reset();
});
