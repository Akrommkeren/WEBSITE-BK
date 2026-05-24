// REGISTER
function register() {
  let email = document.getElementById("email").value;
  let password = document.getElementById("password").value;

  if (!email || !password) {
    alert("Isi semua field!");
    return;
  }

  let users = JSON.parse(localStorage.getItem("users")) || [];

  let exists = users.find(u => u.email === email);

  if (exists) {
    alert("Email sudah terdaftar!");
    return;
  }

  users.push({ email, password });
  localStorage.setItem("users", JSON.stringify(users));

  alert("Registrasi berhasil!");
  window.location.href = "login.html";
}


// LOGIN
function login() {
  let email = document.getElementById("email").value.trim();
  let password = document.getElementById("password").value.trim();

  if (!email || !password) {
    alert("Email dan password wajib diisi!");
    return;
  }

  let users = JSON.parse(localStorage.getItem("users")) || [];

  let user = users.find(u => u.email === email && u.password === password);

  if (user) {
    localStorage.setItem("currentUser", JSON.stringify(user));
    window.location.href = "dashboard.html";
  } else {
    alert("Email atau password salah!");
  }
}