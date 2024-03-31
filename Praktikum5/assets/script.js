const display = document.querySelector("#display");
const buttons = document.querySelectorAll("button");

buttons.forEach((item) => {
  item.onclick = () => {
    if (item.id == "clear") {
      display.innerText = "";
    } else if (item.id == "backspace") {
      let string = display.innerText.toString();
      display.innerText = string.substr(0, string.length - 1);
    } else if (display.innerText != "" && item.id == "equal") {
      display.innerText = eval(display.innerText);
    } else if (display.innerText == "" && item.id == "equal") {
      display.innerText = "tidak ada operasi yang dijalankan!:)";
      setTimeout(() => (display.innerText = ""), 2000);
    } else if (item.classList.contains ("pressme")) { // Menambahkan kondisi untuk tombol "Selesai"
      thankYou(); // Memanggil fungsi thankYou() ketika tombol "Selesai" ditekan
    }else {
      display.innerText += item.id;
    }
  };
});

document.addEventListener('keydown', event => {
  const key = event.key;
  if (/[0-9]/.test(key)) {
    display.innerText += key;
  } else if (key === '+') {
    display.innerText += '+';
  } else if (key === '-') {
    display.innerText += '-';
  } else if (key === '*') {
    display.innerText += '*';
  } else if (key === '/') {
    display.innerText += '/';
  } else if (key === 'Enter') {
    display.innerText = eval(display.innerText);
  } else if (key === 'Backspace') {
    let string = display.innerText.toString();
    display.innerText = string.substr(0, string.length - 1);
  } else if ( key == 'c'){
    display.innerText = "";
}
});


const themeToggleBtn = document.querySelector(".theme-toggler");
const calculator = document.querySelector(".calculator");
const toggleIcon = document.querySelector(".toggler-icon");
let isDark = true;
themeToggleBtn.onclick = () => {
  calculator.classList.toggle("dark");
  themeToggleBtn.classList.toggle("active");
  isDark = !isDark;
};

function thankYou() {
  alert("Terima kasih sudah menggunakan kalkulator ini!");
  window.location.href = "menu_kalkulator.html";
}